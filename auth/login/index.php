<?php
    
    require '../../index.php';
    // print_r($_POST);return;
    // Ensure username and password are in the request parameters
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $user = R::findOne('user', 'username = ? && password = ?', [$username, $password]);
        if ($user) {
            // secure user response
            unset($user['password']);
            Utils::printResponse(200, $user);
            return;
        }
        Utils::printResponse(200, 'Username ou mot de passe est incorrect!');
        return;
    }
    Utils::printResponse(400, 'Invalid username or password!');
    
?>