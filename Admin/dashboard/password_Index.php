<?php
require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/all_view.php';

if(isset($_SESSION["user_id"])){
    $id = $_SESSION["user_id"];
} else {
    $id = null;
    echo "ID not found";
}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin_dashboard.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="inner-container">
        <a href="dashboard_index.php"><img src="../../image/back-button.png"></a>
        <img src="../../image/logo.png" class="logo">
        <div class="current-Password">
            <form action="../functionalities/profile_ChangePass.php?id=<?php echo isset($id) ? $id : ''; ?>" method="post">
                <input type="password" name="current_Password" placeholder="Current Password:" required>
                <button class="current-button">Confirm</button>
            </form>
            <div class="popup">
                <?php
                    password_Admin();
                ?>
            </div>
        </div>
    </div>
</body>
</html>
