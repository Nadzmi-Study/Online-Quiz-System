<?php

/**
 * Created by PhpStorm.*/
class Subject{
    private $subjectId;
    private $subjectCode, $subjectDesc;

    public function __construct($subjectId, $subjectCode, $subjectDesc){
        $this->subjectId = $subjectId;
        $this->subjectCode = $subjectCode;
        $this->subjectDesc = $subjectDesc;
    }

    //getter
    public function getSubjectId(){return $this->subjectId;}
    public function getSubjectCode(){return  $this->subjectCode;}
    public function getSubjectDesc(){return $this->subjectDesc;}

    //setter
    public function setSubjectId($subjectId){$this->subjectId = $subjectId;}
    public function setSubjectCode($subjectCode){$this->subjectCode = $subjectCode;}
    public function setSubjectDesc($subjectDesc){$this->subjectDesc = $subjectDesc;}
}

?>