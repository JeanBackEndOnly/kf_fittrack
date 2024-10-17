<?php

declare(strict_types=1);

function fileSize_notCompatible(array $image){
    if($image["size"] > 5 * 1024 * 1024){
        return true;
    }else{
        return false;
    }
}

function image_notCompatible(array $image, array $allowed_types){
    if(!in_array($image["type"], $allowed_types)){
        return true;
    }else{
        return false;
    }
}

function file_notUploaded(array $image, string $target_file){
    if (!move_uploaded_file($image["tmp_name"], $target_file)) {
        return true;
    }else{
        return false;
    }
}
function empty_image(array $image){
    if(empty($image)){
        return true;
    }else{
        return false;
    }
}

function empty_input($fullName, $email, $address, $phone_no, $gender, $age, $image){
    if(empty($fullName) || empty($email) || empty($address) || empty($phone_no) || empty($gender) || empty($age) || empty($image)){
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
function password_NotMatched(object $pdo, int $id, string $current_Password) {
    $user = get_Password($pdo, $id);
    if (!$user || !password_verify($current_Password, $user['password'])) {
        return true;
    }
    return false;
}
function confirm_password(String $confirm_password, String $password){
    if($confirm_password != $password){
        return true;
    }else{
        return false;
    }
}
function reset_password(object $pdo, String $new_Password, int $id){
    $query = "UPDATE users SET password = :new_Password WHERE id = :id;";
    $hasedPassword = password_hash($new_Password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":new_Password", $hasedPassword);
    $stmt->bindParam(":id", $id);
    $stmt->execute();                                                                           
}
function edit_information(object $pdo, String $fullName, String $email, String $address, String $phone_no, String $gender, String $age, String $profile_picture, int $member_id){
    $query = "UPDATE members SET fullName = :fullName, email = :email, address = :address, phone_no = :phone_no,
              gender = :gender, age = :age, profile_picture = :profile_picture WHERE member_id = :member_id;";
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":fullName", $fullName);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":phone_no", $phone_no);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":profile_picture", $profile_picture); 
    $stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);
    
    $stmt->execute();
}
