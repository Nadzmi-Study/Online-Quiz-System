<?php
require_once "Manager.class.php";

/**
 * Class QuizManager
 */
class QuizManager extends Manager {
    private $QC; // quiz controller

    public function __construct(QuizController $QC=null) {
        $this->QC = $QC;
    }

    public function getQuestionList($quizID) {}

    public function checkQuizDesc(Quiz $quiz) {}

    public function checkQuestionDesc($questions) {}

    public function checkAnswerDesc($answers) {}

    public function checkAnswer($answeredQuestions) {}

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

    public function calculateScore(Quiz $answeredQuiz) {}

    public function randomizeQuestion($questions) {}

    public function getQuizList() {
        $tempQuizList = $this->QC->retrieveQuizList();

        $quizObjects = array();
        for($x = 0 ; $x<sizeof($tempQuizList) ; $x++) {
            array_push($quizObjects, new Quiz($tempQuizList[$x]["Title"], $tempQuizList[$x]["SubjectNo"], $tempQuizList[$x]["TimeConstraint"], $tempQuizList[$x]["DateCreated"], $tempQuizList[$x]["QuizNo"]));
        }

        return $quizObjects;
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