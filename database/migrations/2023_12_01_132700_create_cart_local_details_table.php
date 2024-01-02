<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{CartLocal};
use App\Models\Company;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_local_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(CartLocal::class)->nullable();
            $table->string('name');
            $table->decimal('price');
            $table->integer('quantity');
            $table->string('category');
            $table->enum('status',['PENDENTE','ACEITE','EM PREPARAÇÃO','PRONTO','A CAMINHO','ENTREGUE'])->default('PENDENTE');
            $table->string('table')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_local_details');
    }
};
