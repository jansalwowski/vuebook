<?php

use App\Models\Maps\PostsTableMap;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('target_id')->unsigned()->index()->nullable()->default(null);
            $table->enum('type', [
                PostsTableMap::TYPE_MOVIE,
                PostsTableMap::TYPE_PHOTO,
                PostsTableMap::TYPE_SHARE,
                PostsTableMap::TYPE_TEXT,
            ])->default(PostsTableMap::TYPE_TEXT);
            $table->enum('privacy_type', [
                PostsTableMap::PRIVACY_FRIENDS,
                PostsTableMap::PRIVACY_PUBLIC,
                PostsTableMap::PRIVACY_PRIVATE,
            ])->default(PostsTableMap::PRIVACY_PUBLIC);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('target_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
