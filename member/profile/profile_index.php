<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';

    if(isset($_SESSION["user_id"])){
        $users_id = $_SESSION["user_id"];

        $query = "SELECT * FROM members WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/profile.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <!-- <div class="img-class">
            <img src="../../image/bg-info.jpg">
        </div> -->
        <a href="../dashboard/dashboard.php" class="back-button"><img src="../../image/arrow-icon.png"></a>
        <?php
                echo (!empty(isset($result["profile_picture"]))) ? '<p class="pfp"><img src="../../upload_images/' . $result["profile_picture"] . '"></p>' : '<p class="pfp"><img src="../../image/logo.png"></p>';
            
            echo '<div class="information">';
                echo '<ul>';
                    echo '<li><p>ID #: ' . $result["member_id"] . '</p></li>';
                    echo '<div class="form-column">';
                        echo '<div class="column-one">';
                            echo '<li><p><img src="">' . $result["fullName"] . '</p></li>';
                            echo '<li><p><img src="">' . $result["email"] . '</p></li>';
                            echo '<li><p><img src="">' . $result["address"] . '</p></li>';
                        echo '</div>';
                        echo '<div class="column-two">';
                            echo '<li><p><img src="">' . $result["phone_no"] . '</p></li>';
                            echo '<li><p><img src="">' . $result["gender"] . '</p></li>';
                            echo '<li><p><img src="">' . $result["age"] . '</p></li>';
                        echo '</div>';
                    echo '</div>';
                echo  '</ul>';
           echo ' </div>';
           echo '<div class="a-functions">';
                echo '<a href="edit_index.php?member_id=' . $result["member_id"] . '" class="a-edit"><img src="../../image/edit-icon.png">EDIT</a>';
                echo '<a href="password_index.php?member_id=' . $result["member_id"] . '" class="a-change"><img src="../../image/change-pass.png">Change Password</a>';
           echo '</div>';
        ?>
    </div>
    
</body>
</html>