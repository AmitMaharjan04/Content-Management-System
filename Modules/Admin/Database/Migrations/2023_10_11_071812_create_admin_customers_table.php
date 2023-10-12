<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender',['M','F','O']);
            $table->string('email');
            $table->text('address');
            $table->string('blood_group');
            $table->string('file')->nullable();
            $table->string('description');
            $table->string('hobbies');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_customers');
    }
};
