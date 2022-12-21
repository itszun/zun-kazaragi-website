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
        Schema::dropIfExists('articles');
        Schema::dropIfExists('post_metas');
        Schema::dropIfExists('post_comments');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('post_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('categories');

        Schema::create('categories', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title', 75);
            $table->string('meta_title', 100);
            $table->string('slug', 100);
            $table->text('content');
            $table->timestamps();

            $table->foreign('parent_id')->on('categories')->references('id');
        });
        Schema::create('tags', function(Blueprint $table) {
            $table->id();
            $table->string('title', 75);
            $table->string('meta_title', 100);
            $table->string('slug', 100);
            $table->text('content');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('author_id');
            $table->string('title', 100);
            $table->string('meta_title', 100);
            $table->string('slug', 100);
            $table->tinyText('summary')->default("");
            $table->text('content')->default("");
            $table->string('status');
            $table->dateTime('published_at');
            $table->timestamps();

            $table->foreign('author_id')->on('users')->references('id');
        });

        Schema::create('post_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('post_id')->on('posts')->references('id');
            $table->foreign('category_id')->on('categories')->references('id');
        });

        Schema::create('post_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('tag_id');

            $table->foreign('post_id')->on('posts')->references('id');
            $table->foreign('tag_id')->on('tags')->references('id');
        });

        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('published');
            $table->dateTime('published_at');
            $table->timestamps();

            $table->foreign('parent_id')->on('post_comments')->references('id');
            $table->foreign('post_id')->on('posts')->references('id');
        });

        Schema::create('post_metas', function(Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('key');
            $table->text('content');

            $table->foreign('post_id')->on('posts')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
