<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

if(isset($_POST["viewQuiz"])) {
    $quizNo = $_POST["quiz-no"];

    $quiz = new Quiz();
    $tempQuiz = $quizManager->getQuizList();

    for($x=0 ; $x<sizeof($tempQuiz) ; $x++)
        if($tempQuiz[$x]->getNo() == $quizNo)
            $quiz = $tempQuiz[$x];

    $quiz->setQuestion($quizManager->getQuestionList($quiz->getNo()));
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <title>Register</title>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="../index.php">Lecturer Page</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="../view-statistics">View Statistics</a></li>
                    <li><a href="../create-quiz">Create Quiz</a></li>
                    <li><a href="../delete-quiz">Delete Quiz</a></li>
                    <li><a href="../update-quiz">Update Quiz</a></li>
                    <li><a href="../../logout">Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <?php displayQuizDesc($quiz); ?>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>

<?php
function displayQuizDesc($quiz) {
    echo "
        <div class='form-group'>
            <label>Quiz Title:</label>
            <input type='text' class='form-control' value='" . $quiz->getTitle() . "' readonly/>
        </div>
        <div class='form-group'>
            <label>Subject:</label>
            <input type='text' class='form-control' value='" . $quiz->getSubject() . "' readonly/>
        </div>
        <div class='form-group'>
            <label>Time Constraint:</label>
            <input type='text' class='form-control' value='" . $quiz->getTime() . "' readonly/>
        </div>
        <div class='form-group'>
            <label>Date Created:</label>
            <input type='text' class='form-control' value='" . $quiz->getDateCreated() . "' readonly/>
        </div>
        <br /><br />
    ";

    for($x=0 ; $x<sizeof($quiz->getQuestion()) ; $x++) {
        $questionNo = $x + 1;
        $tempQuestion = $quiz->getQuestion()[$x];

        echo "
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='form-group'>
                            <label>$questionNo) Question Description</label>
                            <input class='form-control' type='text' value='" . $tempQuestion->getDescription() . "' readonly/>
                        </div>
                    </div>
                </div>
                <div class='row'>";

        for($y=0 ; $y<sizeof($tempQuestion->getAnswer()) ; $y++) {
            $answerNo = "A";
            $tempAnswer = $tempQuestion->getAnswer()[$y];

            switch ($y) {
                case 0:
                    $answerNo = "A";
                    break;
                case 1:
                    $answerNo = "B";
                    break;
                case 2:
                    $answerNo = "C";
                    break;
                case 4:
                    $answerNo = "D";
                    break;
            }

            echo "
                <div class='col-md-6'>
                    <div class='form-group'>
                        <label>Answer ($answerNo)</label>
                        <div class='form-inline'>
                            <input class='form-control' type='text' value='". $tempAnswer->getDescription() . "' readonly/>";

                if($tempAnswer->getTrueAnswer() ? true:false)
                    echo "<input type='radio' checked='checked' disabled='disabled' />";
                else
                    echo "<input type='radio' disabled='disabled' />";

                echo "</div>
                    </div>
                </div>";
        }

        echo "</div>
            </div>";
    }

    echo "<br /><a href='../index.php'><button class='btn btn-primary'>Back</button></a>";
}
?>