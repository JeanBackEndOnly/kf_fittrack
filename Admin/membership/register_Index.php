<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/all_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin_membership_add.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="outer-container">
        <div class="inner-container">
            <div class="icon">
                <img src="../../image/logo.png">
            </div>
            <div class="back-a">
                <a class="a-back" href="membership_Index.php"><img src="../../image/arrow-icon.png" id="back-img">BACK</a>
            </div>
            <form action="../functionalities/membership_Add.php" method="post">
                <?php user_inputs(); ?>
            </form>
            <div class="error-success">
                    <p><?php signup_errors(); ?></p>
                </div>
            
            
        </div>
    </div>
</body>
</html>