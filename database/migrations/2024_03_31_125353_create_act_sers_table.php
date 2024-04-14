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
        Schema::create('act_sers', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('actor_id');
            $table->UnsignedBigInteger('serie_id');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('actor_id')
                  ->references('id')
                  ->on('actors')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('serie_id')
                  ->references('id')
                  ->on('series')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('act_sers');
    }
};
