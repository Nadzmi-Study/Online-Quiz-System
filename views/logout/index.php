<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/Online-Quiz-System/views/includes/global.inc.php";

$userManager->logout();

header("Location: ../login");
?>

<html>
    <head>
        <title>Logged Out</title>
    </head>

    <body>
    
    </body>
</html>
