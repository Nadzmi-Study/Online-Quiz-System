<?php
/**
 * Class UserManager
 *
 * @todo implement other UserManager's methods
 */
class UserManager {
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
     * register new user
     *
     * @param User $user
     * @return array
     */
    public function register(User $user) {
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

    // Check methods ---------------------------------------------------------------------------------------------------
    /**
     * check user registration
     *
     * @param assoc array $registerCredential
     * @return array
     */
    public function userRegisterCheck($registerCredential) {
        $error = false;
        $errorMessage = "Please do the following before registration:<br />";

        if(empty($registerCredential["Name"]) || empty($registerCredential["IC"]) || empty($registerCredential["Contact"]) || empty($registerCredential["Email"]) || empty($registerCredential["Username"]) || empty($registerCredential["Password"]) || empty($registerCredential["Re-Password"])) {
            $errorMessage .= "-> Complete the form.<br />";
            $error = true;
        }

        if(($registerCredential["Password"] != $registerCredential["Re-Password"])) {
            $errorMessage .= "-> Password not matched.<br />";
            $error = true;
        }

        if($registerCredential["UserType"] == 0) {
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
     * @param assoc array $loginCredential
     * @return array (error, message)
     */
    public function userLoginCheck($loginCredential) {
        $userID = $this->UC->getUserID($loginCredential);

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

