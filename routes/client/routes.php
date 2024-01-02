<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Client\{ReviewComponent,MyOrderComponent,OrderComponent,HomeComponent,PaymentComponent};



Route::get('/local',HomeComponent::class)->name('client.home');
Route::get('/avaliar/atendimento',ReviewComponent::class)->name('client.review.services');
Route::get('/fazer/pedidos',OrderComponent::class)->name('client.orders')->middleware(['auth']);
Route::get('/meus/pedidos',MyOrderComponent::class)->name('client.my.orders')->middleware(['auth']);
Route::get('/realizar/pagamento',PaymentComponent::class)->name('client.payment.orders')->middleware(['auth']);
