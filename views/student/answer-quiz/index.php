<?php
//require_once "../../includes/global.inc.php";
require_once "../../../controllers/QuizController.class.php";
require_once "../../../managers/QuizManager.class.php";
require_once "../../../models/Quiz.class.php";

$conn = new mysqli("localhost","root","","online_quiz_system");
$QC = new QuizController();
$quizManager = new QuizManager($QC);
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
    <title>Title</title>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Student Page</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="/Online-Quiz-System/view/student/answer-quiz/index.php">Answer Quiz</a></li>
            <li><a href="../logout">Logout</a></li>
        </ul>
    </div>
</nav>

<header></header>
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <!-- Default panel contents -->
                    <div class="panel-heading">Available Quiz</div>
                        <table class="table">
                            <tr>
                                <th>Quiz No</th>
                                <th>Quiz Title</th>
                                <th>Subject Name</th>
                                <th>Date Created</th>
                            </tr>
                            <?php displayQuiz($conn, $quizManager);?>
                        </table>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</div>
<footer></footer>
</body>
</html>

<?php
function displayQuiz($conn,$quizManager)
{
    $quizList = $quizManager->getListQuiz($conn);
    for($x=0; $x<sizeof($quizList); $x++)
    {

        $number = $x+1;
        echo "<tr>     
                 <td> .$number.</td>
                 <td>".$quizList[$x]->getTitle()."</td>
                 <td>".$quizList[$x]->getSubject()."</td>
                 <td>".$quizList[$x]->getDateCreated()."</td>
             </tr>";
    }

}
?>