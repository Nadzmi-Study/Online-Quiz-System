<?php
include_once "../../includes/global.inc.php";

$errorMessage = array(
    "error" => false,
    "message" => ""
);

if(isset($_POST["register"])) {
    // get all data from form
    $userType = $_POST["userType"];
    $name = $_POST["name"];
    $ic = $_POST["ic"];
    $contact = $_POST["contact"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $rePassword = $_POST["re-password"];

    // input error check
    // check if there is error
    $errorMessage = $userManager->userRegisterCheck($userType, $name, $ic, $contact, $email, $username, $password, $rePassword);
    if(!$errorMessage["error"]) {
        // create new User object used to register
        $newUser = new User($userType, $name, $ic, $contact, $email, $username, $password);
        $result = $userManager->registerUser($conn, $newUser); // register the user

        if(isset($result))
            header("Location: ../login"); // successfully registered
        else
            header("Location: ../register"); // unsuccessfully registered
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
    <?php $userManager->displayError($errorMessage["message"])?> <!-- display error message if any. -->
        <form action="" method="post">
            <select name="userType">
                <?php displayUserType($conn, $userTypeManager); ?> <!-- display the drop-down for user types -->
            </select>
            <input type="text" name="name" placeholder="Full Name" />
            <input type="text" name="ic" placeholder="I/C No.">
            <input type="text" name="contact" placeholder="Contact No.">
            <input type="email" name="email" placeholder="E-Mail" />
            <input type="text" name="username" placeholder="Username" />
            <input type="password" name="password" placeholder="Password" />
            <input type="password" name="re-password" placeholder="Re-Password" />
            <input type="submit" name="register" placeholder="Register" />
        </form>
        <a href="../login">Login</a>
    </body>
</html>

<?php
// funstion declarations:
// displayUserType as drop-down list
function displayUserType($conn, $userTypeManager) { // display drop-down menu for user type
    $tempUserType = $userTypeManager->getUserType($conn); // get list of user types

    // display the dropdown menu
    echo "<option value='0'>Select user type</option>";
    for($x = 0 ; $x<sizeof($tempUserType) ; $x++) {
        echo "<option value='" . $tempUserType[$x]->getUserTypeNo() . "'>" . $tempUserType[$x]->getUserTypeDesc() . "</option>";
    }
}
?>

