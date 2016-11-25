<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

if(isset($_SESSION["logged_in"])) {
    if($_SESSION["logged_in"]) {
        $user = unserialize($_SESSION["user"]);

        switch ($user->getUserType()) {
            case "Student":
                header("Location: student");
                break;
            case "Lecturer":
                header("Location: lecturer");
                break;
        }
    } else
        header("Location: login");
} else
    header("Location: login");
?>

