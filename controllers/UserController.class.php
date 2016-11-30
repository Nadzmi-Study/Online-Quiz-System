<?php
require_once "Controller.php";


class UserController extends Controller {
    public function __construct($conn) {
        parent::__construct($conn);
    }

    /**
     * register new user
     *
     * @param array $userData -> new user array of data
     * @return int|string|null -> return the id of new user
     */
    public function registerUser($userData) {
        $sql = "CALL SP_User_Insert('" . $userData['FullName'] . "', '" . $userData['IC'] . "', '" . $userData['Email'] . "', '" . $userData['UserType'] . "', '" . $userData['Contact'] . "', '" . $userData['Username'] . "', '" . $userData['Password'] . "', @UserNo)";
        $sql2 = "SELECT @UserNo AS 'UserNo'";

        $this->conn->query($sql);
        $this->conn->next_result();
        $query = $this->conn->query($sql2) or die($this->conn->error);
        $this->conn->next_result();

        if(isset($query))
            $result = $query->fetch_assoc() or die($this->conn->error);
        else
            $result = null;

        return $result;
    }

    /**
     * get user id
     *
     * @param array $userData -> array("Username", "Password")
     * @return array|null
     */
    public function getUserID($userData) {
        $sql = "CALL SP_User_GetByUsernamePassword('" . $userData['Username'] . "', '" . $userData['Password'] . "')";
        $query = $this->conn->query($sql) or die($this->conn->error);
        $this->conn->next_result();

        if($query->num_rows > 0)
            $result = $query->fetch_assoc() or die($this->conn->error);
        else
            $result =  null;

        return $result;
    }

    /**
     * get array of user informations
     *
     * @param int|string $userID
     * @return array|null
     */
    public function getUser($userID) {
        $sql = "CALL SP_User_GetByID('$userID')";
        $query = $this->conn->query($sql) or die($this->conn->error);
        $this->conn->next_result();

        if($query->num_rows > 0)
            $result =  $query->fetch_assoc() or die($this->conn->error);
        else
            $result = null;

        return $result;
    }
}
?>