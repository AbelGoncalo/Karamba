<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\{User};
use App\Models\Company;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('garson_tables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->foreignIdFor(User::class);
            $table->json('table');
            $table->date('start')->default(date('Y-m-d'))->nullable();
            $table->time('starttime')->default(date('H:i'))->nullable();
            $table->date('end')->nullable();
            $table->time('endtime')->nullable();
            $table->enum('status',['Turno Aberto','Turno Fechado'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garson_tables');
    }
};
