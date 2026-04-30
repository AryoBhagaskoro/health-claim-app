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
        Schema::create('claims', function (Blueprint $table) {
        $table->id();
        $table->foreignId('member_id')->constrained() ->onDelete('cascade');
        $table->date('claim_date');
        $table->decimal('claim_amount', 15, 2);
        $table->decimal('approved_amount', 15, 2)->default(0);
        $table->decimal('excess_amount', 15, 2)->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
