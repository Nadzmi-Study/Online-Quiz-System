<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";
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
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Available Quiz</div>
                <table class="table">
                    <tr>
                        <th>Question No</th>
                        <th>Question Description</th>
                        <th>Your Answer</th>
                        <th>True Answer</th>
                    </tr>
                    <?php displayResult($quizManager); ?>
                </table>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</body>
</html>

<?php
function displayResult($quizManager)
{
    $tempResult = $quizManager->getResultAnswerById($_SESSION["Temp-QuizID"]);
    for($x=0; $x<sizeof($tempResult); $x++)
    {
        $number = $x+1;
        echo "
            <tr>     
                 <td>$number</td>
                 <td>".$tempResult[$x]["Desc"]."</td>
                 <td></td>
                 <td>".$tempResult[$x]["Answer"]."</td>
             </tr>
             ";
    }

}

?>


