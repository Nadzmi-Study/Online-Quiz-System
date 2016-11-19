<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:39 PM
 */

include_once "Manager.class.php";

class UserManager extends Manager {
    /**
     * login
     *
     * @param mysqli_connect() $conn
     * @param string $username
     * @param string $password
     */
    public function login($conn, $username, $password) {
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
     * @param User $user
     * @return boolean
     */

    public function registerUser($conn,User $user) {
        $userCtrl = new UserController();
        $userCtrl.$this->registerUser($conn, $user);
    }
}
?>