<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->integer('option_number');
            $table->string('option_value', 400);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_question_options');
    }
}
