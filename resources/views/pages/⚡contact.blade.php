<?php

use App\Mail\NewContactMessage;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;

// The Contact page: the form's data and logic, and the form itself.
// form is written directly in this page.
new class extends Component {
    // who is writing
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $reply_via = 'any';

    // what they need. "topic" can be pre-filled from a link such as /contact?topic=pickup
    #[Url(as: 'topic')]
    public string $topic = '';

    public string $destination = '';
    public string $pickup_city = '';
    public string $box_size = '';
    public string $message = '';

    public bool $consent = false;

    // honeypot: real people never see this field, bots fill it in
    public string $website = '';

    // success state
    public bool $sent = false;
    public string $sentName = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            // at least one way to reach the person
            'email' => ['nullable', 'required_without:phone', 'email:rfc', 'max:150'],
            'phone' => ['nullable', 'required_without:email', 'string', 'min:7', 'max:30', 'regex:/^[0-9+()\-\s.]+$/'],
            'reply_via' => ['required', Rule::in(array_keys(ContactMessage::replyOptions()))],
            'topic' => ['required', Rule::in(array_keys(ContactMessage::topics()))],
            'destination' => ['nullable', Rule::in(array_keys(ContactMessage::destinations()))],
            'pickup_city' => ['nullable', 'string', 'max:120'],
            'box_size' => ['nullable', Rule::in(array_keys(ContactMessage::boxSizes()))],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
            'consent' => ['accepted'],
        ];
    }

    protected function messages(): array
    {
        return [
            'email.required_without' => 'Please give us an email or a phone number so we can reply.',
            'phone.required_without' => 'Please give us a phone number or an email so we can reply.',
            'phone.regex' => 'Please use numbers only, for example +1 403 555 0123.',
            'topic.required' => 'Please choose what you need help with.',
            'topic.in' => 'Please choose what you need help with.',
            'message.min' => 'Please tell us a little more (at least 10 characters).',
            'consent.accepted' => 'Please tick the box so we know you are happy for us to contact you.',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'name' => 'name',
            'message' => 'message',
        ];
    }

    public function updated(string $property): void
    {
        // live feedback as people finish typing in a field
        if (in_array($property, ['name', 'email', 'phone', 'message'], true)) {
            $this->validateOnly($property);
        }
    }

    public function submit(): void
    {
        // Bots fill the hidden field. Pretend it worked and quietly do nothing.
        if ($this->website !== '') {
            $this->sent = true;
            $this->sentName = $this->name;

            return;
        }

        // Simple rate limit: 3 messages per 10 minutes per visitor.
        $key = 'contact-form:' . request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('message', 'You have sent a few messages already. Please wait a few minutes, or call or chat with us instead.');

            return;
        }

        $this->validate();

        RateLimiter::hit($key, 600);

        $contact = ContactMessage::create([
            'name' => trim($this->name),
            'email' => $this->email ?: null,
            'phone' => $this->phone ?: null,
            'reply_via' => $this->reply_via,
            'topic' => $this->topic,
            'destination' => $this->destination ?: null,
            'pickup_city' => $this->pickup_city ?: null,
            'box_size' => $this->box_size ?: null,
            'message' => trim($this->message),
            'status' => 'new',
            'ip_address' => request()->ip(),
        ]);

        // Email the team. If email is not set up yet, the message is still saved.
        if ($to = config('services.contact.to')) {
            try {
                Mail::to($to)->send(new NewContactMessage($contact));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $this->sentName = trim($this->name);
        $this->sent = true;

        $this->reset(['name', 'email', 'phone', 'reply_via', 'topic', 'destination', 'pickup_city', 'box_size', 'message', 'consent', 'website']);
        $this->resetValidation();
        $this->js("document.getElementById('message').scrollIntoView({ behavior: 'smooth', block: 'start' })");
    }

    public function sendAnother(): void
    {
        $this->sent = false;
        $this->sentName = '';
        $this->js("document.getElementById('message').scrollIntoView({ behavior: 'smooth', block: 'start' })");
    }
};
?>

<div class="mx-auto max-w-7xl">

    <x-hero eyebrow="We're here for you" title="Contact" highlight="us." subtitle="We're happy to help you send love home."
        button="Send us a message" url="#message" :points="['Friendly help', 'Clear answers', 'No pressure']" />


    <div class="my-10 grid items-start gap-8 lg:grid-cols-[1.35fr_1fr]">
    <x-contact-form :sent="$sent" :sent-name="$sentName" :topic="$topic" />
    <x-location class="lg:sticky lg:top-28" />
</div>
</div>
