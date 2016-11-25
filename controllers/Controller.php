<?php
class Controller {
    protected $conn; // connection variables

    public function __construct($conn) {
        $this->conn = $conn;
    }
}
?>