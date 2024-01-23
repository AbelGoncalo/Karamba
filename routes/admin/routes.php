<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\{
    HomeComponent,
    CategoryComponent,
    ItemComponent,
    TableComponent,
    ReportComponent,
    UserComponent,
    CuponComponent,
    HistoryOfAllActivities,
    LocationComponent,
    ReviewComponent,
    DishOfTheDayComponent
};
use App\Http\Controllers\Dailydish\DailyDishController;
use App\Livewire\Auth\MyAccount;

Route::get('/painel/admin',HomeComponent::class)->name('panel.admin.home')->middleware(['auth','admin']);
Route::get('/painel/admin/categorias',CategoryComponent::class)->name('panel.admin.categories')->middleware(['auth','admin']);
Route::get('/painel/admin/items',ItemComponent::class)->name('panel.admin.items')->middleware(['auth','admin']);
Route::get('/painel/admin/cupons',CuponComponent::class)->name('panel.admin.cupon')->middleware(['auth','admin']);
Route::get('/painel/admin/mesas',TableComponent::class)->name('panel.admin.tables')->middleware(['auth','admin']);
Route::get('/painel/admin/locais',LocationComponent::class)->name('panel.admin.places')->middleware(['auth','admin']);
// Route::get('/painel/admin/relatorios',ReportComponent::class)->name('panel//.admin.report')->middleware(['auth','admin']);
Route::get('/painel/admin/utilizadores',UserComponent::class)->name('panel.admin.user')->middleware(['auth','admin']);
Route::get('/painel/admin/minha-conta',MyAccount::class)->name('panel.admin.account')->middleware(['auth','admin']);
Route::get('/painel/admin/minha-conta',MyAccount::class)->name('panel.admin.account')->middleware(['auth','admin']);
Route::get('/painel/admin/avaliacoes',ReviewComponent::class)->name('panel.admin.review')->middleware(['auth','admin']);
Route::get("painel/admin/consultar/log/actividades/geral", HistoryOfAllActivities::class)->name('panel.admin.history.of.all.activities');
Route::get('/painell/admin/prato/do/dia', DishOfTheDayComponent::class)->name('panel.admin.dish.of.the.day');
Route::post("/painel/admin/adicionar/prato/dia/" , [DailyDishController::class, "save"])->name("panel.admin.daily.dish.store")->middleware(['auth','admin']);

