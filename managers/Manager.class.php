<?php
class Manager {
    /**
     * @param string $message
     */
    public function displayError($message) {
        echo "<b>$message</b>";
    }

    /**
     * @param string $message
     */
    public function displaySuccess($message) {
        echo "<i>$message</i>";
    }

    /**
     * @param string $message
     */
    public function display($message) {
        echo $message;
    }
}
?>

