<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

$quiz = new Quiz();
if(isset($_POST["updateQuiz"])) {
    $quizNo = $_POST["quiz-no"];
    $tempQuiz = $quizManager->getQuizList();

    for($x=0 ; $x<sizeof($tempQuiz) ; $x++)
        if($tempQuiz[$x]->getNo() == $quizNo)
            $quiz = $tempQuiz[$x];

    $quiz->setQuestion($quizManager->getQuestionList($quiz->getNo()));
}

if(isset($_POST["update"])) {
    $quizID = $_POST["quiz-id"];
    $updatedQuizTitle = $_POST["quiz-title"];
    $updatedQuizSubject = $_POST["quiz-subject"];

    // temp question obj
    $updatedQuestions = array();
    for($x=0 ; $x<10 ; $x++) {
        $tempQuestionDesc = $_POST["questionDesc(" . $x . ")"];

        // temp ans obj
        $updatedAnswers = array();
        // a
        $answerA = $_POST["answerA($x)"];
        if(!isset($_POST["trueAnswer(A$x)"]))
            $answerTrueAnswerA = false;
        else
            $answerTrueAnswerA = true;
        // b
        $answerB = $_POST["answerB($x)"];
        if(!isset($_POST["trueAnswer(B$x)"]))
            $answerTrueAnswerB = false;
        else
            $answerTrueAnswerB = true;
        // c
        $answerC = $_POST["answerC($x)"];
        if(!isset($_POST["trueAnswer(C$x)"]))
            $answerTrueAnswerC = false;
        else
            $answerTrueAnswerC = true;
        // d
        $answerD = $_POST["answerD($x)"];
        if(!isset($_POST["trueAnswer(D$x)"]))
            $answerTrueAnswerD = false;
        else
            $answerTrueAnswerD = true;

        $tempAnsA = new Answer(0, $answerA, $answerTrueAnswerA, false);
        $tempAnsB = new Answer(0, $answerB, $answerTrueAnswerB, false);
        $tempAnsC = new Answer(0, $answerC, $answerTrueAnswerC, false);
        $tempAnsD = new Answer(0, $answerD, $answerTrueAnswerD, false);

        array_push($updatedAnswers, $tempAnsA);
        array_push($updatedAnswers, $tempAnsB);
        array_push($updatedAnswers, $tempAnsC);
        array_push($updatedAnswers, $tempAnsD);

        $tempQuestion = new Question($tempQuestionDesc, $updatedAnswers);

        array_push($updatedQuestions, $tempQuestion);
    }

    $updatedQuiz = new Quiz($updatedQuizTitle, $updatedQuizSubject, null, $quizID, $updatedQuestions);
    $result = $quizManager->updateQuiz($updatedQuiz);

    if($result)
        echo "<script> window.location = '../index.php'; </script>";
    else
        echo "Failed to update";
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
            <div class="row">
                <div class="col-md-5">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="../index.php">Hello, <?php echo $user->getName()?></a>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <ul class="nav navbar-nav">
                        <li><a href="../create-quiz">Create Quiz</a></li>
                        <li><a href="../delete-quiz">Delete Quiz</a></li>
                        <li><a href="../update-quiz">Update Quiz</a></li>
                        <li><a href="../../logout">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="" method="post">
                        <?php displayQuizDesc($quiz); ?>
                    </form>
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
            <input type='hidden' name='quiz-id' value='" . $_POST["quiz-no"] . "'>
            <input type='text' class='form-control' name='quiz-title' value='" . $quiz->getTitle() . "' />
        </div>
        <div class='form-group'>
            <label>Subject:</label>
            <input type='text' class='form-control' name='quiz-subject' value='" . $quiz->getSubject() . "' readonly/>
        </div>
    ";

    for($i=0; $i<10; $i++)  {
        $no =($i+1);
        $tempQuestion = $quiz->getQuestion()[$i];

        echo "
            <br /><br />
            <div class='panel panel-default'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label>$no) Question Description</label>
                                <input class='form-control' type='text' name='questionDesc($i)' value='" . $tempQuestion->getDescription() . "'>
                            </div>
                        </div>
                    </div>";

        for($x=0 ; $x<4 ; $x+=4) {
            echo "
                <div class='row'>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (A)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerA($i)' value='" . $tempQuestion->getAnswer()[$x]->getDescription() . "'>
                                    <input type='radio' name='trueAnswer(A$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (B)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerB($i)' value='" . $tempQuestion->getAnswer()[$x+1]->getDescription() . "'>
                                    <input type='radio' name='trueAnswer(B$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (C)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerC($i)' value='" . $tempQuestion->getAnswer()[$x+2]->getDescription() . "'>
                                    <input type='radio' name='trueAnswer(C$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (D)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerD($i)' value='" . $tempQuestion->getAnswer()[$x+3]->getDescription() . "'>
                                    <input type='radio' name='trueAnswer(D$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                    </div>";
        }

        echo "</div>
            </div>";
    }

    echo "<br /><a href='../index.php'><button class='btn btn-primary'>Cancel</button></a>
        <a href='../index.php'><input type='submit' class='btn btn-primary' name='update' value='Update' /></a>";
}
?>