<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Garçon\{
    HomeComponent,
    PaymentComponent,
    ViewOrderComponent,
    MyAccount,
    ShowOrder,
};

Route::get('/painel/garson',HomeComponent::class)->name('garson.home')->middleware(['auth','garson']);
Route::get('/g/realizar/pagamento',PaymentComponent::class)->name('garson.payment.orders')->middleware(['auth','garson']);
Route::get('/g/pedidos/anotados',ViewOrderComponent::class)->name('garson.orders')->middleware(['auth','garson']);
Route::get('/g/minha/conta',MyAccount::class)->name('garson.account')->middleware(['auth','garson']);
Route::get('/g/fluxo',ShowOrder::class)->name('garson.show.orders')->middleware(['auth','garson']);
// Route::get('/g/fluxo',ShowOrder::class)->name('garson.show.orders')->middleware(['auth','garson']);

