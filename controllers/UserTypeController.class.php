<?php
class UserTypeController
{
    public function getUserType($conn){
        $query = "CALL SP_LookupUserType_GetAll()";
        if($row = mysqli_fetch_array($conn,$query))
        {
            $userTypeNo = $row['userTypeNo'];
            $userTypeDesc = $row['userTypeDesc'];

            $userType = new UserType($userTypeNo, $userTypeDesc);
        }
        return $userType;
    }
}