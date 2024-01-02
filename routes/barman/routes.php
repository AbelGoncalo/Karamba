<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Barman\{
    DeliveryComponent,
    HomeComponent,
    MyAccount,
};

Route::get('/painel/barman',HomeComponent::class)->name('barman.home')->middleware(['auth','barman']);
Route::get('/painel/barman/minha-conta',MyAccount::class)->name('barman.account')->middleware(['auth','barman']);


