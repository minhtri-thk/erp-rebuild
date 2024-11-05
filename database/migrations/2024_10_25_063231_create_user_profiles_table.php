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
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->integer('id')->unsigned()->autoIncrement()->index();
            $table->integer('user_id')->unsigned();
            $table->string('employee_code', 10);
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('phone_number', 11)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender');
            $table->string('avatar_url', 255)->nullable();
            $table->string('language', 5);
            $table->string('address', 255)->nullable();
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
