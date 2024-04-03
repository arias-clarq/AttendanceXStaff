<?php
session_start();
//user login
function user_login($login_user, $login_pass, $user, $pass)
{
    if ($user == $login_user && $pass == $login_pass) {
        return true;
    } else {
        return false;
    }
}

$API_URL = 'https://cyber-techo.000webhostapp.com/config/api.php';

$username = $_POST["username"];
$password = $_POST["password"];
$role_check = array('Admin', 'Employee');

$json = file_get_contents($API_URL);
$data = json_decode($json, true);

$user_login = false;
$user_role = '';

foreach ($data as $data) {
    $employee = $data['employee'];
    $user_login = user_login($username, $password, $employee['username'], $employee['password']);
    if ($user_login == true) {
        $user_role = $employee['login_role'];
        break;
    }
}

if ($user_login == true) {
    $_SESSION['user_role'] = $user_role;
    $_SESSION['login'] = true;
    echo json_encode(['success' => true, 'role' => $user_role]);
} else {
    $_SESSION['message'] = 'Incorrect Username or Password';
    echo json_encode(['success' => false]);
}
?>