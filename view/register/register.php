<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:06 AM
 */

include_once "../../includes/global.inc.php";

if(isset($_POST["register"])) {
    $userType = $_POST["userType"];
    $name = $_POST["name"];
    $ic = $_POST["ic"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rePassword = $_POST["re-password"];

    if(($password == $rePassword) || ($userType == 0)) {
        $newUser = new User($userType, $name, $ic, $contact, $email, $username, $password);

        // call usermanager to register user here

        header("Location: ../login");
    } else
        header("Location: ../register");
} else
    header("Location: ../register");
?>