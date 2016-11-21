<?php
class UserType
{
    private $userTypeNo;
    private $userTypeDesc;

    public function __construct($userTypeNo=0, $userTypeDesc=""){
        $this->userTypeNo = $userTypeNo;
        $this->userTypeDesc = $userTypeDesc;
    }

    //getter
    public function getUserTypeNo(){ return $this->userTypeNo;}
    public function getUserTypeDesc(){ return $this->userTypeDesc; }

    //setter
    public function setUserTypeNo($userTypeNo){ $this->userTypeNo = $userTypeNo; }
    public function setUserTypeDesc($userTypeDesc){ $this->userTypeDesc = $userTypeDesc; }
}

?>