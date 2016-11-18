<?php

/**
 * Created by PhpStorm.*/
class Subject{
    private $subjectNo; // int
    private $subjectCode, $subjectDesc; // string

    /**
     * Subject constructor.
     *
     * @param int $subjectNo
     * @param string $subjectCode
     * @param string $subjectDesc
     */
    public function __construct($subjectCode, $subjectDesc, $subjectNo){
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