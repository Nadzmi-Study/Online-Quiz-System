<?php
include_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

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
    $registerCredential = array(
        "UserType" => $userType,
        "Name" => $name,
        "IC" => $ic,
        "Contact" => $contact,
        "Email" => $email,
        "Username" => $username,
        "Password" => $password,
        "Re-Password" => $rePassword
    );

    $errorMessage = $userManager->userRegisterCheck($registerCredential);
    if(!$errorMessage["error"]) {
        // create new User object used to register
        $newUser = new User($userType, $name, $ic, $contact, $email, $username, $password);
        $result = $userManager->register($newUser); // register the user

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

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Registration</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="../login">Login</a></li>
                </ul>
            </div>
        </nav>

        <?php $userManager->displayError($errorMessage["message"])?> <!-- display error message if any. -->
        <form action="" method="post">
            <select name="userType">
                <?php displayUserType($userTypeManager); ?> <!-- display the drop-down for user types -->
            </select>
            <input type="text" name="name" placeholder="Full Name" />
            <input type="text" name="ic" placeholder="I/C No.">
            <input type="text" name="contact" placeholder="Contact No.">
            <input type="email" name="email" placeholder="E-Mail" />
            <input type="text" name="username" placeholder="Username" />
            <input type="password" name="password" placeholder="Password" />
            <input type="password" name="re-password" placeholder="Re-Password" />
            <input type="submit" class='btn btn-primary' name="register" placeholder="Register" />
        </form>
    </body>
</html>

<?php
// function declarations:
// displayUserType as drop-down list
function displayUserType($userTypeManager) {
    $tempUserType = $userTypeManager->getUserType(); // get list of user types

    // display the dropdown menu
    echo "<option value='0'>Select user type</option>";
    for($x = 0 ; $x<sizeof($tempUserType) ; $x++) {
        echo "<option value='" . $tempUserType[$x]->getUserTypeNo() . "'>" . $tempUserType[$x]->getUserTypeDesc() . "</option>";
    }
}
?>

