<?php
require_once "Manager.class.php";

class UserTyperManager extends Manager{
    private $UTC;

    /**
     * UserTyperManager constructor.
     *
     * @param UserTypeController|null $UTC
     */
    public function __construct(UserTypeController $UTC=null) {
        $this->UTC = $UTC;
    }

    /**
     * get user type object
     *
     * @return array
     */
    public function getUserType() {
        $tempUserType = $this->UTC->getUserType();

        $userTypeObjects = array();
        for($x = 0 ; $x<sizeof($tempUserType) ; $x++) {
            array_push($userTypeObjects, new UserType($tempUserType[$x]["UserTypeNo"], $tempUserType[$x]["UserTypeDesc"]));
        }

        return $userTypeObjects;
    }
}
