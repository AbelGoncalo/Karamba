<?php

use App\Models\{Company, Item};
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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer("star_number");
            $table->string("comment",200)->nullable();
            $table->date("date")->default(date("Y-m-d"));
            $table->boolean("status")->default(false);
            $table->foreignIdFor(Item::class)->nullable();
            $table->string('client')->nullable();
            $table->string('site')->nullable();
            $table->string('item')->nullable();
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
        Schema::dropIfExists('reviews');
    }
};
