<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";
    //include_once "../../includes/global.inc.php";
//require_once "../../../controllers/QuizController.class.php";
//require_once "../../../managers/QuizManager.class.php";
//require_once "../../../models/Quiz.class.php";

//$conn = new mysqli("localhost","root","","online_quiz_system");
//$QC = new QuizController();
//$quizManager = new QuizManager($QC);

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
               <div class="col-md-3"></div>
               <div class="col-md-6">
                   <form action="success-answer.html" method="post">
                       <h5>Time: </h5>
                       <?php displayQuestion($quizManager); ?>
                       <div class="container-fluid">
                           <input type="submit" name="submit-question" value="Submit Answer" class="btn btn-success"/>
                       </div>
                   </form>
               </div>
                 <div class="col-md-3"></div>
             </div>
         </div>
    </body>
</html>

<?php
function displayQuestion($quizManager)
{
    $numberOfAnswer = 0;
    //temporary: 5 is quizId
    $questionList = $quizManager->getQuestionByQuizId(5);
    for($i=0; $i<sizeof($questionList); $i++)
    {
        $answerList = $quizManager->getAnswerByQuestionId($i);
        echo "<div class='panel panel-default'>
                <!-- Default panel contents -->
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-1'>
                            <div class='checkbox'>
                                <label><input type='checkbox' value=''></label>
                            </div>
                        </div>
                        <div class='col-md-11'>
                            <h4>".$questionList[$i]->getDescription()."</h4>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-1'></div>
                        <div class='col-md-5'>
                            <div class='radio'>
                                <label><input type='radio' name='answer$i' value='".$answerList[$numberOfAnswer]->getTrueAnswer()."' />A - ".$answerList[$numberOfAnswer]->getDescription()."</label>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' name='answer$i'  value='".$answerList[$numberOfAnswer+1]->getTrueAnswer()."' />B - ".$answerList[$numberOfAnswer+1]->getDescription()."</label>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <div class='radio'>
                                <label><input type='radio' name='answer$i'  value='".$answerList[$numberOfAnswer+2]->getTrueAnswer()."' />C - ".$answerList[$numberOfAnswer+2]->getDescription()."</label>
                            </div>
                            <div class='radio'>
                                <label><input type='radio' name='answer$i'  value='".$answerList[$numberOfAnswer+3]->getTrueAnswer()."' />D - ".$answerList[$numberOfAnswer+3]->getDescription()."</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
        $numberOfAnswer = $numberOfAnswer + 4;
    }
}
?>


