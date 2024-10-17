<?php

declare(strict_types=1);

function user_inputs() {
    echo "<div class='form-columns'>";
    echo "<div class='column-one'>";

    if (isset($_SESSION["user_signup"]["fullName"]) && !isset($_SESSION["errors_signup"])) {
        echo '<li><input type="text" name="fullName" placeholder="Full Name:" value = "' . $_SESSION["user_signup"]["fullName"] . '"></li>';
    } else {
        echo '<li><input type="text" name="fullName" placeholder="Full Name:"></li>';
    }
    if (isset($_SESSION["user_signup"]["email"]) && !isset($_SESSION["errors_signup"]["email_registered"])) {
        echo '<li><input type="email" name="email" placeholder="E-mail:" value = "' . $_SESSION["user_signup"]["email"] . '"></li>';
    } else {
        echo '<li><input type="email" name="email" placeholder="E-mail:"></li>';
    }
    if (isset($_SESSION["user_signup"]["address"]) && !isset($_SESSION["errors_signup"])) {
        echo '<li><input type="text" name="address" placeholder="Address:" value = "' . $_SESSION["user_signup"]["address"] . '"></li>';
    } else {
        echo '<li><input type="text" name="address" placeholder="Address:"></li>';
    }
    if (isset($_SESSION["user_signup"]["phone_no"]) && !isset($_SESSION["errors_signup"])) {
        echo '<li><input type="tel" name="phone_no" placeholder="Phone No:" value = "' . $_SESSION["user_signup"]["phone_no"] . '"></li>';
    } else {
        echo '<li><input type="tel" name="phone_no" placeholder="Phone No:"></li>';
    }
    if (isset($_SESSION["user_signup"]["age"]) && !isset($_SESSION["errors_signup"])) {
        echo '<li><input type="text" name="age" placeholder="Age:" value = "' . $_SESSION["user_signup"]["age"] . '"></li>';
    } else {
        echo '<li><input type="text" name="age" placeholder="Age:"></li>';
    }

    if (isset($_SESSION["user_signup"]["gender"]) && !isset($_SESSION["errors_signup"])) {
        echo '<select name="gender" id="gender" value = "' . $_SESSION["user_signup"]["gender"] . '">';
        echo    '<option value="NONE">SELECT GENDER</option>';
        echo    '<option value="MALE">MALE</option>';
        echo   '<option value="FEMALE">FEMALE</option>';
        echo '</select >';
    } else {
        echo '<select name="gender" id="gender">';
        echo    '<option value="NONE">SELECT GENDER</option>';
        echo    '<option value="MALE">MALE</option>';
        echo   '<option value="FEMALE">FEMALE</option>';
        echo '</select >';
    }

    echo "</div>";
    echo "<div class='column-two'>";
    if (isset($_SESSION["user_signup"]["username"]) && !isset($_SESSION["errors_signup"]["username_taken"])) {
        echo '<li><input type="text" name="username" placeholder="Username:" value = "' . $_SESSION["user_signup"]["username"] . '"></li>';
    } else {
        echo '<li><input type="text" name="username" placeholder="Username:"></li>';
    }

    echo '<li><input type="password" name="password" placeholder="Password:"></li>';

    echo '<li><input type="password" name="confirm_password" placeholder="Confirm Password:"></li>';

    echo '<button class="signup-button"><img src="../../image/add-icon.png">ADD</button>';
    echo "</div>";
    echo "</div>";
}

function signup_errors(){
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];

        echo "<br>";

        foreach ($errors as $error){
            echo '<div class="error-div">';
            echo '<a href="register_Index.php"><p class="p-error">' . $error . '</p></a>';
            echo '<div>';
        }

        unset($_SESSION['errors_signup']);
    }else if(isset($_GET["signup"]) && $_GET["signup"] == "success"){
        echo '<div class="success-div">';
        echo '<a class="a-register" href="register_Index.php"><p>Member Have Been Added Successfully</p>tap to continue</a>';
        echo '</div>';
    }
}

function delete_success(){
    if(isset($_GET["deleted"]) && $_GET["deleted"] == "successfully"){
        echo '<a href="membership_Index.php" id="aaa"><p>MEMBER HAVE BEEN SUCCESSFULLY DELETED</p><p>CLICK TO CONTINUE</p></a>';
    }
}
function contract_success(){
    if(isset($_GET["contract"]) && !empty($_GET["members_id"]) && $_GET["contract"] == "success"){
        $member_id = $_GET["members_id"];
        echo '<a href="add_Index.php?member_id=' . $member_id . '">CONTRACT HAVE BEEN SUCCESSFULLY ADDED<p>CLICK TO CONTINUE</p></a>';
    }else{
        echo '<p class="no-background"></p>';
    }
}

function deleteContract_success(){
    if(isset($_GET["deletedContract"]) && $_GET["deletedContract"] == "sucessfully"){
        echo '<a href="contract_Index.php"><p>CONTRACT HAVE BEEN DELETED SUCCESSFULLY</p><p>CLICK TO CONTINUE</p></a>';
    }
}

function sucess_edit(){
    if(isset($_GET["edit"]) && $_GET["member_id"] && $_GET["edit"] == "success"){
        $member_id = $_GET["member_id"];
        echo '<a href="edit_Index.php?member_id=' . $member_id . '">INFORMATION HAVE BEEN EDITED SUCCESSFULLY<p>CLICK TO CONTINUE.</p></a>';
    }
}
function error_edit(){
    if(isset($_SESSION['errors_input'])){
        $errors = $_SESSION['errors_input'];
        foreach($errors as $error){
            echo '<p>' . $error . '</p>';
        }
        unset($_SESSION['errors_input']);
    }
}
function password_Admin(){
    if(isset($_SESSION['wrong_Password'])){
        $errors = $_SESSION['wrong_Password'];
        foreach($errors as $error){
            echo '<p>' . $error . '</p>';
        }
        unset($_SESSION['wrong_Password']);
    }else if(isset($_GET["correct"]) && $_GET["correct"] == "password"){
        echo '<a href="reset_Index.php">You can now reset the password!<p>click to continue</p></a>';
    }
}
function password_reset(){
    if(isset($_SESSION['password_notMatch'])){
        $errors = $_SESSION['password_notMatch'];
        foreach($errors as $error){
            echo '<p class="password-error">' . $error . '</p>';
        }
        unset($_SESSION['password_notMatch']);
    }else if(isset($_GET["reset"]) && $_GET["reset"] == "success"){
        echo '<div class="password-success">';
        echo '<a href="reset_Index.php">Password changed successfully!<p>click to continue</p></a>';
        echo '</div>';
    }
}
function noContract(){
    if(isset($_GET["no"]) && $_GET["no"] == "contract"){
        echo '<a href="contract_Index.php?" id="noContract">No contract yet To Delete!<p>click to continue!</p></a>';
    }
}
function cannot_Dlete(){
    if(isset($_GET["contract"]) && $_GET["contract"] == "exist"){
        echo '<a href="membership_Index.php?" id="haveContract">Contract Still Exist!. Cannot Delete This Member<p>click to continue!</p></a>';
    }
}