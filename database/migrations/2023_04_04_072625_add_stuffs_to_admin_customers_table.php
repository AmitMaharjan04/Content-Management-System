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
        Schema::table('admin_customers', function (Blueprint $table) {
            $table->string('blood_group')->after('address');
            $table->string('hobbies')->after('address');
            $table->string('file')->after('address');
            $table->string('description')->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_customers', function (Blueprint $table) {
            //
        });
    }
};
