<?php

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
        Schema::create('history_of_all_activities', function (Blueprint $table) {
            $table->id();
            $table->string("tipo_acao");
            $table->longText("descricao");
            $table->string("responsavel");
            $table->foreignIdFor(Company::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_of_all_activities');
    }
};
