<?php

require_once "../../include/config.php";
require_once "../../include/session.php";

$member_id = isset($_GET["member_id"]) ? $_GET["member_id"] : "not found";

    $query = "SELECT members.*, users.id, contract.* FROM members
    LEFT JOIN users ON members.users_id = users.id
    LEFT JOIN contract ON members.member_id = contract.members_id
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
    <link rel="stylesheet" type="text/css" href="../../css/admin_contract.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <?php
            echo '<ul class="view-image-div">';
                echo '<div class="view-expired-ul">';
                    echo '<div class="back-to-home">';
                    echo '<form action="contract_Index.php" method="post">';
                        echo  '<input type="hidden" name="search" value="' . $member_id . '">';
                        echo  '<button class="back-button"><img src="../../image/arrow-icon.png"></button>';
                    echo  '</form>';
                        echo '<a href="contract_Index.php?member_id=' . $member_id . '" id="back-to-home"></a>';
                    echo '</div>';
                                    
                    echo isset($result["profile_picture"]) ? '<li><img src="../../upload_images/'
                        . $result["profile_picture"] . '"></li>' : '<li><img src="../../image/no-profile.png"></li>';
                    echo '<div class="id-divs">';
                        echo isset($result["member_id"]) ? '<li>ID# ' . $result["member_id"] . '</li>' : "no";
                        echo '<li>' . $result["fullName"] . '</li>';
                    echo '</div>';
                    echo '<div class="rows-contract">';
                        echo '<div class="renewal-div">';
                            echo '<li id="contract-pakaw">RENEWAL</li>';
                            echo '<li id="contract-pakaw">STATUS</li>';
                            echo isset($result["contract_Renewal"]) ? '<li id="renawal-li">' . $result["contract_Renewal"] . '</li>' : '<li id="noContract-li">NO CONTRACT</li>';
                        echo '</div>';
                        echo '<div class="expiation-div">';
                            echo '<li id="contract-pakaw">EXPIRATION</li>';
                            echo '<li id="contract-pakaw">STATUS</li>';
                            echo isset($result["contract_Expiration"]) ? '<li id="expiration-li">' . $result["contract_Expiration"] . '</li>' : '<li id="noContract-li">NO CONTRACT</li>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</ul>';
        ?>
</body>
</html>
