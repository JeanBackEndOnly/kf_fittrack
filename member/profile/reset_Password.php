<?php 
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/view.php';

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
    <link rel="stylesheet" type="text/css" href="../css/reset.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="outer-container">
        <div class="inner-container">
        <a href="profile_index.php?id=<?php echo isset($id) ? $id : '' ?>" class="back"><img src="../../image/arrow-icon.png"></a>
            <img src="../../image/logo.png" id="img-logo">
            
            <form action="../functionalities/profile_Reset.php?id=<?php echo isset($id) ? $id : '' ?>" method="post">
                <input type="password" name="new_Password" Placeholder="New Password" required>
                <input type="password" name="confirm_Password" Placeholder="confirm Password" required>
                <button>Update</button>
            </form>
            <div class="popup">
                <?php
                    password_Members();
                ?>
            </div>
            <div class="popupPassword">
                <?php
                    password_reset();
                ?>
            </div>
        </div>
    </div>
</body>
</html>