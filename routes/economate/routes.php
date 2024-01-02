<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Economate\{
    HomeComponent,
    CategoryComponent,
    CompartmentComponent,
    MyAccount,
    ProductComponent,
    ProviderComponent,
    StockEnterComponent,
    StockOutComponent,
    OrderComponent,
    ReportComponent
};

Route::get('/painel/economato/home/',HomeComponent::class)->name('economate.panel.home')->middleware(['auth','economate']);
Route::get('/painel/economato/categoria/',CategoryComponent::class)->name('economate.panel.category')->middleware(['auth','economate']);
Route::get('/painel/economato/producto/',ProductComponent::class)->name('economate.panel.product')->middleware(['auth','economate']);
Route::get('/painel/economato/encomenda/',OrderComponent::class)->name('economate.panel.order')->middleware(['auth','economate']);
Route::get('/painel/economato/fornecedor/',ProviderComponent::class)->name('economate.panel.provider')->middleware(['auth','economate']);
Route::get('/painel/economato/entrada-estoque/',StockEnterComponent::class)->name('economate.panel.stockenter')->middleware(['auth','economate']);
Route::get('/painel/economato/saida-estoque/',StockOutComponent::class)->name('economate.panel.stockout')->middleware(['auth','economate']);
Route::get('/painel/economato/relatorios/',ReportComponent::class)->name('economate.panel.report')->middleware(['auth','economate']);
Route::get('/painel/economato/minha-conta/',MyAccount::class)->name('economate.panel.myaccount')->middleware(['auth','economate']);
Route::get('/painel/economato/compartimentos/',CompartmentComponent::class)->name('economate.panel.compartment')->middleware(['auth','economate']);
