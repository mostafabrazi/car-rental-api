<?php

class Utils {

    public static function printResponse($code = 200, $response = null)
    {
        // response http code
        http_response_code($code);
        // output it as json
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            404 => '400 Not Found',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
            );
        // ok, validation error, or failure
        header('Status: '.$status[$code]);
        // return the encoded json
        echo json_encode(array(
            'status' => $code < 300, // success or not?
            'message' => $response
            ));
    }
}

?>