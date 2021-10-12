<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head lang="en">
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>
<body>
<div class="grid">
    <div id="quiz">
        <h1 style="background-color: #ffffff; color: #0e5ab4">Quiz in JavaScript birmuhendis.net</h1>
        <hr style="margin-bottom: 20px">

        <p id="question"></p>

        <div class="buttons">
            <button id="btn0"><span id="choice0"></span></button>
            <button id="btn1"><span id="choice1"></span></button>
            <button id="btn2"><span id="choice2"></span></button>
            <button id="btn3"><span id="choice3"></span></button>
        </div>
        <hr style="margin-top: 50px">
        <footer>
            <p id="progress"></p>
        </footer>
    </div>
</div>


<script>

    function Question(text, choices, questionId) {
        this.text = text;
        this.choices = choices;
        this.questionId = questionId;
    }

    var questions = [];
    var item2 = new Question("İlk Soru?", ["PHP", "HTML", "JS", "refd"], 1);
    questions.push(item2);

    var choiseName = "";
    var quId = 0;

    // create quiz
    var quiz = new Quiz(questions);

    // display quiz
    function Quiz(questions) {
        // this.score = 0;
        this.questions = questions;
        this.questionIndex = 0;
    }


    Quiz.prototype.getQuestionIndex = function () {
        return this.questions[this.questionIndex];
    }

    Quiz.prototype.isEnded = function () {
        return this.questionIndex === this.questions.length;
    } // gelen son id geçerli mi değil mi ona bakılabilir


    Quiz.prototype.guess = function (answer) {

        this.questionIndex++;
    }


    function populate() {
        if (quiz.isEnded()) {
            showScores();
        } else {
            // show question
            var element = document.getElementById("question");
            element.innerHTML = quiz.getQuestionIndex().text;

            // show options
            var choices = quiz.getQuestionIndex().choices;
            var qId = quiz.getQuestionIndex().questionId;
            console.log(choices.length);
            for (var i = 0; i < choices.length; i++) {
                var element = document.getElementById("choice" + i);
                element.innerHTML = choices[i];

                guess("btn" + i, choices[i], qId);
            }
            showProgress();
        }
    };
    $.post('{{url('/ajax')}}', {
        _token: '{{csrf_token()}}',
        type: 'get-questions',
    }, function abc(ret) {
        if (ret != null) {
            for (var i = 0; i < ret.length; i++) {
                var item = new Question(ret[i]['question'],
                    [(ret[i]['cho0'] != null) ? ret[i]['cho0'] : "", (ret[i]['cho1'] != null) ? ret[i]['cho1'] : "", (ret[i]['cho2'] != null) ? ret[i]['cho2'] : "", (ret[i]['cho3'] != null) ? ret[i]['cho3'] : ""],

                    /*(ret[i]['cho3'] != null) ?
                        [(ret[i]['cho0'] != null) ? ret[i]['cho0'] : "", (ret[i]['cho1'] != null) ? ret[i]['cho1'] : "", (ret[i]['cho2'] != null) ? ret[i]['cho2'] : "", (ret[i]['cho3'] != null) ? ret[i]['cho3'] : ""] :
                        (ret[i]['cho2'] != null) ?
                            [(ret[i]['cho0'] != null) ? ret[i]['cho0'] : "", (ret[i]['cho1'] != null) ? ret[i]['cho1'] : "", (ret[i]['cho2'] != null) ? ret[i]['cho2'] : ""] :
                            [(ret[i]['cho0'] != null) ? ret[i]['cho0'] : "", (ret[i]['cho1'] != null) ? ret[i]['cho1'] : ""],*/
                    ret[i]['questionId']);
                questions.push(item);
            }
            this.questions = questions;
        }
    }, "json");

    function guess(id, guess, quId) {
        choiseName = guess;
        //console.log(quId);
        //console.log(choiseName);
        /*$.post('{{url('/ajax')}}', {
            _token: '{{csrf_token()}}',
            type: 'next-question',
            choise: choiseName,
        }, function abc(ret) {
            if(ret['question'] != null){
            var item = new Question(ret['question'], [(ret['cho0'] != null) ? ret['cho0'] : "", (ret['cho1'] != null) ? ret['cho1'] : "", (ret['cho2'] != null) ? ret['cho2'] : "", (ret['cho3'] != null) ? ret['cho3'] : ""], ret['questionId']);
            questions.push(item);
            this.questions = questions;
            //console.log(quiz);
            question_id = quId;
            }
        }, "json");*/
        var button = document.getElementById(id);
        if (guess == '') {
            button.style.visibility = "hidden";
        }else{
            button.style.visibility = "";

        }
        button.onclick = function () {
            quiz.guess(guess);
            console.log(guess)
            populate();
        }
    };


    function showProgress() {
        var currentQuestionNumber = quiz.questionIndex + 1;
        var element = document.getElementById("progress");
        element.innerHTML = "Question " + currentQuestionNumber + " of " + quiz.questions.length;
    };

    function showScores() {
        var gameOverHTML = "<h1>Result</h1>";
        gameOverHTML += "<h2 id='score'> Your scores: " + quiz.score + "</h2>";
        var element = document.getElementById("quiz");
        element.innerHTML = gameOverHTML;
    };

    // create questions here


    populate();
</script>

</body>
</html>
