<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 27/11/2016
 * Time: 11:07 PM
 */
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
                <a class="navbar-brand" href="#">Lecturer Page</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="..//lecturer/create-quiz/index.html">Create Quiz</a></li>
                <li><a href="..//lecturer/delete-quiz/index.html">Delete Quiz</a></li>
                <li><a href="..//lecturer/update-quiz/index.html">Update Quiz</a></li>
                <li><a href="../logout">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <?php displayQuizStatistics();?>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>
</body>
</html>

<?php
    function displayQuizStatistics()
    {
        echo "<div class='panel panel-default'>
                    <div class='container-fluid'>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label>Quiz Title</label>
                            </div>
                            <div class='col-md-10'>
                                <input class='form-control' value='Test title' readonly>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label>Quiz Subject</label>
                            </div>
                            <div class='col-md-10'>
                                <input class='form-control' value='Test title' readonly>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label>Quiz Time</label>
                            </div>
                            <div class='col-md-10'>
                                <input class='form-control' value='Test title' readonly>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label>Quiz Date</label>
                            </div>
                            <div class='col-md-10'>
                                <input class='form-control' value='Test title' readonly>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-2'>
                                <label>Quiz Statistics</label>
                            </div>
                            <div class='col-md-10'>
                                <input class='form-control' value='Test title' readonly>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='col-md-10'></div>
                            <div class='col-md-2'>
                                <button class='btn btn-default'>View details</button>
                            </div>
                        </div>
                    </div>
                </div>";
    }
?>

