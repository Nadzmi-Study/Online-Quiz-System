<?php
class UserTypeController
{
    public function getUserType($conn) // return the user types as associative array
    {
        $sql = "CALL SP_LookupUserType_GetAll()"; // prepare the sql query
        $query = $conn->query($sql) or die(mysqli_error($conn)); // run the sql query

        $userTypes = array();
        while($row = $query->fetch_assoc()) {
            $result = array(
                "UserTypeNo" => $row["userTypeNo"],
                "UserTypeDesc" => $row["userTypeDesc"]
            );

            array_push($userTypes, $result);
        }

        $conn->next_result();
        return $userTypes; // return array of user types
    }
}
?>

