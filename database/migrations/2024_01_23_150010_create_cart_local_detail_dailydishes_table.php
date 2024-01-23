<?php

use App\Models\CartLocalDetail;
use App\Models\Company;
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
        Schema::create('cart_local_detail_dailydishes', function (Blueprint $table) {
            $table->id();
            $table->string("entrance")->nullable();
            $table->string("maindish")->nullable();
            $table->string("dessert")->nullable();
            $table->string("drink")->nullable();
            $table->string("coffe")->nullable();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(CartLocalDetail::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_local_detail_dailydishes');
    }
};
