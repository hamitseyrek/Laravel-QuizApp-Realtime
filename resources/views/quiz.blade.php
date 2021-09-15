<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head lang="en">
    <meta charset="UTF-8">
    <title>Quiz</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="grid">
    <div id="quiz">
        <h1 style="background-color: #1D3C6A">Quiz in JavaScript  birmuhendis.net</h1>
        <hr style="margin-bottom: 20px">

        <p id="question"></p>

        <div class="buttons">
            <button id="btn0"><span id="choice0"></span></button>
            <button id="btn1"><span id="choice1"></span></button>
            <button id="btn2"><span id="choice2"></span></button>
            <button id="btn3"><span id="choice3"></span></button>
            @foreach($data as $row)
                {{$row->question}}
            @endforeach
        </div>
        <hr style="margin-top: 50px">
        <footer>
            <p id="progress">Question x of y</p>
        </footer>
    </div>
</div>


<script>
        function Quiz(questions) {
            this.score = 0;
            this.questions = questions;
            this.questionIndex = 0;
        }

        Quiz.prototype.getQuestionIndex = function () {
            return this.questions[this.questionIndex];
        }

        Quiz.prototype.guess = function (answer) {
            if (this.getQuestionIndex().isCorrectAnswer(answer)) {
                this.score++;
            }

            this.questionIndex++;
        }

        Quiz.prototype.isEnded = function () {
            return this.questionIndex === this.questions.length;
        }


        function Question(text, choices, answer) {
            this.text = text;
            this.choices = choices;
            this.answer = answer;
        }

        Question.prototype.isCorrectAnswer = function (choice) {
            return this.answer === choice;
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
                for (var i = 0; i < choices.length; i++) {
                    var element = document.getElementById("choice" + i);
                    element.innerHTML = choices[i];
                    guess("btn" + i, choices[i]);
                }

                showProgress();
            }
        };

        function guess(id, guess) {
            var button = document.getElementById(id);
            button.onclick = function () {
                quiz.guess(guess);
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
        var questions = [
            @foreach($data as $datam )
            new Question('{{ $datam->id }}', ["Python Script", "JQuery", "Django", "NodeJS"], "Django"),
            @endforeach
                new Question("Which language is used for styling web pages?", ["HTML", "JQuery", "CSS", "XML"], "CSS"),
            new Question("Which is not a JavaScript Framework?", ["Python Script", "JQuery", "Django", "NodeJS"], "Django"),
            new Question("Which is used for Connect To Database?", ["PHP", "HTML", "JS", "All"], "PHP"),
            new Question("Webdevtrick.com is about..", ["Web Design", "Graphic Design", "SEO & Development", "All"], "All")
        ];

        // create quiz
        var quiz = new Quiz(questions);

        // display quiz
        populate();
</script>

</body>
</html>
