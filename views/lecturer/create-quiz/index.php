<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";
//echo $_SERVER['DOCUMENT_ROOT'];
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
                    <a class="navbar-brand" href="#">Lecturer Page</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="view-statistics">View Statistics</a></li>
                    <li><a href="../lecturer/create-quiz">Create Quiz</a></li>
                    <li><a href="../lecturer/delete-quiz">Delete Quiz</a></li>
                    <li><a href="../lecturer/update-quiz">Update Quiz</a></li>
                    <li><a href="../logout">Logout</a></li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form action="create-quiz.php" method="post">
                        <div class="form-group">
                            <label>Quiz Title:</label>
                            <input type="text" class="form-control" name="quizTitle">
                        </div>
                        <div class="form-group"=>
                            <label>Subject:</label>
                            <select class="form-control" name="subjectCode">
                               <?php displaySubject($quizManager); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quiz Subject:</label>
                            <input type="text" class="form-control" name="quizSubject">
                        </div>
                        <div class="form-group">
                            <label>Time Constraint:</label>
                            <input type="text" class="form-control" name="timeConstraint">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary" name="submit_quiz" value="Create Quiz">
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
?>