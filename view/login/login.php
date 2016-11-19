<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:05 AM
 */

include_once "../../includes/global.inc.php";

if(isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = $userManager->login($conn, $username, $password);

    if(isset($result))
        if($result)
            echo "Logged in";
        else
            echo "Not logged in";
    else
        echo "Not logged in";
} else
    header("Location: ../login");
?>