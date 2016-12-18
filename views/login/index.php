<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

$loginCheck = array(
    "error" => false,
    "message" => ""
);

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // check login credential
    $loginCredential = array(
        "Username" => $username,
        "Password" => $password
    );

    $loginCheck = $userManager->userLoginCheck($loginCredential);
    if(!$loginCheck["error"]) {
        $result = $userManager->login($username, $password);

        if(isset($result)) {
            if($result) {
                $user = unserialize($_SESSION["user"]);

                switch ($user->getUserType()) {
                    case "Student":
                        header("Location: ../student");
                        break;
                    case "Lecturer":
                        header("Location: ../lecturer");
                        break;
                    default:
                        break;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <title>Login</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Login</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="../register">Register</a></li>
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php $userManager->displayError($loginCheck["message"]); ?>
                            <form action="" method="post">
                                <div class="container-fluid">
                                    <div class="row">
                                        <input type="text" name="username" class="form-control" placeholder="Username" />
                                    </div>
                                    <div class="row">
                                        <input type="password" name="password" class="form-control" placeholder="Password" />
                                    </div>
                                    <div class="row">
                                        <input type="submit" class='btn btn-primary' name="login" value="Login" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
    </body>
</html>
