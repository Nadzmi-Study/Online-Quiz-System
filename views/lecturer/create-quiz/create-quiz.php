<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

$_SESSION['Title'] =  $_POST["quizTitle"];
$_SESSION['SubjectCode'] =  $_POST["subjectCode"];
$_SESSION['Subject'] =  $_POST["quizSubject"];
$_SESSION['Time'] =  $_POST["timeConstraint"];

header("Location: ../create-quiz/create-question.php");
?>