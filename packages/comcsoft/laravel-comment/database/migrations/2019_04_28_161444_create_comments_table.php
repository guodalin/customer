<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            // make comments hierarchical
            $table->nestedSet();

            $table->unsignedInteger('user_id')->index();
            $table->morphs('commentable');

            // we use string here, u can change to text if length of ur comment message is out of range
            $table->string('message')->nullable();
            $table->string('ua')->nullable()->comment('user agent');

            $table->boolean('anonymous')->default(false);
            $table->timestamps();
            $table->softDeletes();

            if (config('comment.commenter.cascade_on_delete')) {
                $table->foreign('user_id')
                    ->references(config('comment.commenter.table.primary_key'))
                    ->on(config('comment.commenter.table.name'))
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
