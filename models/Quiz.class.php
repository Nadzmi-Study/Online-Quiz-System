<?php
include_once "Question.class.php";

class Quiz {
    private $no; // int
    private $title, $subject; // string;
    private $questions; // Question[]
    private $dateCreated, $dateModified; // Date

    /**
     * Quiz constructor.
     *
     * @param string $title
     * @param string $subject
     * @param Date $dateCreated
     * @param int $no
     * @param Question[] $questions
     */
    public function __construct($title="", $subject=null, $dateCreated=null, $no=0, $questions=array()) {
        $this->title = $title;
        $this->subject = $subject;
        $this->dateCreated = $dateCreated;
        $this->no = $no;
        $this->questions = $questions;
    }

    // getter
    public function getNo() { return $this->no; }
    public function getTitle() { return $this->title; }
    public function getSubject() { return $this->subject; }
    public function getQuestion() { return $this->questions; }
    public function getDateCreated() { return $this->dateCreated; }
    public function getDateModified() { return $this->dateModified; }

    // setter
    public function setNo(int $no) { $this->no = $no; }
    public function setTitle($title) { $this->title = $title; }
    public function setSubject($subject) { $this->subject = $subject; }
    public function setQuestion($question) { $this->questions = $question; }
    public function setDateCreated($dateCreated) { $this->dateCreated = $dateCreated; }
    public function setDateModified($dateModified) { $this->dateModified = $dateModified; }
}
?>