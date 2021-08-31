<?php

    require '../../index.php';
    
    if (isset($_POST["brand"]) && isset($_POST["model"]) &&
    isset($_POST["price"]) && isset($_POST["photo"]) &&
    isset($_POST["max_speed"]) && isset($_POST["fuel"]) &&
    isset($_POST["auto"]) && isset($_POST["seats"]) &&
    isset($_POST["pickup_position"]) && isset($_POST["cyl_num"])) {
        
        $car = isset($_POST["CRUD"]) && $_POST["CRUD"] == "U" ? R::load( 'car', $_POST["id"] ) : R::dispense( 'car' );
        $car->brand = $_POST["brand"];
        $car->model = $_POST["model"];
        $car->price = $_POST["price"];
        $car->photo = $_POST["photo"];
        $car->max_speed = $_POST["max_speed"];
        $car->fuel = $_POST["fuel"];
        $car->auto = $_POST["auto"];
        $car->seats = $_POST["seats"];
        $car->pickup_position = $_POST["pickup_position"];
        $car->cyl_num = $_POST["cyl_num"];
        
        $id = null;
        switch ($_POST["CRUD"]) {
            case "C":
            case "U":
                $id = R::store($car);
                if ($id) {
                    Utils::printResponse(200, 'Voiture ' . ($_POST["CRUD"] == "C" ? "ajoutée" : "modifiée") . ' avec success !');
                    return;
                }
                break;
            case "D":
                $id = R::exec("DELETE FROM car WHERE id=:id", [":id" => intval($_POST["id"]) ]);
                Utils::printResponse(200, 'Voiture supprimée avec success !');
                    return;
                break;
            default:break;
        }
    }
    Utils::printResponse(400, 'On peut pas inserer cette voiture, verifier ces details');
    
?>