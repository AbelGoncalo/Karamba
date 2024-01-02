<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\RoomManager\{
    DeliveryComponent,
    HomeComponent,
    GarsonComponent,
    ReportComponent,
    MyAccount,
    ShowReviewComponent,
    OrderComponent,
    ShowBookComponent
};

Route::get('/painel/chef-sala',HomeComponent::class)->name('room.manager.home')->middleware(['auth','room_manager']);
Route::get('/painel/chef-sala/garçons',GarsonComponent::class)->name('room.manager.garson')->middleware(['auth','room_manager']);
Route::get('/painel/chef-sala/relatorios',ReportComponent::class)->name('room.manager.report')->middleware(['auth','room_manager']);
Route::get('/chef-sala/minha-conta',MyAccount::class)->name('room.manager.account')->middleware(['auth','room_manager']);
Route::get('/chef-sala/avaliações',ShowReviewComponent::class)->name('room.manager.review')->middleware(['auth','room_manager']);
Route::get('/painel/chef-sala/pedidos',OrderComponent::class)->name('panel.room.manager.order')->middleware(['auth','room_manager']);
Route::get('/painel/chef-sala/encomendas',DeliveryComponent::class)->name('panel.room.manager.delivery')->middleware(['auth','room_manager']);
Route::get('/painel/chef-sala/reservas',ShowBookComponent::class)->name('panel.room.manager.reserves')->middleware(['auth','room_manager']);


