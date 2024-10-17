<?php 
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/all_view.php';

    if(isset($_SESSION["user_id"])){
        $id = $_SESSION["user_id"];
    }else{
        echo "id not found";
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
        <form action="../functionalities/profile_ResetPass.php?id=<?php echo isset($id) ? $id : '' ?>" method="post">
            <input type="password" name="new_Password" Placeholder="New Password" required>
            <input type="password" name="confirm_Password" Placeholder="confirm Password" required>
            <button>Update</button>
        </form>
        <div class="popupPassword">
            <?php
                password_reset();
            ?>
        </div>
    </div>
</body>
</html>