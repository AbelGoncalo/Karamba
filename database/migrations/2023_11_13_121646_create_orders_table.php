<?php

use App\Models\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{Table,User};

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(User::class)->nullable();
            $table->string('table');
            $table->string('client')->nullable();
            $table->integer('identify')->nullable();
            $table->string('paymenttype');
            $table->string('splitAccount')->nullable();
            $table->decimal('firstvalue',10,2)->nullable()->default(0);
            $table->decimal('secondvalue',10,2)->nullable()->default(0);
            $table->decimal('divisorresult',10,2)->nullable()->default(0);
            $table->integer('totaltax')->nullable()->default(0);
            $table->decimal('total',10,2);
            $table->decimal('totaldiscount',10,2)->nullable()->default(0);
            $table->enum('status',['pago','pendente'])->default('pago');
            $table->string('file_receipt')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
