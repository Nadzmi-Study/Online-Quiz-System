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
     * @param $conn
     * @return array
     */
    public function getUserType($conn) {
        return $this->UTC->getUserType($conn);
    }
}
