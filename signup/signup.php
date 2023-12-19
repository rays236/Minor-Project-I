<?php
require_once 'logintoDB.php';

try {
    $pdo = new PDO($attr, $user, $pass, $opts);
}
catch (PDOException $e){
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);



$firstname = $Surname = $Username = $password = $age = $email = "";

if (isset($_POST['firstname']))
    $firstname = fix_string($_POST['firstname']);
if (isset($_POST['Surname']))
    $Surname = fix_string($_POST['Surname']);
if (isset($_POST['Username']))
    $Username = fix_string($_POST['Username']);
if (isset($_POST['password']))
    $password = fix_string($_POST['password']);
if (isset($_POST['email']))
    $email =$_POST['email'];


$fail = validate_firstname($firstname);
$fail .= validate_surname($Surname);
$fail .= validate_username($Username);
$fail .= validate_password($password);

if ($fail == "") {
    echo "<body> Form data successfully validated: $firstname, $Surname, $Username, $password, $email </body></html>";
    $ismt = $pdo-> prepare ('INSERT INTO users VALUES(?,?,?,?,?)');
    $ismt -> bindParam(1, $firstname, PDO::PARAM_STR, 32);
    $ismt -> bindParam(2, $Surname, PDO::PARAM_STR, 32);
    $ismt -> bindParam(3, $Username,PDO::PARAM_STR, 16);
    $ismt -> bindParam(4, $password, PDO::PARAM_STR, 12);
    $ismt -> bindParam(5, $email, PDO::PARAM_STR, 64);

    $ismt -> execute([$firstname, $Surname, $Username, $password, $email]);

    $pdo = NULL;
    echo<<<_END
    <script>
        document.location.href = 'login.html'
    </script>
    _END;
    exit;
}
else   
    echo "Error due to: $fail";

function validate_firstname($field){
    return ($field=='')?"No firstname was entered<br>":"";
}

function validate_surname($field){
    return($field == '')?"No surname was entered<br>":"";
}

function validate_username($field){
    if ($field == "") 
        return "No Username was entered<br>";
    else if (strlen($field)< 5) 
        return " Username must be atleast 5 characters";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "Only letters, numbers, - and _ in usernames<br>";
    return "";
}

function validate_password($field){
    if($field == "")
        return "No password was entered<br>";
    else if (strlen($field)<6)
        return "Password must be at least 6 characters<br>";
    else if (!preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
        return "Password require 1 each of a-z, A-Z and 0-9 <br>";
    else if (strlen($field) >12)
        return "Password must be less than 12 characters<br>";
    return "";
}

function fix_string($string){
    $string = stripslashes($string);
    return htmlentities($string);
}
