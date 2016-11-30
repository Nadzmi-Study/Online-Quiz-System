<?php
class Manager {
    /**
     * display a message
     *
     * @param string $message
     */
    public function display($message) {
        echo $message;
    }

    /**
     * display success message
     *
     * @param string $message
     */
    public function displaySuccess($message) { $this->display("<div class='success-message'><b>$message</b></div>"); }

    /**
     * display error message
     *
     * @param string $message
     */
    public function displayError($message) { $this->display("<div class='error-message'><b>$message</b></div>"); }
}
?>

