<?php

    require '../index.php';
    
    
    if (isset($_POST["limit"]) && isset($_POST["offset"])) {
        $limit = $_POST["limit"];
        $offset = $_POST["offset"];
        $userId = $_POST["user_id"];
        $role = $_POST["role"];
        $sql = '';
        if ($role == 'admin') {
            $sql = 'SELECT l.*, c.photo as photo, c.pickup_position, u.first_name, u.last_name FROM rent l inner join car c on c.id = l.car_id inner join user u on u.id = l.user_id ';// LIMIT ?, ?
        } else {
            $sql = 'SELECT l.*, c.photo as photo, c.pickup_position, u.first_name, u.last_name FROM rent l inner join car c on c.id = l.car_id inner join user u on u.id = l.user_id WHERE l.user_id = ' . $userId ; //  LIMIT ?, ?
        }
        $rents = R::getAll($sql, [$offset, $limit]);
        if ($rents) {
            Utils::printResponse(200, $rents);
            return;
        }
    }
    Utils::printResponse(200, '');
    
?>