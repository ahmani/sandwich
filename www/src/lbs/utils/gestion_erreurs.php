<?php


use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;




        function json_error($resp,$code,$message) {
            $resp = $resp->withJson(array('Erreur' => $message), $code);
            return $resp;
        };
        function json_success($resp,$code,$message) {
            $resp = $resp->withJson(array('Succes' => $message), $code);
            return $resp;
        };
