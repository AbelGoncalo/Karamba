<?php

use App\Models\Company;
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
        Schema::create('order_economates', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('paymenttype');
            $table->decimal('total',10,2);
            $table->integer('totaltax')->nullable()->default(0);
            $table->decimal('totaldiscount',10,2)->nullable()->default(0);
            $table->enum('status',['pago','pendente'])->default('pago');
            $table->date('deliverydate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_economates');
    }
};
