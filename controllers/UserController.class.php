<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:08 AM
 */

class UserController {
    /**
     * get array of user informations
     *
     * @param $conn
     * @param int|string $userID
     * @return array|null
     */
    public function getUser($conn, $userID) {
        $sql = "CALL SP_User_GetByID('$userID')";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if(mysqli_num_rows($result) > 0)
            return mysqli_fetch_assoc($result);
        else
            return null;
    }

    /**
     * @param $conn
     * @param array $userData -> array("Username", "Password")
     * @return array|null
     */
    public function getUserID($conn, $userData) {
        $sql = "SELECT UserNo FROM user WHERE Username LIKE '" . $userData['Username'] . "' AND Password LIKE '" . $userData['Password'] . "'";
        $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

        if(mysqli_num_rows($result) > 0)
            return mysqli_fetch_assoc($result);
        else
            return null;
    }

    /**
     * register new user
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param User $newUser -> new user object models
     * @return int|string -> return the id of new user
     */
    public function registerUser($conn, User $newUser) {}
}
?>