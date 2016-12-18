<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

if(isset($_POST["register-quiz"])) {
    $quizTitle = $_POST["quizTitle"];
    $subjectCode = $_POST["subjectCode"];
    $timeConstraint = $_POST["timeConstraint"];

    // temp question obj
    $questionObj = array();
    for($x=0 ; $x<10 ; $x++) {
        $tempQuestionDesc = $_POST["questionDesc(" . $x . ")"];

        // temp ans obj
        $answerObj = array();
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

        array_push($answerObj, $tempAnsA);
        array_push($answerObj, $tempAnsB);
        array_push($answerObj, $tempAnsC);
        array_push($answerObj, $tempAnsD);

        $tempQuestion = new Question($tempQuestionDesc, $answerObj);

        array_push($questionObj, $tempQuestion);
    }

    // temp quiz obj
    $newQuiz = new Quiz($quizTitle, $subjectCode, $timeConstraint, null, 0, $questionObj);
    $insertResult = $quizManager->registerQuiz($newQuiz);

    if(isset($insertResult))
        echo "<script> window.location = '../index.php' </script>";
    else
        echo "Failed to create question";
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
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Quiz Title:</label>
                            <input type="text" class="form-control" name="quizTitle" />
                        </div>
                        <div class="form-group"=>
                            <label>Subject:</label>
                            <select class="form-control" name="subjectCode">
                               <?php displaySubject($quizManager); ?>
                            </select>
                        </div>
                        <?php displayQuestionForm(); ?>

                        <div>
                            <input type="submit" class="btn btn-primary" name="register-quiz" value="Create Quiz" />
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>

<?php
function displaySubject($quizManager) {
    $subjectList = $quizManager->getSubjectList();

    echo "<option>Select subject</option>";
    for($x = 0 ; $x<sizeof($subjectList) ; $x++) {
        echo "<option value='" . $subjectList[$x]->getSubjectNo() . "'>" . $subjectList[$x]->getSubjectCode() . " - " . $subjectList[$x]->getSubjectDesc() . "</option>";
    }
}

function displayQuestionForm() {
    for($i=0; $i<10; $i++)  {
        $no =($i+1);
        echo "
            <br /><br />
            <div class='panel panel-default'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
                            <div class='form-group'>
                                <label>$no) Question Description</label>
                                <input class='form-control' type='text' name='questionDesc($i)'>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (A)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerA($i)'>
                                    <input type='radio' name='trueAnswer(A$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (B)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerB($i)'>
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
                                    <input class='form-control' type='text' name='answerC($i)'>
                                    <input type='radio' name='trueAnswer(C$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='form-group'>
                                <label>Answer (D)</label>
                                <div class='form-inline'>
                                    <input class='form-control' type='text' name='answerD($i)'>
                                    <input type='radio' name='trueAnswer(D$i)' value='1'> This is the answer
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
    }
}
?>