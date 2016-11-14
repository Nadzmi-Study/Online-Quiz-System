<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

include_once "conn.inc.php";
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/Online-Quiz-System/model/User.class.php";
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/Online-Quiz-System/model/Quiz.class.php";
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/Online-Quiz-System/controller/UserController.class.php";
include_once realpath($_SERVER["DOCUMENT_ROOT"]) . "/Online-Quiz-System/controller/QuizController.class.php";

session_start(); // start session

// initialize controllers
$userController = new UserController();
$quizController = new QuizController();
?>

