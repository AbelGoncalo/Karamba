<?php

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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string("companyname",60);
            $table->string("companynif",20);
            $table->string("companyregime",30)->default("Exclusão");
            $table->string("companyphone",15);
            $table->string("companyalternativephone",15)->nullable();
            $table->string("companyemail",60)->unique();
            $table->string("companybusiness",100)->nullable();
            $table->string("companycountry",100)->nullable();
            $table->string("companyslogan",100)->nullable();
            $table->string("companycoin",100)->nullable();
            $table->string("companyprovince",30);
            $table->string("companymunicipality",30);
            $table->string("companyaddress",255);
            $table->string("companywebsite",60)->nullable();
            $table->string("companylogo",255)->nullable();
            $table->string("companyordercode",255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
