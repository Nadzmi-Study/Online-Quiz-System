<?php
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
        <title>Register</title>
    </head>
    <body>
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
                               <?php testSubject($conn);?>
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
    function displaySubject($conn, $quizManager)
    {
        echo "<option>Select subject</option>";
        $subjectList = $quizManager->getSubject($conn);
        for($i=0; $i<sizeof($subjectList); $i++)
        {
            echo"<option value='".$subjectList[$i]->getSubjectNo()."'>".$subjectList[$i]->getSubjectDescription()."</option>";
        }
    }

    //since there was a problem at displaySubject() above, this temp method just test the algorithm
    function testSubject($conn)
    {
        echo "<option>Select subject</option>";
        $sql = "CALL SP_LookupSubject_GetAll";
        $query = $conn->query($sql);
        $conn->next_result();

        while($row = $query->fetch_assoc())
        {
            echo "<option value='".$row["SubjectNo"]."'>".$row["SubjectCode"]." - ".$row["SubjectDesc"]."</option>";
        }

        $conn->next_result();
    }
?>