<?php

require_once "../../include/config.php";
require_once "../../include/session.php";

$member_id = isset($_GET["member_id"]) ? $_GET["member_id"] : "not found";

    $query = "SELECT members.*, users.id FROM members
    INNER JOIN users ON members.users_id = users.id
    WHERE member_id = :member_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":member_id", $member_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin_membership.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container-view">
        <?php
           echo '<div class="view-image-div">';
            echo '<ul class="view-expired-ul">';
                    echo '<div class="view-back-to-home">';
                        echo '<a href="membership_Index.php" id="view-back-to-home"><img src="../../image/arrow-icon.png" id="arrow-back"></a>';
                    echo '</div>';     

                    echo isset($result["profile_picture"]) ? '<li><img src="../../upload_images/'
                        . $result["profile_picture"] . '"></li>' : '<li><img src="../../image/no-profile.png"></li>';

                    echo '<div class="view-id-divs">';
                        echo '<li>ID# ' . $result["member_id"] . '</li>';
                        echo '<li>' . $result["fullName"] . '</li>';
                    echo '</div>';
                        echo '<div class="row-two-column">';
                            echo '<div class="column-one">';
                                echo '<h5>EMAIL</h5>';
                                echo '<li id="expiration-li" class="email-wrap">' . $result["email"] . '</li>';
                                echo '<h5>PHONE #</h5>';
                                echo '<li id="expiration-li">' . $result["phone_no"] . '</li>';
                            echo '</div>';
                            echo '<div class="column-two">';
                                echo '<h5>ADDRESS</h5>';
                                echo '<li id="expiration-li">' . $result["address"] . '</li>';
                                echo '<h5>GENDER</h5>';
                                echo '<li id="expiration-li">' . $result["gender"] . '</li>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="age-chad">';
                            echo '<h5>AGE</h5>';
                            echo '<li id="age-li">' . $result["age"] . '</li>';
                        echo '</div>';
                    echo '</div>';
                echo '</ul>';
            echo '</div>';
        ?>
</body>
</html>
