
<?php

require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/all_view.php';

    if(isset($_GET['member_id'])){
        $member_id = intval($_GET["member_id"]);

        $query = "SELECT * FROM members WHERE member_id= :member_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":member_id", $member_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$result){
            echo '<p>No Member Found</p>';
            die();
        }
    }else {
        echo '<p>Member ID not provided.</p>';
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/edit.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="outer-container">
        <div class="inner-container">
            <img src="../../image/logo.png" class="logo-img">
            <div class="back-button">
            <form action="search_Index.php" method="post">
                <input type="hidden" name="search" value="<?php echo $member_id; ?>">
            <button class="back-button"><img src="../../image/back-button.png"></button>
            </form>
            </div>
            <form action="../functionalities/membership_Edit.php?member_id=<?php echo $result['member_id'] ?> " method="post">       
                <div class="form-columns">
                    <div class="column-one">
                        <input type="hidden" name="member_id" value="<?php echo $result["member_id"]; ?>">
                        <input type="hidden" name="users_id" value="<?php echo $result["users_id"]; ?>">
                        <input type="text" name="fullName" value="<?php echo $result['fullName']; ?>" placeholder="Full Name:">
                        <input type="email" name="email" value="<?php echo $result["email"]; ?>" placeholder="E-mail">
                        <input type="text" name="address" value="<?php echo $result["address"]; ?>" placeholder="Address">
                    </div>
                    <div class="column-one">
                        <input type="text" name="phone_no" value="<?php echo $result["phone_no"]; ?>" placeholder="Phone #">
                         <select name="gender" id="gender">
                            <option value="MALE">MALE</option>
                            <option value="FEMALE">FEMALE</option>
                         </select>
                        <input type="text" name="age" value="<?php echo $result["age"]; ?>" placeholder="Age">
                    </div>
                </div>
                <div class="button-update">
                    <button>Update Member</button>
                </div>
            </form>
            <div class="success-popup">
                <?php
                    sucess_edit();
                ?>
            </div>
            <div class="error-popup">
                <?php
                    error_edit();
                ?>
            </div>
        </div>
    </div>
</body>
</html>