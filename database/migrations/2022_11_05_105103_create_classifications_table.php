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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->tinyText('description')->default("")->nullable();
            $table->string('type')->default("tags");
            $table->smallInteger('shareable')->default(0);
            $table->unsignedBigInteger("author_id")->nullable();
            $table->timestamps();
        });

        Schema::table('articles', function (Blueprint $table) {
            $table->unsignedBigInteger("author_id")->nullable();
            $table->unsignedBigInteger("category_id")->nullable()->comment("related to classifications.id");
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->unsignedBigInteger('thing_id')->comment("related to any table's.id");
            $table->unsignedBigInteger('tags_id')->comment("related to classifications.id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classifications');
        Schema::dropIfExists('tags');
        Schema::table('articles', function(Blueprint $table) {
            $table->dropColumn("author_id");
            $table->dropColumn("category_id");
        });
    }
};
