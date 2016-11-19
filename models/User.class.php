<?php
class User {
    private $userNo; // int
    private $userType; // string
    private $name, $ic, $contact, $email; // string
    private $username, $password; // string

    /**
     * User constructor.
     *
     * @param string $userType
     * @param string $name
     * @param string $ic
     * @param string $contact
     * @param string $email
     * @param string $username
     * @param string $password
     * @param int $userNo
     */
    public function __construct($userType="", $name="", $ic="", $contact="", $email="", $username="", $password="", $userNo=0) {
        $this->userType = $userType;
        $this->name = $name;
        $this->ic = $ic;
        $this->contact = $contact;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->userNo = $userNo;
    }

    // getter
    public function getUserType() { return $this->userType; }
    public function getName() { return $this->name; }
    public function getIC() { return $this->ic; }
    public function getContact() { return $this->contact; }
    public function getEmail() { return $this->email; }
    public function getUsername() { return $this->username; }
    public function getPassword() { return $this->password; }
    public function getUserNo() { return $this->userNo; }

    // setter
    public function setUserType($userType) { $this->userType = $userType; }
    public function setName($name) { $this->name = $name; }
    public function setIc($ic) { $this->ic = $ic; }
    public function setContact($contact) { $this->contact = $contact; }
    public function setEmail($email) { $this->email = $email; }
    public function setUsername($username) { $this->username = $username; }
    public function setPassword($password) { $this->password = $password; }
    public function setUserNo($userNo) { $this->userNo = $userNo;}
}
?>