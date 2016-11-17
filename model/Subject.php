<?php

/**
 * Created by PhpStorm.*/
class Subject{
    private $subjectNo;
    private $subjectCode, $subjectDesc;

    public function __construct($subjectNo, $subjectCode, $subjectDesc){
        $this->subjectNo = $subjectNo;
        $this->subjectCode = $subjectCode;
        $this->subjectDesc = $subjectDesc;
    }

    //getter
    public function getSubjectId(){return $this->subjectNo;}
    public function getSubjectCode(){return  $this->subjectCode;}
    public function getSubjectDesc(){return $this->subjectDesc;}

    //setter
    public function setSubjectNo($subjectNo){$this->subjectNo = $subjectNo;}
    public function setSubjectCode($subjectCode){$this->subjectCode = $subjectCode;}
    public function setSubjectDesc($subjectDesc){$this->subjectDesc = $subjectDesc;}
}

?>