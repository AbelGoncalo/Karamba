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
        Schema::create('cupons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Company::class)->nullable();
            $table->string("code")->unique();
            $table->integer("times");
            $table->enum("type",["fixed","percent"]);
            $table->integer("value");
            $table->foreignIdFor(User::class);
            $table->boolean('status')->default(true);
            $table->date('date')->nullable();
            $table->date('expirateDate')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cupons');
    }
};
