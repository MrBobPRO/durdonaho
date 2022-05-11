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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            $table->integer('author_id');
            $table->integer('source_id')->nullable();
            $table->integer('user_id'); // publisher
            $table->boolean('popular');
            $table->boolean('verified')->default(0); // by admin
            $table->boolean('approved')->default(0); // approved or denied by admin
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
        Schema::dropIfExists('quotes');
    }
};
