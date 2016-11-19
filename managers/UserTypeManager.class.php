<?php
require_once "Manager.class.php";

class UserTyperManager extends Manager{
    private $UTC;

    public function __construct(UserTypeController $UTC) {
        $this->UTC = $UTC;
    }

    public function getUserType($conn){
        return $this->UTC->getUserType($conn);
    }
}