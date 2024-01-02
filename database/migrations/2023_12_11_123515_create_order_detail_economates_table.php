<?php

use App\Models\Company;
use App\Models\OrderEconomate;
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
        Schema::create('order_detail_economates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(OrderEconomate::class);
            $table->string('product');
            $table->decimal('price',10,2);
            $table->integer('quantity');
            $table->decimal('subtotal',10,2);
            $table->integer('tax')->nullable()->default(0);
            $table->decimal('discount',10,2)->nullable()->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail_economates');
    }
};
