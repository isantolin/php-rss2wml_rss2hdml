<?php

function mobile_cleanup($input) {
    $output = strip_tags($input);
    return $output;
}


function curl_get_xml($u, $enc) {
    $curl = curl_init();

    curl_setopt_array($curl, Array(
        CURLOPT_URL => $u,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_ENCODING => $enc
    ));

    $data = curl_exec($curl);
    curl_close($curl);

    libxml_use_internal_errors(true);
    $xml = simplexml_load_string($data);

    return $xml;
}

function curl_manage_error($data) {
    if ($data === false) {
        echo "Failed loading XML\n";
        foreach (libxml_get_errors() as $error) {
            echo "\t", $error->message;
        }
        die();
    }
}
