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

            case 'get-questions' :
                $questions = SurveyQuestions::with('getOptions')->get();
                //$options = SurveyQuestionOptions::where('question_id', $ques->id)->get();
                $array = [];
                for ($i = 0; $i < count($questions); $i++) {
                    if (count($questions[$i]->getOptions) == 4) {
                        array_push($array, array('questionId' => $questions[$i]->id, 'question' => $questions[$i]->question, 'cho0' => $questions[$i]->getOptions[0]['option_value'], 'cho1' => $questions[$i]->getOptions[1]['option_value'], 'cho2' => $questions[$i]->getOptions[2]['option_value'], 'cho3' => $questions[$i]->getOptions[3]['option_value']));
                    } elseif (count($questions[$i]->getOptions) == 3) {
                        array_push($array, array('questionId' => $questions[$i]->id, 'question' => $questions[$i]->question, 'cho0' => $questions[$i]->getOptions[0]['option_value'], 'cho1' => $questions[$i]->getOptions[1]['option_value'], 'cho2' => $questions[$i]->getOptions[2]['option_value']));
                    } else {
                        array_push($array, array('questionId' => $questions[$i]->id, 'question' => $questions[$i]->question, 'cho0' => $questions[$i]->getOptions[0]['option_value'], 'cho1' => $questions[$i]->getOptions[1]['option_value']));
                    }
                }
                echo json_encode($array);
                break;

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
                $array = [];
                $choise = $request->input('choise');
                $id = $request->input('questionId');
                $findOpt = SurveyQuestionOptions::where('option_value', $choise)->first();
                $findQuestion = SurveyQuestionSqoptions::where('option_id', $findOpt->id)->first();
                if ($findQuestion != null) {

                    $ques = SurveyQuestions::find($findQuestion->question_id);
                    $options = SurveyQuestionOptions::where('question_id', $ques->id)->get();

                    if (isEmpty($options[3])) {
                        $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value'], 'cho3' => $options[3]['option_value']);
                    } elseif (isEmpty($options[2])) {
                        $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value'], 'cho2' => $options[2]['option_value']);
                    } else {
                        $array = array('questionId' => $ques->id, 'question' => $ques->question, 'cho0' => $options[0]['option_value'], 'cho1' => $options[1]['option_value']);
                    }
                    echo json_encode($array);
                } else {
                    echo json_encode($array);
                }
                break;
        }
    }
}
