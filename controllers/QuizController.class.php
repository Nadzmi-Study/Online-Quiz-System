<?php

/**
 * Class QuizController
 *
 * @todo implement other QuizController's methods
 */
class QuizController {
    /**
     * @todo inplement registerQuiz() and return the quizID
     *
     * @param Quiz $quiz
     */
    public function registerQuiz($conn, Quiz $quiz) {
        $sql = "CALL SP_Quiz_Insert(".$quiz["Title"].",".$quiz["TimeConstraint"].",".$quiz["SubjectNo"].",".$quiz["UserNo"].")";
        $query = $conn->query($sql);
        $conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;

        return $result;
    }

    /**
     * @todo implement registerQuestion() and return questionID
     *
     * @param Question $question
     */
    public function registerQuestion($conn, Question $question) {
        $sql = "CALL SP_Question_Insert(".$question["QuizID"].",".$question["QuestionDesc"].")";
        $query = $conn->query($sql);
        $conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;
        return $result;
    }

    public function registerAnswer($conn, Answer $answer)
    {
        $sql="CALL SP_Answer_Insert(".$answer["QuestionID"].",".$answer["AnswerDesc"].",".$answer["TrueAnswer"].")";
        $query = $conn->query($sql);
        $conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc();
        else
            $result = null;
        return $result;
    }

    /**
     * @todo implement requestQuestionList() and return array of Question object
     *
     * @param $conn
     * @param $quizID
     */
    public function requestQuestionList($conn, $quizID) {}


    public function getListQuiz($conn) {
        $sql = "CALL SP_Quiz_GetALL";
        $query = $conn->query($sql) or die(mysqli_error($conn));
        $conn->next_result();

        $quizList = array();
        while($row = $query->fetch_assoc())
        {
            $result = array(
                "QuizTitle" => $row["Title"],
                "SubjectDesc" => $row["SubjectDesc"],
                "TimeConstraint" => $row["TimeConstraint"],
                "DateCreated" => $row["DateCreated"],
                "QuizNo" => $row["QuizNo"]
            );
            array_push($quizList,$result);
        }

        $conn->next_result();
        return $quizList; // return array of quiz
    }

    public function getQuestionByQuizId($conn, $quizID)
    {
        $sql = "CALL SP_Question_GetByQuizNo(".$quizID.")";
        $query = $conn->query($sql);
        $conn->next_result();

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

        $conn->next_result();
        return $questionList;
    }

    public function getAnswerByQuestionId($conn, $questionId)
    {
        //retrieve answers for particular question according to its question no
        $sql = "CALL SP_Answer_GetAnswerByQuestionNo(".$questionId.")";
        $query = $conn->query($sql);
        $conn->next_result();

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

        $conn->next_result();
        return $answerList;
    }

    public function getSubjectList($conn)
    {
        $sql = "CALL SP_LookupSubject_GetAll";
        $query = $conn->query($sql);
        $conn->next_result();

        $subjectList = array();
        while($row = $query->fetch_assoc())
        {
            $subjectResult = array(
                "SbjNo" => $row["SubjectNo"],
                "SbjCode" =>$row["SubjectCode"],
                "SbjDesc" => $row["SubjectDesc"]
            );
            array_push($subjectList, $subjectResult);
        }

        $conn->next_result();
        return $subjectList;
    }
}
?>