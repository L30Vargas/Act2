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
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->foreign('platform_id')
                  ->references('id')
                  ->on('platforms')
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
            $table->dropForeign('series_platform_id_foreign');
            $table->dropColumn('platform_id');
        });
    }
};
