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
        Schema::create('author_avatars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id')->index();
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade')->onUpdate('cascade');
            $table->string('image_name')->nullable();
            $table->string('org_filename')->nullable();
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
        Schema::dropIfExists('author_avatars');
    }
};
