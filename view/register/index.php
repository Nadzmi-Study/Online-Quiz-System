<?php
include_once "../../includes/global.inc.php";


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

    // check if password matched
    if(($password == $rePassword) || ($userType == 0)) {
        // create new User object used to register
        $newUser = new User($userType, $name, $ic, $contact, $email, $username, $password);
        $result = $userManager->registerUser($conn, $newUser); // register the user

        if(isset($result))
            header("Location: ../login"); // successfully registered
        else
            header("Location: ../register"); // unsuccessfully registered
    } else
        header("Location: ../register"); // password do not matched
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
    </head>
    <body>
        <form action="" method="post">
            <select name="userType">
                <option value='0'>Select user type</option>
                <option value='1'>Student</option>
                <option value='2'>Lecturer</option>
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
// sample function to display drop-down menu
function displayUserType($conn, $userTypeManager) {
    // get object of userTypes from UserTypeManager
    $userTypes[] = array();

    // display the dropdown menu
    echo "<option value='0'>Select user type</option>";
    foreach($userTypes as $type) {
        echo "<option value='" . $type->getUserTypeNo() . "'>" . $type->getUserTypeDesc() . "</option>";
    }
}
?>

