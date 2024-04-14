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
        Schema::table('series', function (Blueprint $table) {
            //
            $table->UnsignedBigInteger('director_id')->nullable();
            $table->foreign('director_id')
                  ->references('id')
                  ->on('directors')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            //
            $table->dropForeign('series_director_id_foreign');
            $table->dropColumn('director_id');
        });
    }
};