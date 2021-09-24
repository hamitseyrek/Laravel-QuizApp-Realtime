<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestionOptions;
use App\Models\SurveyQuestions;
use App\Models\SurveyQuestionSqoptions;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class AjaxController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {

            case 'get-question' :
                $id = $request->input('id');
                $ques = SurveyQuestions::find($id);
                $options = SurveyQuestionOptions::where('question_id', $ques->id)->get();
                if (isEmpty($options[3])) {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value'], 'cho3' => $options[3]['option_value']);
                } elseif (isEmpty($options[2])) {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value']);
                } else {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value']);
                }
                echo json_encode($array);
                break;

            case 'next-question' :
                $choise = $request->input('choise');
                $id = $request->input('questionId');
                $findOptId = SurveyQuestionOptions::where('question_id', $id)->where('option_value', $choise)->first()->id;
                $ques = SurveyQuestionSqoptions::find($findOptId);
                $options = SurveyQuestionOptions::where('question_id', $ques->id)->get();

                if (isEmpty($options[3])) {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value'], 'cho3' => $options[3]['option_value']);
                } elseif (isEmpty($options[2])) {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value']);
                } else {
                    $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value']);
                }
                echo json_encode($array);
                break;
        }
    }
}
