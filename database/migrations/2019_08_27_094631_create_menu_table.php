<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 菜单定义
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('nickname')->unique();
            $table->text('html_attributes')->nullable()->comment('HTML设置');

            $table->timestamps();
        });

        // 菜单项
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->nestedSet();

            $table->string('name');
            $table->uuid('nickname');

            $table->char('type', 10)->default('url')->comment('路由类型，url,route,action,divide,raw');
            $table->string('link')->nullable()->comment('路由值');
            $table->string('icon')->nullable()->comment('图标地址');
            $table->boolean('just_icon')->default(false)->comment('仅显示图标');

            $table->text('html_attributes')->nullable()->comment('HTML设置');
            $table->text('meta')->nullable()->comment('meta');
            $table->string('active')->nullable()->comment('激活路径');

            $table->boolean('show')->default(true)->comment('是否显示');
            $table->timestamps();

            // add foreign key
            $table->foreign('menu_id')
                ->references('id')
                ->on('menus')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');

        Schema::dropIfExists('menus');
    }
}
