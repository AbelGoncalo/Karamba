<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Chef\{DeliveryComponent, HomeComponent, MyAccount};

Route::get('/painel/chef',HomeComponent::class)->name('chefs.home')->middleware(['auth','chef']);
Route::get('/painel/chef/minha-conta',MyAccount::class)->name('chefs.account')->middleware(['auth','chef']);
Route::get('/painel/chef/encomendas',DeliveryComponent::class)->name('chefs.deliveries')->middleware(['auth','chef']);
