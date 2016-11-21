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
     * @method
     * get user type object
     *
     * @todo get array of usertypes from UserController and return as array of objects
     *
     * @param $conn
     * @return array
     */
    public function getUserType($conn) {
        $tempUserType = $this->UTC->getUserType($conn);

        $userTypeObjects = array();
        for($x = 0 ; $x<sizeof($tempUserType) ; $x++) {
            array_push($userTypeObjects, new UserType($tempUserType[$x]["UserTypeNo"], $tempUserType[$x]["UserTypeDesc"]));
        }

        return $userTypeObjects;
    }
}
