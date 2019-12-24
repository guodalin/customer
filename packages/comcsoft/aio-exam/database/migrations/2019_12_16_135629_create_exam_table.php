<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 试卷
        Schema::create('exam_papers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedInteger('category_id')->nullable()->index()->comment('所属栏目ID');
            $table->string('name');
            $table->char('type', 20)->nullable()->index()->comment('试卷类型'); // 配置文件定义
            $table->text('summary')->nullable()->comment('描述');
            $table->smallInteger('score')->unsigned()->nullable()->comment('试卷总分, 冗余');
            $table->string('copyfrom')->nullable()->comment('来源');

            // 对于模拟考试而言
            $table->unsignedSmallInteger('minutes')->default(0)->nullable()->comment('考试时间');
            $table->timestamp('start_at')->nullable()->index()->comment('开始时间');   // 索引
            $table->boolean('active')->default(false)->index()->comment('是否激活'); // scopeActive
            $table->string('password')->nullable()->comment('是否需要密码');
            $table->string('need_permission')->nullable()->comment('需要的权限');
            $table->text('description')->nullable()->comment('SEO:desc');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('exam_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('category_id')->nullable()->index()->comment('所属栏目ID');

            $table->string('name');
            $table->char('type', 20)->index()->comment('题目类型');
            $table->nestedSet(); // 可能有子题的情况
            $table->json('options')->nullable()->comment('选项');
            $table->json('section')->nullable()->comment('切片浏览配置');
            $table->text('analyze')->nullable()->comment('解析');

            $table->timestamps();
        });

        // 组卷记录
        Schema::create('exam_paper_question', function (Blueprint $table) {
            $table->unsignedBigInteger('paper_id')->index();
            $table->unsignedBigInteger('question_id')->index();
            $table->unsignedInteger('sort')->default(0);
            $table->tinyInteger('score')->default(0)->nullable()->comment('题目在本试卷内的分数');

            $table->foreign('paper_id')
                ->references('id')
                ->on('exam_papers')
                ->onDelete('cascade');

            $table->foreign('question_id')
                ->references('id')
                ->on('exam_questions')
                ->onDelete('cascade');

            $table->primary(['paper_id', 'question_id']);
        });

        // Schema::create('exam_question_options', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('question_id')->index();

        //     $table->text('content')->nullable();
        //     $table->boolean('correct')->default(false);
        //     $table->unsignedInteger('sort')->default(0);
        //     $table->timestamps();

        //     $table->foreign('question_id')
        //         ->references('id')
        //         ->on('exam_questions')
        //         ->onDelete('cascade');
        // });

        // 考试记录
        Schema::create('exam_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('paper_id')->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->unsignedTinyInteger('score')->default(0)->comment('考试分数');
            $table->unsignedInteger('elapsed')->default(0)->comment('考试花费的时间');

            $table->timestamps();

            $table->foreign('paper_id')
                ->references('id')
                ->on('exam_papers')
                ->onDelete('cascade');
        });

        // 答题记录
        // 与题目 考试记录 多对多
        Schema::create('exam_log_question', function (Blueprint $table) {
            $table->unsignedBigInteger('log_id')->index();
            $table->unsignedBigInteger('question_id');

            $table->tinyInteger('correct')->default(0)->nullable()->index()->comment('-1错误 0 1对');
            $table->tinyInteger('score')->default(0)->comment('获得的分数');
            $table->text('my_answer')->nullable()->comment('我的回答');

            $table->primary(['log_id', 'question_id']);

            $table->foreign('log_id')
                ->references('id')
                ->on('exam_logs')
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
        Schema::dropIfExists('exam_log_question');
        Schema::dropIfExists('exam_logs');
        // Schema::dropIfExists('exam_question_options');
        Schema::dropIfExists('exam_paper_question');
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('exam_papers');
    }
}
