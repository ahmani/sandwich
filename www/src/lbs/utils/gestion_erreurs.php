<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




        function json_error($resp,$code,$message) {
            $resp = $resp->withStatus( $code );
            $resp->getBody()
                 ->write(json_encode(array('Erreur' => $message)));
            return $resp;
        };
        function json_success($resp,$code,$message) {
            $resp = $resp->withStatus( $code );
            $resp->getBody()
                 ->write(json_encode(array('Succes' => $message)));
            return $resp;
        };
