<?php
/**
 * Created using PhpStorm.
 * Project: Online-Quiz-System
 * Author: seladanghijau
 * Date: 8/11/2016
 * Time: 2:41 PM
 */

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