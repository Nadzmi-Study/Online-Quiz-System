<?php
require_once "Manager.class.php";

/**
 * Class QuizManager
 *
 * @todo implement other QuizManager's methods
 */
class QuizManager extends Manager {
    private $QC; // quiz controller

    /**
     * QuizManager constructor.
     *
     * @param QuizController|null $QC
     */
    public function __construct(QuizController $QC=null) {
        $this->QC = $QC;
    }

    /**
     * @param string $quizID
     * @return Question[]
     */
    public function getQuestionList($quizID) {

    }

    /**
     * check quiz description during quiz registration
     *
     * @param Quiz $quiz
     * @return boolean
     */
    public function checkQuizDesc(Quiz $quiz) {}

    /**
     * check question description during quiz registration
     *
     * @param Question[] $questions
     * @return boolean
     */
    public function checkQuestionDesc($questions) {}

    /**
     * check answer description during quiz registration
     *
     * @param Answer[] $answers
     * @return boolean
     */
    public function checkAnswerDesc($answers) {}

    /**
     * check if all question has been answered or not
     *
     * @param Question[] $answeredQuestions
     * @return boolean
     */
    public function checkAnswer($answeredQuestions) {}

    /**
     * create new quiz
     *
     * @param Quiz $quiz
     */
    public function createQuiz($conn,Quiz $quiz, $userNo) {
        $newQuizData = array(
            "Title" => $quiz->getTitle(),
            "TimeConstraint" => $quiz->getTime(),
            "SubjectNo" => $quiz->getSubject(),
            "UserNo" => $userNo
        );

        $result = $this->QC->registerQuiz($conn, $newQuizData);
        if(isset($result))
            return $result;
        else
            return null;
    }

    /**
     * create new question
     *
     * @param Question $question
     */
    public function createQuestion($conn, Question $question) {}

    /**
     * calculate quiz score
     *
     * @param Quiz $answeredQuiz
     * @return double
     */
    public function calculateScore(Quiz $answeredQuiz) {}

    /**
     * randomize question
     *
     * @param Question[] $questions
     * @return Question[]
     */
    public function randomizeQuestion($questions) {}

    /**
     * randomize question
     *
     * @param Question[] $questions
     * @return Question[]
     */
    public function getListQuiz($conn) {
        $tempQuizList = $this->QC->getListQuiz($conn);

        $quizObjects = array();
        for($x = 0 ; $x<sizeof($tempQuizList) ; $x++) {
            array_push($quizObjects, new Quiz($tempQuizList[$x]["QuizTitle"], $tempQuizList[$x]["SubjectDesc"], $tempQuizList[$x]["TimeConstraint"], $tempQuizList[$x]["DateCreated"], $tempQuizList[$x]["QuizNo"]));
        }

        return $quizObjects;
    }

    public function getQuestionByQuizId($conn, $quizNo)
    {
        $tempQuestionList = $this->QC->getQuestionByQuizId($conn, $quizNo);
        $questionList = array();
        for($x=0; $x<sizeof($tempQuestionList); $x++){
            array_push($questionList, new Question($tempQuestionList[$x]["QuestionDesc"],"", $tempQuestionList[$x]["QuestionNo"]  ));
        }

        return $questionList;
    }

    public function getAnswerByQuestionId($conn, $questionNo)
    {
        $tempAnswerList = $this->QC->getAnswerByQuestionId($conn, $questionNo);
        $answerList = array();
        for($j=0; $j<sizeof($tempAnswerList); $j++)
        {
            array_push($answerList, new Answer($tempAnswerList[$j]["AnswerNo"], $tempAnswerList[$j]["AnswerDesc"], $tempAnswerList[$j]["TrueAnswer"]));
        }

        return $answerList;
    }
}
?>