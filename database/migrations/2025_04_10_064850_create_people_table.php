<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('created_by');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('birth_name')->nullable();
            $table->string('middle_names')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->timestamps();

            $table->index('created_by');
        });
    }

    public function down()
    {
        Schema::dropIfExists('people');
    }
}
