<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 19/11/2016
 * Time: 3:00 PM
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Title</title>
</head>
<body>
    <div class="container-fluid">
        <label>UserType</label>
        <select name="userType">
            <?php
             $conn = mysqli_connect("localhost","root","","online_quiz_system");
             if(mysqli_connect_errno())
             {
                 echo "Failed to connect";
             }
             $query = "CALL SP_LookupUserType_GetAll;";
             $results = mysqli_query($conn,$query );

            foreach ($results as $type) {
                ?>
                <option value="<?php echo $type["userTypeNo"];?>"><?php echo $type["userTypeDesc"]?></option>
            <?php
              }
            ?>
        </select>
    </div>
</body>
</html>

