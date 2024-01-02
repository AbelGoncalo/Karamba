<?php

use App\Models\CategoryEconomate;
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
        Schema::create('product_economates', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('image')->nullable();
            $table->decimal('cost',10,2);
            $table->foreignIdFor(CategoryEconomate::class)->nullable();
            $table->foreignIdFor(Company::class)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_economates');
    }
};
