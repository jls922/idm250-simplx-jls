<?php

    function check_api_key($env) {
        $valid_key    = $env['X-API-KEY'];
        $provided_key = null; // Placeholder to track value. Get val from other team

        $headers = getallheaders();

        foreach ($headers as $name => $value) { 
            if (strtolower($name) === 'x-api-key') { // lowercase for Linux
                $provided_key = $value;
                break;
            }
        } 

        if ($provided_key !== $valid_key) { 
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized', 'details' => 'Invalid API key']);
            exit;
        }
    } 

?>