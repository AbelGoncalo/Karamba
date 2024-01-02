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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("phone",20)->nullable();
            $table->string("alternativephone",20)->nullable();
            $table->string("email",30)->nullable();
            $table->string("nif")->nullable();
            $table->string("address",100)->nullable();
            $table->string("type")->default("Singular")->nullable();
            $table->boolean("status")->default(true);
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
        Schema::dropIfExists('s');
    }
};
