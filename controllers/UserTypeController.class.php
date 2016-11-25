<?php
require_once "Controller.php";

class UserTypeController extends Controller
{
    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    public function getUserType() // return the user types as associative array
    {
        $sql = "CALL SP_LookupUserType_GetAll()"; // prepare the sql query
        $query = $this->conn->query($sql) or die($this->conn->error); // run the sql query

        $userTypes = array();
        while($row = $query->fetch_assoc()) {
            $result = array(
                "UserTypeNo" => $row["userTypeNo"],
                "UserTypeDesc" => $row["userTypeDesc"]
            );

            array_push($userTypes, $result);
        }

        $this->conn->next_result();
        return $userTypes; // return array of user types
    }
}
?>

