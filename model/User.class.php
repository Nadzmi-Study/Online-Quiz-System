<?php
/**
 * Created using PhpStorm.
 * Project: OnlineQuizSystem
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 12:07 AM
 */

class User {
    private $userType;
    private $name, $ic, $contact, $email;
    private $username, $password;

    public function __construct($userType, $name, $ic, $contact, $email, $username, $password) {
        $this->userType = $userType;
        $this->name = $name;
        $this->ic = $ic;
        $this->contact = $contact;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
    }

    // getter
    public function getUserType() { return $this->userType; }
    public function getName() { return $this->name; }
    public function getIC() { return $this->ic; }
    public function getContact() { return $this->contact; }
    public function getEmail() { return $this->email; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }

    // setter
    public function setUserType($userType) { $this->userType = $userType; }
    public function setName($name) { $this->name = $name; }
    public function setIc($ic) { $this->ic = $ic; }
    public function setContact($contact) { $this->contact = $contact; }
    public function setEmail($email) { $this->email = $email; }
    public function setUsername($username) { $this->username = $username; }
    public function setPassword($password) { $this->password = $password; }
}
?>