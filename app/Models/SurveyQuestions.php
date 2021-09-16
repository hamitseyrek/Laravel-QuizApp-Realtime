<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestions extends Model
{
    use HasFactory;
    public function getOptions(){
        return $this->hasMany(SurveyQuestionOptions::class, 'question_id','id');
    }
}
