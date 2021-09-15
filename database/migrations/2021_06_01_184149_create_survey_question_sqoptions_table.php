<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyQuestionSqoptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_question_sqoptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('survey_questions')->cascadeOnDelete();
            $table->foreignId('option_id')->constrained('survey_question_options')->cascadeOnDelete();
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
        Schema::dropIfExists('survey_question_sqoptions');
    }
}
