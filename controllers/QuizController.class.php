<?php

/**
 * Class QuizController
 */
class QuizController extends Controller {
    public function registerQuiz($newQuizData) {
        $sql = "CALL SP_Quiz_Insert(".$newQuizData["Title"].",".$newQuizData["TimeConstraint"].",".$newQuizData["SubjectNo"].",".$newQuizData["UserNo"].")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;

        return $result;
    }

    public function registerQuestion($newQuestionData) {
        $sql = "CALL SP_Question_Insert(".$newQuestionData["QuizID"].",".$newQuestionData["QuestionDesc"].")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;
        return $result;
    }

    public function registerAnswer($newAnswerData)
    {
        $sql="CALL SP_Answer_Insert(".$newAnswerData["QuestionID"].",".$newAnswerData["AnswerDesc"].",".$newAnswerData["TrueAnswer"].")";
        $query = $this->conn->query($sql);
        $this->conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;
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
}
?>