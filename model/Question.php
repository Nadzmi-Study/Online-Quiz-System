<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 3:28 PM
 */

include_once "Answer.php";

class Question {
    private $no; // int
    private $description; // string
    private $answers; // Answer[]

    /**
     * Question constructor.
     *
     * @param string $description
     * @param Answer[] $answers
     * @param int $no
     */
    public function __construct($description, $answers, $no) {
        $this->description = $description;
        $this->answers = $answers;
        $this->no = $no;
    }

    // getter
    public function getNo() { return $this->no; }
    public function getDescription() { return $this->description; }
    public function getAnswer() { return $this->answer; }

    // setter
    public function setNo($no) { $this->no = $no; }
    public function setDescription($description) { $this->description = $description; }
    public function setAnswer($answer) { $this->answer = $answer; }
}
?>