<?php
ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

$host = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'localhost' : '192.168.1.20';

session_set_cookie_params([
    'lifetime' => 5000,
    'domain' => $host,
    'path' => '/',
    'secure' => false,
    'httponly' => true
]);

session_start();

if(isset($_SESSION["user_id"])){
    if(!isset($_SESSION["last_regeneration"])){
        regenerate_session_id_loggedin();
    }else{
        $interval = 3000;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }
    }
}else{
    if(!isset($_SESSION["last_regeneration"])){
        regenerate_session_id();
    }else{
        $interval = 3000;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id_loggedin(){
    session_regenerate_id(true);

    
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id(){
    session_regenerate_id(true); 
    $_SESSION["last_regeneration"] = time();
}
