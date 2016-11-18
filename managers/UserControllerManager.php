<?php

/**
 * Created by PhpStorm.
 * User: USER
 * Date: 18/11/2016
 * Time: 3:21 PM
 */
class UserControllerManager extends Manager{
    public function getUserType($conn){
        $UTC = new UserTypeController();
        $UTC.$this->getUserType($conn);
    }
}