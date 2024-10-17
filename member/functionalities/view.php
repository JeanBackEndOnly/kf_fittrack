<?php

declare(strict_types=1);

function success_plans(){
    if(isset($_GET["input"]) && $_GET["input"] == "success"){
        echo '<a href="index_plans.php">Plans have been added successfully!<p class="ayaw-konaaaaa">tap top continue</p></a>';
    }
}
function plans_updated(){
    if(isset($_GET["plans"]) && $_GET["plans_id"] && $_GET["plans"] == "updated"){
        echo '<a href="edit_plans.php?plans_id=' . $_GET["plans_id"] . '">Plans have been added successfully!<p class="ayaw-konaaaaa">tap top continue</p></a>';
    }
}
function success_progress(){
    if (isset($_SESSION["image_errors"])) {
        foreach ($_SESSION["image_errors"] as $error) {
            echo "<div class='error-message'><a href='index_progress.php'>" . htmlspecialchars($error) . "</a></div>";
        }
        unset($_SESSION["image_errors"]);
    }else if(isset($_GET["progress"]) && $_GET["progress"] == "success"){
        echo '<a href="index_progress.php">Progress have been added successfully!<p class="ayaw-konaaaaa">tap top continue</p></a>';
    }
}
function edited_Progress(){
    if (isset($_SESSION["image_errors"])) {
        foreach ($_SESSION["image_errors"] as $error) {
            echo "<div class='error-message'><a href='index_progress.php'>" . htmlspecialchars($error) . "</a></div>";
        }
        unset($_SESSION["image_errors"]);
    }else if(isset($_GET["editProgress"]) && $_GET["progress_id"] && $_GET["editProgress"] == "success"){
        $progress_id = $_GET["progress_id"];
        echo '<a href="edit_progress.php?progress_id=' . $progress_id . '">Progress have been edited successfully!<p class="ayaw-konaaaaa">tap top continue</p></a>';
    }
}
function error_success_edit(){
    if(isset($_SESSION['input_errors'])){
        $errors = $_SESSION['input_errors'];
        foreach($errors as $error){
            echo '<a class="errors_edit">' . $error . '</a>';
        }
        unset($_SESSION['input_errors']);
    }else if(isset($_GET["edit"]) && $_GET["member_id"] && $_GET["edit"] == "success"){
        $member_id = $_GET["member_id"];
        echo '<div class="center-popup">';
        echo '<a href="edit_index.php?member_id=' . $member_id . '" class="a-success"><p>Information Edited Successfully!</p>tap to continue</a>';
        echo '</div>';
    }   
}
function password_Members(){
    if(isset($_SESSION['wrong_Password'])){
        $errors = $_SESSION['wrong_Password'];
        foreach($errors as $error){
            echo '<p id="wrong-password">' . $error . '</p>';
        }
        unset($_SESSION['wrong_Password']);
    }else if(isset($_GET["correct"]) && $_GET["correct"] == "password"){
        echo '<a href="reset_Password.php" id="success-password">You can now reset the password!<p>click to continue</p></a>';
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
        echo '<a href="reset_Password.php">Password changed successfully!<p>click to continue</p></a>';
        echo '</div>';
    }
}
function delete_Success(){
    if(isset($_GET["delete"]) && $_GET["delete"] == "sucess"){
        echo '<a href="plans.php">Plan Have Been Deleted Successfully!<p>tap to continue..</p></a>';
    }
} 
function delete_Successfully(){
    if(isset($_GET["delete"]) && $_GET["delete"] == "sucess"){
        echo '<a href="progress.php">Plan Have Been Deleted Successfully!<p>tap to continue..</p></a>';
    }
} 
function attendance(){
    if(isset($_SESSION['time_errors'])){
        $errors = $_SESSION['time_errors'];
        foreach($errors as $error){
            echo '<a href="attendance.php" id="attendance-a">' . $error . '</a>';
        }
        unset($_SESSION['time_errors']);
    }else if(isset($_GET["success"]) && $_GET["success"] == "attendance"){
        echo '<a href="attendance.php" id="attendance-a">Attendance chekced!<p>tap to continue..</p></a>';
    }
}