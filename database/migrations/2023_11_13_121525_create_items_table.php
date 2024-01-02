<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\Company;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(Category::class);
            $table->string('barcode')->nullable();
            $table->string('description');
            $table->decimal('cost',10,2)->nullable();
            $table->decimal('iva')->nullable();
            $table->decimal('price',10,2);
            $table->enum('status',['DISPONIVEL','INDISPONIVEL'])->default('DISPONIVEL');
            $table->string('image')->nullable();
            $table->integer('quantity')->default(0);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
