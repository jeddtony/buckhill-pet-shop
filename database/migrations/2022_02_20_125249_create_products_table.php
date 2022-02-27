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
        if(!Schema::hasTable('products'))
        {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('category_uuid')->comment('UUID of the category');
            $table->string('uuid');
            $table->string('title');
            $table->float('price');
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes()->nullable();
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
        Schema::dropIfExists('products');
    }
};
