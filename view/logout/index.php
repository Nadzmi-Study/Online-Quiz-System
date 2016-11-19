<?php
require_once "../../includes/global.inc.php";

$userManager->logout();

header("Location: ../login");
?>