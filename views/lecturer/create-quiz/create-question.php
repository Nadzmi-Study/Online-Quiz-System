<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

$user = unserialize($_SESSION["user"]);
if(isset($_POST["submit_question"]))
{
    $title = $_SESSION['Title'];
    $subjectCode = $_SESSION['SubjectCode'];
    $time = $_SESSION['Time'];

    $quizTemp = new Quiz($title, $subjectCode, $time);
    //temporary: 8 is userNo which is a lecturer type
    $quizID = $quizManager->createQuiz($quizTemp, $user->getUserNo());
    if(isset($quizID))
    {
        for($i=0; $i<10; $i++)
        {
            $quesDesc = $_POST["questionDesc($i)"];

            $questionTemp = new Question($quesDesc);
            $questionID = $quizManager->createQuestion($questionTemp, $quizID);

            if(isset($questionID))
            {
                //insert 4 answers for each question
                $answerA = $_POST["answerA($i)"];
                $answerTrueAnswerA = $_POST["trueAnswer(A$i)"];
                $answerTemp = new Answer(0,$answerA, $answerTrueAnswerA, false );
                $insertAnswerA = $quizManager->createAnswer($answerTemp, $questionID);

                $answerB = $_POST["answerB($i)"];
                $answerTrueAnswerB = $_POST["trueAnswer(B$i)"];
                $answerTemp = new Answer(0,$answerB, $answerTrueAnswerB, false );
                $insertAnswerB = $quizManager->createAnswer($answerTemp, $questionID);

                $answerC = $_POST["answerC($i)"];
                $answerTrueAnswerC = $_POST["trueAnswer(C$i)"];
                $answerTemp = new Answer(0,$answerC, $answerTrueAnswerC, false );
                $insertAnswerC = $quizManager->createAnswer($answerTemp, $questionID);

                $answerD = $_POST["answerD($i)"];
                $answerTrueAnswerD = $_POST["trueAnswer(D$i)"];
                $answerTemp = new Answer(0,$answerD, $answerTrueAnswerD, false );
                $insertAnswerD = $quizManager->createAnswer($answerTemp, $questionID);
            }
        }
    }
    header("Location:../views/sucsess-page.html");
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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8">
                    <form action="create-question.php" method="post">
                        <?php displayQuestion();?>
                        <div>
                            <input type="submit" class="btn btn-primary" name="submit_question" value="Submit question">
                        </div>
                    </form>
                </div>
                <div class="col-md-2"></div>
            </div>
        </div>
    </body>
</html>

<?php
    function displayQuestion()
    {
        for($i=0; $i<10; $i++)
        {
            $no =($i+1);
            echo "<div class=\"panel panel-default\">
                            <div class=\"container-fluid\">
                                <div class=\"row\">
                                    <div class=\"col-md-12\">
                                        <div class=\"form-group\">
                                            <label>$no) Question Description</label>
                                            <input class=\"form-control\" type=\"text\" name=\"questionDesc(".$i.")\">
                                        </div>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <div class=\"form-group\">
                                            <label>Answer (A)</label>
                                            <div class=\"form-inline\">
                                                <input class=\"form-control\" type=\"text\" name=\"answerA(".$i.")\">
                                                <input type=\"radio\" name=\"trueAnswer(A".$i.")\" value='1'> This is the answer
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <div class=\"form-group\">
                                            <label>Answer (B)</label>
                                            <div class=\"form-inline\">
                                                <input class=\"form-control\" type=\"text\" name=\"answerB(".$i.")\">
                                                <input type=\"radio\" name=\"trueAnswer(B".$i.")\" value='1'> This is the answer
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class=\"row\">
                                    <div class=\"col-md-6\">
                                        <div class=\"form-group\">
                                            <label>Answer (C)</label>
                                            <div class=\"form-inline\">
                                                <input class=\"form-control\" type=\"text\" name=\"answerC(".$i.")\">
                                                <input type=\"radio\" name=\"trueAnswer(C".$i.")\" value='1'> This is the answer
                                            </div>
                                        </div>
                                    </div>
                                    <div class=\"col-md-6\">
                                        <div class=\"form-group\">
                                            <label>Answer (D)</label>
                                            <div class=\"form-inline\">
                                                <input class=\"form-control\" type=\"text\" name=\"answerD(".$i.")\">
                                                <input type=\"radio\" name=\"trueAnswer(D".$i.")\" value='1'> This is the answer
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>";
        }
    }
?>

