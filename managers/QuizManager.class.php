<?php
require_once "Manager.class.php";

/**
 * Class QuizManager
 */
class QuizManager extends Manager {
    private $QC; // quiz controller
    private $form; // form

    public function __construct(QuizController $QC=null) {
        $this->QC = $QC;
    }

    //
    public function getQuizList($userId=null) {
        $tempQuizList = $this->QC->retrieveQuiz($userId);

        $quizObjects = null;
        if(isset($userId)) {
            $quizObjects = array();
            for($x = 0 ; $x<sizeof($tempQuizList) ; $x++)
                array_push($quizObjects,
                    new Quiz(
                        $tempQuizList[$x]["QuizTitle"],
                        $tempQuizList[$x]["Subject"],
                        $tempQuizList[$x]["Time"],
                        $tempQuizList[$x]["DateCreated"]));
        } else {
            $quizObjects = array();
            for($x = 0 ; $x<sizeof($tempQuizList) ; $x++)
                array_push($quizObjects,
                    new Quiz(
                        $tempQuizList[$x]["QuizTitle"],
                        $tempQuizList[$x]["Subject"],
                        $tempQuizList[$x]["Time"],
                        $tempQuizList[$x]["DateCreated"],
                        $tempQuizList[$x]["QuizNo"]));
        }

        return $quizObjects;
    }

    public function getQuestionList($quizId) {
        $tempQuestionList = $this->QC->retrieveQuestion($quizId);

        $questionObject = array();
        for($x=0 ; $x<sizeof($tempQuestionList) ; $x++) {
            $tempAnswerList = $this->QC->retrieveAnswer($tempQuestionList["QuestionID"]);

            $answerObject = array();
            for($a = 0 ; $a<sizeof($tempAnswerList) ; $a++)
                array_push($answerObject,
                    new Answer(
                        $tempAnswerList["AnswerID"],
                        $tempAnswerList["AnswerDesc"],
                        $tempAnswerList["TrueAnswer"],
                        $tempAnswerList["StudentAnswer"]));

            array_push($questionObject,
                new Question(
                    $tempQuestionList["Description"],
                    $answerObject,
                    $tempQuestionList["QuestionID"]));
        }

        return $questionObject;
    }

    public function getDeleteConfirmation($confirmation, $quizID) {
        if(!$confirmation)
            echo "Do not delete";
        else {
            $result = $this->QC->deleteQuiz($quizID);

            if(!$result)
                echo "Deleted";
            else
                echo "Failed to delete";
        }
    }

    public function checkQuizDesc(Quiz $quiz) {
        if(empty($quiz->getTitle()) || empty($quiz->getTime()))
            return false;
        else if($quiz->getSubject() == 0)
            return false;

        return true;
    }

    public function checkQuestionDesc(Question $question) {
        if(empty($question->getDescription()))
            return false;
        else if($question->getAnswer() == null)
            return false;

        return true;
    }

    public function checkAnswerDesc(Answer $answer) {
        if(empty($answer->getDescription()) || empty($answer->getTrueAnswer()))
            return false;

        return true;
    }
    //

    public function createQuiz(Quiz $quiz, $userNo) {
        $newQuizData = array(
            "Title" => $quiz->getTitle(),
            "TimeConstraint" => $quiz->getTime(),
            "SubjectNo" => $quiz->getSubject(),
            "UserNo" => $userNo
        );

        $result = $this->QC->registerQuiz($newQuizData);
        if(isset($result))
            return $result;
        else
            return null;
    }

    public function createQuestion(Question $question,$quizID) {
        $newQuestionData = array(
            "QuestionDesc" => $question->getDescription(),
            "QuizID" => $quizID
        );

        $result =  $this->QC->registerQuestion($newQuestionData);
        if(isset($result))
            return $result;
        else
            return null;
    }

    public function createAnswer(Answer $answer, $questionID)
    {
        $newAnswerData = array(
            "AnswerDesc" => $answer->getDescription(),
            "TrueAnswer" => $answer->getTrueAnswer(),
            "QuestionID" => $questionID
        );

        $result = $this->QC->registerAnswer($newAnswerData);

        return $result;
    }

    public function getQuestionByQuizId($quizNo)
    {
        $tempQuestionList = $this->QC->getQuestionByQuizId($quizNo);
        $questionList = array();
        for($i=0; $i<sizeof($tempQuestionList); $i++){
            array_push($questionList, new Question($tempQuestionList[$i]["QuestionDesc"],"", $tempQuestionList[$i]["QuestionNo"]  ));
        }

        return $questionList;
    }

    public function getAnswerByQuestionId($questionNo)
    {
        $tempAnswerList = $this->QC->getAnswerByQuestionId($questionNo);
        $answerList = array();
        for($j=0; $j<sizeof($tempAnswerList); $j++)
        {
            array_push($answerList, new Answer($tempAnswerList[$j]["AnswerNo"], $tempAnswerList[$j]["AnswerDesc"], $tempAnswerList[$j]["TrueAnswer"]));
        }

        return $answerList;
    }

    public function getSubjectList() {
        $tempSubjectList = $this->QC->retrieveSubjectList();

        $subjectList = array();
        for($x = 0 ; $x<sizeof($tempSubjectList) ; $x++) {
            array_push($subjectList, new Subject($tempSubjectList[$x]["SubjectCode"], $tempSubjectList[$x]["SubjectDesc"], $tempSubjectList[$x]["SubjectNo"]));
        }

        return $subjectList;
    }
}
?>