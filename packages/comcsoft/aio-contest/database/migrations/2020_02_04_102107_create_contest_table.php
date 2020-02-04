<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 竞赛读片会主表
        Schema::create('ct_conferences', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->comment('竞赛名称');
            $table->text('content')->nullable()->comment('介绍');
            $table->timestamp('begin_at')->nullable()->comment('开始日期');
            $table->timestamp('end_at')->nullable()->comment('介绍日期');
            $table->json('options')->nullable()->comment('会议配置, options.lat, options.lnt, options.radius, options...'); // lat, lnt, radius, steps, votes: num, vote_one_player, ...
            $table->char('status', 20)->default('inited')->comment('会议状态');

            $table->timestamps();
        });

        // 竞赛读片会选手表
        Schema::create('ct_players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('conference_id')->index();
            $table->nestedSet();

            $table->string('name')->nullable()->comment('名称');
            $table->json('profile')->nullable()->comment('资料');
            $table->float('spectators', 10, 4)->default(0)->comment('观众平均');
            $table->float('judgers', 10, 4)->default(0)->comment('裁判平均分');
            $table->float('total', 10, 4)->default(0)->index()->comment('总分');
            $table->boolean('is_pending')->default(false)->comment('是否待定');
            $table->boolean('step1')->default(false)->comment('第一回合');
            $table->boolean('step2')->default(false)->comment('第2回合');
            $table->boolean('step3')->default(false)->comment('第3回合');
            $table->boolean('step4')->default(false)->comment('第4回合');
            $table->boolean('step5')->default(false)->comment('第5回合');
            $table->integer('sort1')->default(0)->index()->comment('第一回合排序');
            $table->integer('sort2')->default(0)->index()->comment('第2回合排序');
            $table->integer('sort3')->default(0)->index()->comment('第3回合排序');
            $table->integer('sort4')->default(0)->index()->comment('第4回合排序');
            $table->integer('sort5')->default(0)->index()->comment('第5回合排序');
            $table->char('group_id1', 10)->nullable()->index()->comment('分组1');
            $table->char('group_id2', 10)->nullable()->index()->comment('分组2');
            $table->char('group_id3', 10)->nullable()->index()->comment('分组3');
            $table->char('group_id4', 10)->nullable()->index()->comment('分组4');
            $table->char('group_id5', 10)->nullable()->index()->comment('分组5');

            $table->timestamps();

            // add foreign key
            $table->foreign('conference_id')
                ->references('id')
                ->on('ct_conferences')
                ->onDelete('cascade');
        });	

        // 竞赛读片会投票表
        Schema::create('ct_votes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('player_id')->index();

            $table->unsignedBigInteger('conference_id')->index();
            $table->boolean('is_valid')->default(false)->comment('是否有效票');
            $table->timestamps();

            $table->index(['user_id', 'conference_id']);
            $table->index(['user_id', 'player_id']);

            // add foreign key
            $table->foreign('conference_id')
                ->references('id')
                ->on('ct_conferences')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('ct_players')
                ->onDelete('cascade');
        });

        // 竞赛读片会选手统计表
        Schema::create('ct_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('player_id')->index();
            $table->unsignedTinyInteger('round')->index()->default(1)->comment('回合');

            $table->float('base', 10, 4)->default(0)->comment('基础分');
            $table->float('score', 10, 4)->default(0)->comment('分数');
            $table->float('deduct', 10, 4)->default(0)->comment('扣分');
            $table->float('append', 10, 4)->default(0)->comment('附加分');
            $table->float('total', 10, 4)->default(0)->index()->comment('总分');

            $table->timestamps();

            // add foreign key
            $table->foreign('player_id')
                ->references('id')
                ->on('ct_players')
                ->onDelete('cascade');
        });

        // 竞赛读片会关联表
        Schema::create('ct_conferencables', function (Blueprint $table) {
            $table->unsignedBigInteger('conference_id')->index();
            $table->morphs('conferencable');  // exam

            $table->index(['conference_id', 'conferencable_type']);

            // add foreign key
            $table->foreign('conference_id')
                ->references('id')
                ->on('ct_conferences')
                ->onDelete('cascade');
        });

        // 签到表
        Schema::create('ct_checkins', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('conference_id')->index();

            $table->float('lat')->nullable()->comment('经度');
            $table->float('lng')->nullable()->comment('纬度');
            $table->json('extra')->nullable()->comment('额外数据');  //extra.invoice
            $table->boolean('is_present')->default(true)->comment('是否出席');
            $table->boolean('is_lucky')->default(false)->comment('幸运观众');
            $table->boolean('need_invoice')->default(false)->comment('需要开发票');
            $table->boolean('has_paid')->default(false)->comment('是否缴费');
            $table->timestamps();

            $table->primary(['conference_id', 'user_id']);

            // add foreign key
            $table->foreign('conference_id')
                ->references('id')
                ->on('ct_conferences')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ct_checkins');

        Schema::dropIfExists('ct_conferencables');

        Schema::dropIfExists('ct_statistics');

        Schema::dropIfExists('ct_votes');

        Schema::dropIfExists('ct_players');

        Schema::dropIfExists('ct_conferences');
    }
}
