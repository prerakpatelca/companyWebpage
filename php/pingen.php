<?php

header("Content-type: text/plain");

sleep(rand(0,2)); // simulate slow connection

$name = filter_input(INPUT_GET, "name", FILTER_SANITIZE_STRING);
$method = filter_input(INPUT_GET, "method", FILTER_SANITIZE_STRING);

if ($name === null || $method === null || $method !== "ASCII" && 
        $method !== "Random" || $name === "") {
    echo "BAD PARAMETERS";
} else {
    if ($method === "Random") {
        echo rand(100001, 999999);
    } else {
        $pin = 100001;
        for ($i = 0; $i < strlen($name); $i++) {
            $pin += ord($name)*ord($name)*ord($name);
        }
        echo $pin % 1000000;
    }
}

