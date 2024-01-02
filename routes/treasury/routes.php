<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Treasury\{HomeComponent,CustomerComponent,SaidaComponent,TreasuryReportComponent,BankComponent, MakeInvoice, MyAccount};

Route::get('/painel/tesouraria',HomeComponent::class)->name('treasury.home')->middleware(['auth','treasury']);
Route::get('/painel/tesoureiro/clientes',CustomerComponent::class)->name('panel.tesoureiro.cliente')->middleware(['auth','treasury']);
Route::get('/painel/tesoureiro/saida',SaidaComponent::class)->name('panel.tesoureiro.saida')->middleware(['auth','treasury']);
Route::get('/painel/tesoureiro/emitir-faturas',MakeInvoice::class)->name('treasury.make.invoice')->middleware(['auth','treasury']);
Route::get('/painel/tesoureiro/relatorio',TreasuryReportComponent::class)->name('panel.tesoureiro.report')->middleware(['auth','treasury']);
Route::get('/painel/tesoureiro/contabancaria',BankComponent::class)->name('panel.tesoureiro.bank')->middleware(['auth','treasury']);
Route::get('/painel/tesouraria/minhaconta',MyAccount::class)->name('treasury.myaccount.account')->middleware(['auth','treasury']);








