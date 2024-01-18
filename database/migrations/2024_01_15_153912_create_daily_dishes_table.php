<?php

use App\Models\Company;
use App\Models\Item;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daily_dishes', function (Blueprint $table) {
            $table->string("entrance")->nullable();
            $table->string("maindish")->nullable();
            $table->string("dessert")->nullable();
            $table->string("drink")->nullable();
            $table->string("coffe")->nullable();
            $table->ForeignIdFor(Company::class)->nullable();
            $table->ForeignIdFor(Item::class)->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_dishes');
    }
};
