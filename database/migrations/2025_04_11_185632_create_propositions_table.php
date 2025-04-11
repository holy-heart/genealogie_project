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
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();



            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('person');
            $table->string('link');
            $table->unsignedBigInteger('person2');
            $table->unsignedBigInteger('validation')->default(0);
            $table->unsignedBigInteger('refus')->default(0);

            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('propositions');
    }
};
