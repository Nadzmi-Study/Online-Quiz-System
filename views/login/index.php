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
    </head>
    <body>
        <?php $userManager->displayError($loginCheck["message"]); ?>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username" />
            <input type="password" name="password" placeholder="Password" />
            <input type="submit" name="login" value="Login" placeholder="Login" />
        </form>
        <a href="../register">Register</a>
    </body>
</html>