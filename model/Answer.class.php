<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 3:28 PM
 */

class Answer {
    private $no; // int
    private $description; // string
    private $trueAnswer, $studentAnswer; // boolean

    /**
     * Answer constructor.
     *
     * @param int $no
     * @param string $description
     * @param boolean $trueAnswer
     * @param boolean $studentAnswer
     */
    public function __construct($no, $description, $trueAnswer, $studentAnswer) {
        $this->no = $no;
        $this->description = $description;
        $this->trueAnswer = $trueAnswer;
        $this->studentAnswer = $studentAnswer;
    }

    // getter
    public function getNo() { return $this->no; }
    public function getDescription() { return $this->description; }
    public function getTrueAnswer() { return $this->trueAnswer; }
    public function getStudentAnswer() { return $this->studentAnswer; }

    // setter
    public function setNo($no) { $this->no = $no; }
    public function setDescription($description) { $this->description = $description; }
    public function setTrueAnswer($trueAnswer) { $this->trueAnswer = $trueAnswer; }
    public function setStudentAnswer($studentAnswer) { $this->studentAnswer = $studentAnswer; }
}
?>