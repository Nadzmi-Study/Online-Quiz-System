<?php
include_once "../../includes/global.inc.php";


if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $userManager->login($conn, $username, $password);

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
            }
        } else
            header("Location: index.html");
    } else
        header("Location: ../login");
} else
    header("Location: ../login");
?>