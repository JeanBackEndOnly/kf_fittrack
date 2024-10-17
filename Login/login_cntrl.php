<?php

declare(strict_types=1);

function empty_inputs($username, $password){
    if(empty($username) || empty($password)){
            return true;
     }else{
        return false;
     }
}

function wrong_username(bool|array $result){
    if(!$result){
        return true;
    }else{
        return false;
    }
}

// function wrong_password(String $password, String $hashedPassword){
//     if(!password_verify($password, $hashedPassword)){
//         return true;
//     }else{
//         return false;
//     }
// }

function wrong_password(string $password, string $hashedPassword): bool {
    return !password_verify($password, $hashedPassword);
}
