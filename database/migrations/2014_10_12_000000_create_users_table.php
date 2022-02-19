<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('users'))
        {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->comment('UUID to allow easy migration between envs without breaking FK in the logic');
            $table->string('first_name');
            $table->string('last_name');
            $table->boolean('is_admin')->default(false);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable()->comment('nullable, UUID of the image stored into the files table ');
            $table->string('address');
            $table->string('phone_number');
            $table->boolean('is_marketing')->default(false)->comment('Enable marketing preferences: default (0)');
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_login_at')->nullable();
        });
    }
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
};
