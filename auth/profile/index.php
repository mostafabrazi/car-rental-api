<?php
    
    require '../../index.php';

    if (isset($_POST["id"])) {

        $user = null;
        if (isset($_POST['username']) && $_POST['username']) {
            $user = R::getRow('SELECT * from user where username = ?', [$_POST['username']]);
            if ($user && isset($user['id'])) {
                Utils::printResponse(200, 'Ce username est indisponible !');
                return;
            }
        }

        // Load user
        $user = R::load('user', $_POST["id"]);

        // Update fields if needed
        if (isset($_POST['username']) && $_POST['username']) {
            $user->username = $_POST["username"];
        }
        if (isset($_POST['first_name']) && $_POST['first_name']) {
            $user->first_name = $_POST["first_name"];
        }
        if (isset($_POST['last_name']) && $_POST['last_name']) {
            $user->last_name = $_POST["last_name"];
        }
        
        // Save changes
        $id = R::store($user);

        if ($id) {
            Utils::printResponse(200, 'Profil modifié avec success !');
            return;
        }

        Utils::printResponse(200, 'Erreur unconu');
        return;
    }
    Utils::printResponse(400, 'Invalid username or password!');
    
?>