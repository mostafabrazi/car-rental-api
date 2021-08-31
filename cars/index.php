<?php

    require '../index.php';
    // SETTING SQL_MODE TO AVOID GROUP_BY ISSUES 
    // ONLY IN THIS SIMULATION HOSTING SERVER
    R::exec("SET sql_mode=''");
    
    if (isset($_POST["limit"]) && isset($_POST["offset"])) {
        $limit = $_POST["limit"];
        $offset = $_POST["offset"];
        
        // MAIN query
        $params = array();
        $sql  = "SELECT 
                    c.*, 
                    (SELECT COUNT(id) FROM rent where status != 'renting' AND user_id = " . $_POST['user_id']. " and car_id = c.id) as irentit, 
                    (SELECT COUNT(id) FROM rent where status != 'renting' AND car_id = c.id) as rentsCount 
                FROM car c ";
        
        // Handle filters
        if (isset($_POST['brand']) && $_POST['brand']) {
            $sql .= 'AND brand = ? ';
            $params[] = $_POST["brand"];
        }
        if (isset($_POST['model']) && $_POST['model']) {
            $sql .= 'AND model like ? ';
            $params[] = '%'. $_POST["model"] . '%';
        }
        if (isset($_POST['price']) && $_POST['price']) {
            $sql .= 'AND price <= ? ';
            $params[] = $_POST["price"];
        }
        if (isset($_POST['seats']) && $_POST['seats']) {
            $sql .= 'AND seats = ? ';
            $params[] = $_POST["seats"];
        }
        
        // Most rent : we will ad an ORDER BY to rentsCounts COLUMN
        if (isset($_POST['mostRent']) && $_POST['mostRent']) {
            $sql .= ' GROUP BY c.id ORDER BY rentsCount, c.created_at DESC';
        } else {
            $sql .= ' GROUP BY c.id ORDER BY c.created_at DESC ';
        }

        array_push($params, $offset, $limit);
        // List of cars
        $cars = R::getAll($sql . ' LIMIT ?, ?', $params);

        // Count new rents for the current user
        $rentsCount = null;
        if (isset($_POST["role"]) && $_POST["role"] == 'admin') {
            $rentsCount = R::count('rent', "status = ?", ['waiting']);
        } else {
            $rentsCount = R::count('rent', 'user_id = ? AND status = ?', [$_POST["user_id"], 'waiting']);
        }

        // Most rent cars
        $mostRentCars = R::getAll('SELECT c.brand FROM car c INNER JOIN rent r on r.car_id = c.id group by c.brand ORDER BY count(r.id) DESC LIMIT 5'); 
        // Output
        if ($cars) {
            Utils::printResponse(200, ['cars' => $cars, 'rents_count' => $rentsCount, 'brands' => array_values($mostRentCars) ]);
            return;
        }
    }
    Utils::printResponse(200, '');
?>