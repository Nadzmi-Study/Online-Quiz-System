<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

include_once "conn.inc.php";
include_once "../model/User.class.php";
include_once "../model/Quiz.class.php";
include_once "../model/Question.class.php";
include_once "../model/Answer.class.php";
include_once "../model/Subject.class.php";
include_once "../model/UserType.class.php";
include_once "../controller/UserController.class.php";
include_once "../controller/QuizController.class.php";
include_once "../controller/StatisticController.class.php";
include_once "../manager/QuizManager.class.php";
include_once "../manager/StatisticManager.class.php";
include_once "../manager/UserManager.class.php";

session_start(); // start session

// initialize controllers
$userController = new UserController();
$quizController = new QuizController();
?>

