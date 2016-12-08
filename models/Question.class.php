<?php
include_once "Answer.class.php";

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
    public function __construct($description="", $answers=array(), $no=0) {
        $this->description = $description;
        $this->answers = $answers;
        $this->no = $no;
    }

    // getter
    public function getNo() { return $this->no; }
    public function getDescription() { return $this->description; }
    public function getAnswer() { return $this->answers; }

    // setter
    public function setNo($no) { $this->no = $no; }
    public function setDescription($description) { $this->description = $description; }
    public function setAnswer($answer) { $this->answers = $answer; }
}
?>