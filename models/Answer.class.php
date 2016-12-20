<?php
class Answer {
    private $no; // int
    private $description; // string
    private $trueAnswer; // boolean

    /**
     * Answer constructor.
     *
     * @param int $no
     * @param string $description
     * @param boolean $trueAnswer
     */
    public function __construct($no=0, $description="", $trueAnswer=false) {
        $this->no = $no;
        $this->description = $description;
        $this->trueAnswer = $trueAnswer;
    }

    // getter
    public function getNo() { return $this->no; }
    public function getDescription() { return $this->description; }
    public function getTrueAnswer() { return $this->trueAnswer; }

    // setter
    public function setNo($no) { $this->no = $no; }
    public function setDescription($description) { $this->description = $description; }
    public function setTrueAnswer($trueAnswer) { $this->trueAnswer = $trueAnswer; }
}
?>