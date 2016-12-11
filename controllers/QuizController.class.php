<?php
require_once "Controller.php";
/**
 * Class QuizController
 */
class QuizController extends Controller {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function registerQuiz($newQuizData) {
        $sql = "CALL SP_Quiz_Insert('".$newQuizData["Title"]."','".$newQuizData["TimeConstraint"]."','".$newQuizData["SubjectNo"]."', @QuizID,'".$newQuizData["UserNo"]."')";
        $sql2 = "SELECT @QuizID AS QuizID";

        $this->conn->query($sql);
        $this->conn->next_result();
        $query = $this->conn->query($sql2) or die($this->conn->error);
        $this->conn->next_result();

        while($row = $query->fetch_assoc())
        {
            $result = $row["QuizID"];
        }
        return $result;
    }

    public function registerQuestion($newQuestionData) {
        $sql = "CALL SP_Question_Insert('".$newQuestionData["QuizID"]."','".$newQuestionData["QuestionDesc"]."',@QuestionNo)";
        $sql2 = "SELECT @QuestionNo AS QuestionNo";

        $this->conn->query($sql);
        $this->conn->next_result();
        $query = $this->conn->query($sql2) or die($this->conn->error);
        $this->conn->next_result();

        while($row = $query->fetch_assoc())
        {
            $result = $row["QuestionNo"];
        }
        return $result;
    }

    public function registerAnswer($newAnswerData)
    {
        $sql="CALL SP_Answer_Insert('".$newAnswerData["QuestionID"]."','".$newAnswerData["AnswerDesc"]."','".$newAnswerData["TrueAnswer"]."', @AnswerNo)";
        $sql2 = "SELECT @AnswerNo AS AnswerNo";

        $this->conn->query($sql);
        $this->conn->next_result();
        $query = $this->conn->query($sql2) or die($this->conn->error);
        $this->conn->next_result();

        while($row = $query->fetch_assoc())
        {
            $result = $row["AnswerNo"];
        }
        return $result;
    }

    public function requestQuestionList($quizID) {}

    public function getQuestionByQuizId($quizID)
    {
        $sql = "CALL SP_Question_GetByQuizNo(".$quizID.")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        //array that store question no with question description
        $questionList = array();
        while($row = $query->fetch_assoc())
        {
            $questionResult = array(
                "QuestionNo" => $row["QuestionNo"],
                "QuestionDesc" => $row["QuesDesc"]
            );
            array_push($questionList, $questionResult);
        }

        $this->conn->next_result();
        return $questionList;
    }

    public function getAnswerByQuestionId($questionId)
    {
        //retrieve answers for particular question according to its question no
        $sql = "CALL SP_Answer_GetAnswerByQuestionNo(".$questionId.")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        //array that store 4 answer per index
        $answerList = array();
        while($row = $query->fetch_assoc()) {
            $answerResult = array(
                "AnswerNo" => $row["AnswerNo"],
                "AnswerDesc" => $row["AnswerDesc"],
                "TrueAnswer" => $row["TrueAnswer"]
            );
            array_push($answerList, $answerResult);
        }

        $this->conn->next_result();
        return $answerList;
    }

    public function retrieveQuizList() {
        $sql = "CALL SP_Quiz_GetALL";
        $query = $this->conn->query($sql) or die(mysqli_error($this->conn));
        $this->conn->next_result();

        $quizList = array();
        while($row = $query->fetch_assoc()) {
            array_push($quizList,$row);
        }

        return $quizList; // return array of quiz
    }

    public function retrieveSubjectList() {
        $sql = "CALL SP_LookupSubject_GetAll";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        $subjectList = array();
        while($row = $query->fetch_assoc()) {
            array_push($subjectList, $row);
        }

        return $subjectList;
    }

    public function getTrueAnswer($quizId)
    {
        $sql = "CALL SP_Answer_GetAllTrueAnswerByQuizID(".$quizId.")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        $trueAnswerList = array();
        while($row = $query->fetch_assoc()) {
            $answerResult = array(
                "Desc" => $row["Desc"],
                "Answer" => $row["Answer"]
            );
            array_push($trueAnswerList, $answerResult);
        }

        $this->conn->next_result();
        return $trueAnswerList;
    }
}
?>