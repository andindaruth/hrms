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
        Schema::table('fertiliser_transactions', function (Blueprint $table) {
            $table->boolean('is_reversed')->default(0);
            $table->text('reversal_reason')->nullable();
            $table->unsignedBigInteger('reversed_by')->nullable();
            $table->foreign('reversed_by')->references('id')->on('fertiliser_transactions')->onDelete('set null');
            $table->unsignedBigInteger('reverses')->nullable();
            $table->foreign('reverses')->references('id')->on('fertiliser_transactions')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fertiliser_transactions', function (Blueprint $table) {
            $table->dropColumn('is_reversed');
            $table->dropColumn('reversal_reason');
            $table->dropForeign(['reversed_by']);
            $table->dropColumn('reversed_by');
            $table->dropForeign(['reverses']);
            $table->dropColumn('reverses');
        });
    }
};
