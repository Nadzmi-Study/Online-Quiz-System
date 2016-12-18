<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

if(isset($_POST["confirmation"])) {
    switch($_POST["confirmation"]) {
        case "confirm":
            $result = $quizManager->getDeleteConfirmation($_POST["quizNo"]);

            echo "<script> window.location = 'index.php'; </script>";
            break;
        case "not-confirm":
        $url = $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/view/lecturer";

            echo "<script> window.location = 'index.php'; </script>";
            break;
    }
}
?>

<html>
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

        <header></header>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <h2>Are you sure to delete?</h2>
                        <form action="" method="post">
                            <input type="hidden" name="quizNo" value="<?php echo $_POST["quizID"]; ?>" />
                            <button type="submit" class='confirm-btn btn btn-primary' name="confirmation" value="confirm">Confirm</button>
                            <button type="submit" class='cancel-btn btn btn-primary' name="confirmation" value="not-confirm">Cancel</button>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>
            </div>
        </div>
        <footer></footer>
    </body>
</html>
