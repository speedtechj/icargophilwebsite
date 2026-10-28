<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::livewire('/', 'pages::home')->name('home');
Route::livewire('/services', 'pages::services')->name('services');
Route::livewire('/contact', 'pages::contact')->name('contact');
Route::livewire('/about', 'pages::about')->name('about');
Route::livewire('/ourwork', 'pages::ourwork')->name('ourwork');
Route::livewire('/partner', 'pages::partners')->name('partner');

Route::view('/privacy-policy', 'privacy');
Route::view('/terms', 'terms');
