<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->decimal('total',10,2);
            $table->decimal('discount',10,2)->nullable();
            $table->decimal('locationprice',10,2);
            $table->string('customername');
            $table->string('customerlastname');
            $table->string('customerprovince');
            $table->string('customermunicipality');
            $table->string('customerstreet');
            $table->string('customerphone');
            $table->string('customerotherphone')->nullable();
            $table->string('customerpaymenttype');
            $table->string('receipt');
            $table->string('finddetail')->nullable();
            $table->string('customerotheraddress',255)->nullable();
            $table->enum('status',['PENDENTE','A CAMINHO','ENTREGUE','ACEITE','EM PREPARAÇÃO','PRONTO'])->default('Pendente');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
