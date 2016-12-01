<?php
require_once "conn.inc.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/User.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/Quiz.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/Question.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/Answer.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/Subject.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/models/UserType.class.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/controllers/UserController.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/controllers/UserTypeController.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/controllers/QuizController.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/controllers/StatisticController.class.php";

require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/managers/UserManager.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/managers/UserTypeManager.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/managers/QuizManager.class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/managers/StatisticManager.class.php";

//temporary path
$tempDocumentRoot = "D:/xampp/htdocs";
session_start(); // start session

// initialize controllers
$userController = new UserController($conn);
$userTypeController = new UserTypeController($conn);
$quizController = new QuizController($conn);
$statisticController = new StatisticController($conn);

// initialize managers
$userManager = new UserManager($userController);
$userTypeManager = new UserTypeManager($userTypeController);
$quizManager = new QuizManager($quizController);
$statisticManager = new StatisticManager($statisticController);

// refresh user session
if(isset($_SESSION["logged_in"]))
    if($_SESSION["logged_in"]) {
        $user = unserialize($_SESSION["user"]);
        $_SESSION["user"] = serialize($userManager->getUser($user->getUserNo()));
    }
?>

