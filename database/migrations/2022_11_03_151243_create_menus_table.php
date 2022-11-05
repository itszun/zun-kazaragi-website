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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->foreign('parent_id')->on('menus')->references('id');
            $table->string('title', 50)->default('#');
            $table->string('url')->default("#")->nullable();
            $table->string('icon')->nullable()->default("#");
            $table->string('section')->default("");
            $table->smallInteger('order')->default(1);
            $table->string('roles')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
};
