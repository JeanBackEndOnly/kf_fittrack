<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';

    try {
        $query = "SELECT COUNT(*) as total_members FROM members"; 
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $totalMembers = $stmt->fetchColumn();
    
        $query = "SELECT COUNT(contract_Renewal) as total_contract FROM contract WHERE DATE(contract_Renewal) <= CURDATE()";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $totalContract = $stmt->fetchColumn(); 

        $query = "SELECT COUNT(contract_Expiration) as total_contract FROM contract WHERE DATE(contract_Expiration) < CURDATE()";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $totalExpiredContract = $stmt->fetchColumn();

        $query = "SELECT COUNT(*) as total_active
          FROM attendance a1
          WHERE attendance_at = CURDATE()
          AND (
            (Mtime_in IS NOT NULL AND Mtime_out IS NULL AND NOT EXISTS (
                SELECT * FROM attendance a2 
                WHERE a2.members_id = a1.members_id 
                AND a2.Mtime_out IS NOT NULL AND a2.attendance_at = CURDATE()
            )) OR
            (Ntime_in IS NOT NULL AND Ntime_out IS NULL AND NOT EXISTS (
                SELECT * FROM attendance a2 
                WHERE a2.members_id = a1.members_id 
                AND a2.Ntime_out IS NOT NULL AND a2.attendance_at = CURDATE()
            )) OR
            (Atime_in IS NOT NULL AND Atime_out IS NULL AND NOT EXISTS (
                SELECT * FROM attendance a2 
                WHERE a2.members_id = a1.members_id 
                AND a2.Atime_out IS NOT NULL AND a2.attendance_at = CURDATE()
            )) OR
            (Etime_in IS NOT NULL AND Etime_out IS NULL AND NOT EXISTS (
                SELECT * FROM attendance a2 
                WHERE a2.members_id = a1.members_id 
                AND a2.Etime_out IS NOT NULL AND a2.attendance_at = CURDATE()
            ))
          )";
          
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $totalActive = $stmt->fetchColumn();





    } catch (PDOException $e) {
        die("Query Failed: " . $e->getMessage());
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="../../css/admin_dashboard.css?v=<?php echo time(); ?>">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="header">
        <div class="side-nav">
                <div class="user">
                   <img src="../../image/logo.png" class="user-img">
                </div>
                <div class="navs-div">
                    <ul class="nav-ul">
                        <a href="" id="a-nav"><li id="dashboard-li"><img src="../../image/dashboard-icon.png" class="dashboard-img"><p>DASHBOARD</p></li></a>
                        <a href="../membership/membership_Index.php" id="a-nav"><li id="members-li"><img src="../../image/membership.png" class="members-img"><p>MEMBERSHIP</p></li></a>
                        <a href="../contract/contract_Index.php" id="a-nav"><li id="contract-li"><img src="../../image/contract-logo.png" class="contract-img"><p class="contract-p">CONTRACT</p></li></a>
                    </ul>
                </div>
                <ul class="logout-ul">
                    <a href="../logout.php"><li id="logout-li"><img src="../../image/logout-icon.png" class="logout-img"><p>LOGOUT</p></li></a>
                </ul>
            </div>
            <div class="content-container">
                <div class="row">
                    <div class="contract-renewed">
                        <?php
                            echo '<p class="contract-title-one">CONTRACT</p>';
                            echo '<p class="contract-title-two">RENEWAL</p>';
                            echo '<h1 class="contract-count">' . $totalContract . '</h1>';
                        ?>
                    </div>
                    <div class="gym-members">
                        <?php
                            echo '<p class="contract-title-one">REGISTERED</p>';
                            echo '<p class="contract-title-two">MEMBERS</p>';
                            echo '<h1 class="contract-count">' . $totalMembers . '</h1>';
                        ?>
                    </div>
                    <div class="contract-expired">
                        <?php
                            echo '<p class="contract-title-one">CONTRACT</p>';
                            echo '<p class="contract-title-two">EXPIRED</p>';
                            echo '<h1 class="contract-count">' . $totalExpiredContract . '</h1>';
                        ?>
                    </div>
                    <div class="active-members">
                        <?php
                            echo '<p class="contract-title-one">ACTIVE</p>';
                            echo '<p class="contract-title-two">MEMBERS</p>';
                            echo '<h1 class="contract-count">' . $totalActive . '</h1>';
                        ?>
                    </div>
                </div>
                <div class="change-password">
                    <a href="password_index.php"><img src="../../image/change-pass.png">Change password</a>
                </div>
            <div class="p-div">
                <p>EXPIRED CONTRACTS</p>
            </div>
            <div class="expired-contract">
                <?php
                    $sql = "SELECT contract.*, members.* FROM contract
                    INNER JOIN members ON contract.members_id = members.member_id
                    WHERE contract_Expiration < CURDATE()";
                        if($result = $pdo->query($sql)){
                            foreach($result as $row){
                                echo '<ul class="expired-ul">';
                                    echo isset($row["profile_picture"]) ? '<li><img src="../../upload_images/'
                                        . $row["profile_picture"] . '"></li>' : '<li><img src="../../image/no-profile.png"></li>';
                                    echo '<div class="id-div">';
                                        echo '<li>ID# ' . $row["members_id"] . '</li>';
                                        echo '<li>' . $row["fullName"] . '</li>';
                                    echo '</div>';
                                    echo '<div class="row-contract">';
                                        echo '<div class="expiration-div">';
                                            echo '<li>RENEWAL DATE</li>';
                                            echo '<li id="renewal-li">' . $row["contract_Renewal"] . '</li>';
                                        echo '</div>';
                                        echo '<div class="contract-div">';
                                        echo '<li>EXPIRED DATE</li>';
                                            echo '<li id="expiration-li">' . $row["contract_Expiration"] . '</li>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</ul>';                         
                            }                        
                        }
                ?>
            </div>
            
        </div>
    </div>
</body>
</html>