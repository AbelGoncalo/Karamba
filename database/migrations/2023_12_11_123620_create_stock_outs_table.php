<?php

use App\Models\Company;
use App\Models\ProductEconomate;
use App\Models\User;
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
        Schema::create('stock_outs', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->string('usetype')->nullable();
            $table->string('chef')->nullable();
            $table->enum('unit',['g','un','ml','unidade de medida','Hr'])->nullable();
            $table->string('description')->nullable();
            $table->string('from');
            $table->string('to');
            $table->foreignIdFor(ProductEconomate::class)->nullable();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_outs');
    }
};
