<?php

declare(strict_types=1);

function empty_inputs($username, $password, $email,
 $fullName, $address, $phone_no, $gender, $age){
    if(empty($username) || empty($password) || empty($email) ||
        empty($fullName) || empty($address) || empty($phone_no) || empty($gender) || empty($age)){
            return true;
     }else{
        return false;
     }
}
function Inputs_empty($fullName, $email,
    $address, $phone_no, $gender, $age){
        if(empty($fullName) || empty($email) ||
            empty($address) || empty($phone_no) || empty($gender) || empty($age)){
                return true;
        }else{
            return false;
        }
}

function invalid_email($email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
     }else{
        return false;
     }
}

function username_taken(object $pdo, String $username){
    if(get_username($pdo, $username)){
        return true;
    }else{
        return false;
    }
}

function email_registered(object $pdo, String $email){
    if(get_email($pdo, $email)){
        return true;
    }else{
        return false;
    }
}

function confirm_password(String $confirm_password, String $password){
    if($confirm_password != $password){
        return true;
    }else{
        return false;
    }
}

function password_NotMatched(object $pdo, int $id, string $current_Password) {
    $user = get_Password($pdo, $id);
    if (!$user || !password_verify($current_Password, $user['password'])) {
        return true;
    }
    return false;
}

function reset_password(object $pdo, String $new_Password, int $id){
    $query = "UPDATE users SET password = :new_Password WHERE id = :id;";
    $hasedPassword = password_hash($new_Password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":new_Password", $hasedPassword);
    $stmt->bindParam(":id", $id);
    $stmt->execute();                                                                           
}

function get_UserAcc(object $pdo, String $username, String $password){
    $user_Role = "members";
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (username, password, user_Role) VALUES
    (:username, :password, :user_Role);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":user_Role", $user_Role);
    $stmt->execute();

    return(int) $pdo->lastInsertId();

}   

function get_UserInfo(object $pdo, int $id, String $fullName, String $email, String $address, String $phone_no, String $gender, int $age){
    $query = "INSERT INTO members (users_id, fullName, email, address, phone_no, gender, age) VALUES 
    (:id, :fullName, :email, :address, :phone_no, :gender, :age);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":fullName", $fullName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":phone_no", $phone_no);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":age", $age);
    $stmt->execute();
}

function edit_MemberInfo($pdo, $users_id, $fullName, $email, $address, $phone_no, $gender, $age) {
    $query = "UPDATE members SET fullName = :fullName, email = :email, address = :address, phone_no = :phone_no, gender = :gender, age = :age WHERE users_id = :users_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":fullName", $fullName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":phone_no", $phone_no);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":users_id", $users_id);
    return $stmt->execute();
}

function getUserIpnput(object $pdo, String $username, String $password, String $fullName, String $email, String $address, String $phone_no, String $gender, int $age){
        $id = get_UserAcc($pdo, $username, $password);
        get_UserInfo($pdo, $id, $fullName, $email, $address, $phone_no, $gender, $age);
}