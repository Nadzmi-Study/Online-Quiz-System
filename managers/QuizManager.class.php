<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:40 PM
 */

require_once "Manager.class.php";

class QuizManager extends Manager {
    private $QC; // quiz controller

    public function __construct(QuizController $QC) {
        $this->QC = $QC;
    }

    /**
     * @param string $quizID
     * @return Question[]
     */
    public function getQuestionList($quizID) {}

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
    public function createQuiz(Quiz $quiz) {}

    /**
     * create new question
     *
     * @param Question $question
     */
    public function createQuestion(Question $question) {}

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
}
?>