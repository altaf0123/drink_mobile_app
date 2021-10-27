<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('otp')->nullable();
            // $table->enum('gender', ['male', 'female','other']);
            $table->string('profile_picture')->nullable();
            // $table->string('phone_no')->nullable();
            // $table->string('country')->nullable();
            // $table->date('date_of_birth')->nullable();
            $table->boolean('is_profile_complete')->default(0);
            // $table->float('location_range')->nullable();
            $table->boolean('account_verified')->default(0);
            $table->enum('account_status', ['active', 'suspended']);
            $table->boolean('is_social')->default(0);
            $table->string('device_type',10)->nullable();
            $table->text('device_token')->nullable();
            $table->enum('role',['user','admin'])->default('user');
            // $table->string('lat',35)->nullable();
            // $table->string('long',35)->nullable();
            // $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
