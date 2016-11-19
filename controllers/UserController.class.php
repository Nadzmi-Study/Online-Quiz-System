<?php
class UserController {
    /**
     * register new user
     *
     * @param $conn -> Connection variables (passed in the global include file)
     * @param array $userData -> new user array of data
     * @return int|string|null -> return the id of new user
     */
    public function registerUser($conn, $userData) {
        $sql = "CALL SP_User_Insert('" . $userData['FullName'] . "', '" . $userData['IC'] . "', '" . $userData['Email'] . "', '" . $userData['UserType'] . "', '" . $userData['Contact'] . "', '" . $userData['Username'] . "', '" . $userData['Password'] . "', @UserNo)";
        $sql2 = "SELECT @UserNo AS 'UserNo'";

        $conn->query($sql);
        $conn->next_result();
        $query2 = $conn->query($sql2);
        $conn->next_result();

        if(isset($query2))
            $result = $query2->fetch_assoc();
        else
            $result = null;

        return $result;
    }

    /**
     * get array of user informations
     *
     * @param $conn
     * @param int|string $userID
     * @return array|null
     */
    public function getUser($conn, $userID) {
        $sql = "CALL SP_User_GetByID('$userID')";
        $query = $conn->query($sql);
        $conn->next_result();

        if(mysqli_num_rows($query) > 0)
            $result =  mysqli_fetch_assoc($query);
        else
            $result = null;

        return $result;
    }

    /**
     * @param $conn
     * @param array $userData -> array("Username", "Password")
     * @return array|null
     */
    public function getUserID($conn, $userData) {
        $sql = "CALL SP_User_GetByUsernamePassword('" . $userData['Username'] . "', '" . $userData['Password'] . "')";
        $query = $conn->query($sql);
        $conn->next_result();

        if(mysqli_num_rows($query) > 0)
            $result = mysqli_fetch_assoc($query);
        else
            $result =  null;

        return $result;
    }
}
?>