<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:39 PM
 */

require_once "Manager.class.php";

/**
 * Class UserManager
 *
 * @todo implement other UserManager's methods
 */
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
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($username, $password) {
        $loginData = array(
            "Username" => $username,
            "Password" => $password
        );

        $userNo = $this->getUserID($loginData);

        if(isset($userNo)) {
            $_SESSION["logged_in"] = true;
            $_SESSION["user"] = serialize($this->getUser($userNo));

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

        if(isset($_SESSION["logged_in"]))
            session_destroy();
    }

    /**
     * register new user
     *
     * @param User $user
     * @return array
     */
    public function registerUser(User $user) {
        $newUserData = array(
            "FullName" => $user->getName(),
            "IC" => $user->getIC(),
            "Email" => $user->getEmail(),
            "UserType" => $user->getUserType(),
            "Contact" => $user->getContact(),
            "Username" => $user->getUsername(),
            "Password" => $user->getPassword()
        );

        $result = $this->UC->registerUser($newUserData);

        if(isset($result))
            return $result;
        else
            return null;
    }

    /**
     * get user object by id
     *
     * @param int|string $userID
     * @return null|User
     */
    public function getUser($userID) {
        $userData = $this->UC->getUser($userID);

        if(isset($userData))
            return new User($userData["UserType"], $userData["FullName"], $userData["IC"], $userData["Contact"], $userData["Email"], $userData["Username"], $userData["Password"], $userData["UserNo"]);
        else
            return null;
    }

    /**
     * get user id
     *
     * @param array $loginData -> ("Username", "Password")
     * @return int
     */
    public function getUserID($loginData) {
        $result = $this->UC->getUserID($loginData);

        if(isset($result))
            return $result["UserNo"];
        else
            return null;
    }

    // Check methods ---------------------------------------------------------------------------------------------------

    /**
     * check user registration
     *
     * @param int $userType
     * @param string $name
     * @param string $ic
     * @param string $contact
     * @param string $email
     * @param string $username
     * @param string $password
     * @param string $rePassword
     * @return array
     */
    public function userRegisterCheck($userType=0, $name="", $ic="", $contact="", $email="", $username="", $password="", $rePassword="") {
        $error = false;
        $errorMessage = "Please do the following before registration:<br />";

        if(empty($name) || empty($ic) || empty($contact) || empty($email) || empty($username) || empty($password) || empty($rePassword)) {
            $errorMessage .= "-> Complete the form.<br />";
            $error = true;
        }

        if(($password != $rePassword)) {
            $errorMessage .= "-> Password not matched.<br />";
            $error = true;
        }

        if($userType == 0) {
            $errorMessage .= "-> Select your 'User Type'.<br />";
            $error = true;
        }

        if(!$error)
            $errorMessage .= "";

        $result = array(
            "error" => $error,
            "message" => $errorMessage
        );

        return $result;
    }

    /**
     * check user login credentials
     *
     * @param string $username
     * @param string $password
     * @return array
     */
    public function userLoginCheck($username="", $password="") {
        $userData = array(
            "Username" => $username,
            "Password" => $password
        );
        $userID = $this->UC->getUserID($userData);

        if(!isset($userID)) {
            $error = true;
            $errorMessage = "Username or Password do not match.";
        } else {
            $error = false;
            $errorMessage = "";
        }

        $result = array(
            "error" => $error,
            "message" => $errorMessage
        );

        return $result;
    }
}
?>

