<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";
$user = unserialize($_SESSION["user"]);
$username = $user->getName();
$userno = $user->getUserNo();
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
                    <li><a href="view-statistics">View Statistics</a></li>
                    <li><a href="../lecturer/create-quiz">Create Quiz</a></li>
                    <li><a href="../lecturer/delete-quiz">Delete Quiz</a></li>
                    <li><a href="../lecturer/update-quiz">Update Quiz</a></li>
                    <li><a href="../logout">Logout</a></li>
                </ul>
            </div>
        </nav>
        <table>
            <tr>
                <th>No</th>
                <th>Quiz Title</th>
                <th>Subject</th>
                <th>Time</th>
                <th>Date Created</th>
            </tr>
            <?php displayQuizes($quizManager); ?>
        </table>
    </body>
</html>

<?php
function displayQuizes($quizManager) {
    $tempUser = unserialize($_SESSION["user"]);
    $tempQuizes = $quizManager->getQuizList($tempUser->getUserNo());

    for($x=0 ; $x<sizeof($tempQuizes) ; $x++) {
        echo "
            <tr>
                <th></th> <!-- quiz no -->
                <th>" . $tempQuizes[$x]->getTitle() . "</th> <!-- quiz title -->
                <th>" . $tempQuizes[$x]->getSubject() . "</th> <!-- subject -->
                <th>" . $tempQuizes[$x]->getTime() . "</th> <!-- time -->
                <th>" . $tempQuizes[$x]->getDateCreated() . "</th> <!-- date created -->
            </tr>
        ";
    }
}
?>

