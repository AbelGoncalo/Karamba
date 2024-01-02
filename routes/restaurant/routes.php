<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Company\HomeComponent;

Route::get('/dados/restaurante',HomeComponent::class)->name('restaurant.home')->middleware(['auth']);


