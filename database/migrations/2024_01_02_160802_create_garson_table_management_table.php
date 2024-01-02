<?php

use App\Models\Company;
use App\Models\GarsonTable;
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
        Schema::create('garson_table_management', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(GarsonTable::class);
            $table->foreignIdFor(Company::class);
            $table->string('table');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garson_table_management');
    }
};
