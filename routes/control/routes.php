<?php
use Illuminate\Support\Facades\Route;

use App\Livewire\Control\{HomeComponent,CompanyComponent};
Route::get('/painel/controlo/',HomeComponent::class)->name('control.panel.home')->middleware(['auth','control']);
Route::get('/painel/controlo/restaurante',CompanyComponent::class)->name('control.panel.company')->middleware(['auth','control']);
