<?php

    require '../../index.php';
    
    if (isset($_POST["car_id"]) && isset($_POST["user_id"])) {
        
        $rent = isset($_POST["CRUD"]) && $_POST["CRUD"] == "U" ? R::load( 'rent', $_POST["id"] ) : R::dispense( 'rent' );
        if (isset($_POST["car_id"]) && $_POST["car_id"]) {
            $rent->car_id = $_POST["car_id"];
        }
        if (isset($_POST["user_id"]) && $_POST["user_id"]) {
            $rent->user_id = $_POST["user_id"];
        }
        if (isset($_POST["pickup_date"]) && $_POST["pickup_date"]) {
            $rent->pickup_date = $_POST["pickup_date"];
        }
        if (isset($_POST["return_date"]) && $_POST["return_date"]) {
            $rent->return_date = $_POST["return_date"];
        }
        if (isset($_POST["local"]) && $_POST["local"]) {
            $rent->local = $_POST["local"];
        }
        if (isset($_POST["client_phone"]) && $_POST["client_phone"]) {
            $rent->client_phone = $_POST["client_phone"];
        }
        if (isset($_POST["status"]) && $_POST["status"]) {
            $rent->status = $_POST["status"];
        }
        
        $id = null;
        switch ($_POST["CRUD"]) {
            case "C":
            case "U":
                $id = R::store($rent);
                if ($id) {
                    Utils::printResponse(200, 'Location ' . ($_POST["CRUD"] == "C" ? "ajoutée" : "modifiée") . ' avec success !');
                    return;
                }
                break;
            case "D":
                $id = R::exec("DELETE FROM rent WHERE id=:id", [":id" => intval($_POST["id"]) ]);
                Utils::printResponse(200, 'Location supprimée avec success !');
                    return;
                break;
            default:break;
        }
    }
    Utils::printResponse(200, 'On peut pas inserer cette location, verifier ces details');
    
?>