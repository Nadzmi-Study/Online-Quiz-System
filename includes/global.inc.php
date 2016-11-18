<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

require_once "conn.inc.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\User.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\Quiz.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\Question.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\Answer.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\Subject.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\models\\UserType.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\controllers\\UserController.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\controllers\\QuizController.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\controllers\\StatisticController.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\managers\\QuizManager.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\managers\\StatisticManager.class.php";
require_once "C:\\xampp\\htdocs\\Online-Quiz-System\\managers\\UserManager.class.php";

session_start(); // start session

// initialize controllers
$userManager = new UserManager();
$quizManager = new QuizManager();
$statisticManager = new StatisticManager();
$userController = new UserController();
$quizController = new QuizController();
$statisticController = new StatisticController();
?>

