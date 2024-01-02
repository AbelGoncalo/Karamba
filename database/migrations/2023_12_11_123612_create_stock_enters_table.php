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
        Schema::create('stock_enters', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->string('description')->nullable();
            $table->decimal('price',10,2);
            $table->decimal('unit_price',10,2);
            $table->enum('unit',['g','un','ml','unidade de medida','Hr'])->nullable();
            $table->string('source_product')->nullable();
            $table->string('source')->nullable();
            $table->date('expiratedate');
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
        Schema::dropIfExists('stock_enters');
    }
};
