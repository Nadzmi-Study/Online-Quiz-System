<?php
require_once "Controller.php";

/**
 * Class QuizController
 *
 * @todo implement other QuizController's methods
 */
class QuizController extends Controller {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    /**
     * @todo inplement registerQuiz() and return the quizID
     *
     * @param Quiz $quiz
     */
    public function registerQuiz(Quiz $quiz) {}

    /**
     * @todo implement registerQuestion() and return questionID
     *
     * @param Question $question
     */
    public function registerQuestion(Question $question) {}

    /**
     * @todo implement requestQuestionList() and return array of Question object
     *
     * @param $quizID
     */
    public function requestQuestionList($quizID) {}
}
?>