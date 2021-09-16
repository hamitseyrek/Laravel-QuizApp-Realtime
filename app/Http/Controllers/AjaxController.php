<?php

namespace App\Http\Controllers;

use App\Models\SurveyQuestionOptions;
use App\Models\SurveyQuestions;
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
                    $array = array('question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value'], 'cho3' => $options[3]['option_value']);
                } elseif (isEmpty($options[2])) {
                    $array = array('question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value']);
                } else {
                    $array = array('question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value']);
                }
                echo json_encode($array);
                break;

            case 'result_quiz' :
                $choise = $request->input('choise');
                $id = $request->input('id');
                dd($id);
                echo json_encode($choise);
                break;
        }
    }
}
