<?php
class UserController {
    public function getUser($conn, $userID) {
        $userResult = $this->select($conn, "user", "*", "UserNo LIKE '$userID'", true);
        $userDetailResult = $this->select($conn, "userdetails", "*", "UserDetailNo LIKE '" . $userResult["UserDetailNo"] . "'", true);

        return new User($userDetailResult["UserTypeNo"], $userDetailResult["FullName"], $userDetailResult["IC"], $userDetailResult["ContactNo"], $userDetailResult["Email"], $userResult["Username"], $userResult["Password"]);
    }

    /**
     * register new user
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param User $newUser -> new user object models
     * @return int|string -> return the id of new user
     */
    public function registerUser($conn, User $newUser) {
    }
}
?>