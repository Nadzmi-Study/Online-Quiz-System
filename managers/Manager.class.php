<?php
class Manager {
    /**
     * @param string $message
     */
    public function displayError($message) {
        echo "<div id='error-message'>$message</div>";
    }

    /**
     * @param string $message
     */
    public function displaySuccess($message) {
        echo "<div id='success-message'>$message</div>";
    }

    /**
     * @param string $message
     */
    public function display($message) {
        echo $message;
    }
}
?>