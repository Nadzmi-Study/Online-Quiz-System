<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

include_once "Controller.class.php";

class UserController extends Controller {
    /**
     * register new user
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param User $newUser -> new user object model
     * @return int|string -> return the id of new user
     */
    public function registerUser($conn, User $newUser) {
        $date = date("Y-m-d");

        // insert into userdetails first
        $userDetailAttr = "FullName, IC, Email, UserTypeNo, ContactNo, DateCreated";
        $userDetailValues = "'" . $newUser->getName() ."', '" . $newUser->getIC() ."', '" . $newUser->getEmail() ."', '" . $newUser->getUserType() ."', '" . $newUser->getContact() ."', '$date'";
        $userDetailNo = $this->insert($conn, "userdetails", $userDetailAttr, $userDetailValues);

        // insert into user
        $userAttr = "Username, Password, UserDetailNo, DateCreated";
        $userValues = "'" . $newUser->getUsername() ."', '" . $newUser->getPassword() ."', '$userDetailNo', '$date'";
        $userNo = $this->insert($conn, "user", $userAttr, $userValues);

        return $userNo;
    }
}
?>