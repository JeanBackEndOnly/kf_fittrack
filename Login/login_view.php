<?php

declare(strict_types=1);

function login_errors(){
    if(isset($_SESSION['errors_login'])){
        $errors = $_SESSION['errors_login'];

        echo "<br>";

        foreach($errors as $error){
            echo '<p>' .$error. '</p>';
        }

        unset($_SESSION['errors_login']);
    }else if(isset($_GET['login']) && $_GET['login'] === "success"){
        echo "<br>";
        echo "<p>login sucessfully!</p>";
    }
}