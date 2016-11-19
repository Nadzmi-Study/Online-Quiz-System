<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:39 PM
 */

require_once "Manager.class.php";

class UserManager extends Manager {
    private $UC; // user controller

    /**
     * UserManager constructor.
     *
     * @param UserController|null $UC
     */
    public function __construct(UserController $UC=null) {
        $this->UC = $UC;
    }

    /**
     * login
     *
     * @param $conn
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($conn, $username, $password) {
        $loginData = array(
            "Username" => $username,
            "Password" => $password
        );

        $userNo = $this->getUserID($conn, $loginData);

        if(isset($userNo)) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user"] = serialize($this->getUser($conn, $userNo));

            return true;
        } else {
            $this->logout();

            return false;
        }
    }

    /**
     * logout
     */
    public function logout() {
        unset($_SESSION["logged_in"]);
        unset($_SESSION["user"]);
    }

    /**
     * register new user
     *
     * @param $conn
     * @param User $user
     * @return array
     */
    public function registerUser($conn, User $user) {
        $newUserData = array(
            "FullName" => $user->getName(),
            "IC" => $user->getIC(),
            "Email" => $user->getEmail(),
            "UserType" => $user->getUserType(),
            "Contact" => $user->getContact(),
            "Username" => $user->getUsername(),
            "Password" => $user->getPassword()
        );

        $result = $this->UC->registerUser($conn, $newUserData);

        if(isset($result))
            return $result;
        else
            return null;
    }

    /**
     * get user object by id
     *
     * @param $conn
     * @param int|string $userID
     * @return null|User
     */
    public function getUser($conn, $userID) {
        $userData = $this->UC->getUser($conn, $userID);

        if(isset($userData))
            return new User($userData["UserType"], $userData["FullName"], $userData["IC"], $userData["Contact"], $userData["Email"], $userData["Username"], $userData["Password"], $userData["UserNo"]);
        else
            return null;
    }

    /**
     * get user id
     *
     * @param $conn
     * @param array $loginData -> ("Username", "Password")
     * @return int
     */
    public function getUserID($conn, $loginData) {
        $result = $this->UC->getUserID($conn, $loginData);

        if(isset($result))
            return $result["UserNo"];
    }
}
?>

