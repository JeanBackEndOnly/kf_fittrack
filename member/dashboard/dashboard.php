<?php
require_once '../../include/config.php';
require_once '../../include/session.php';

    $users_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "NO USER ID";
    
    $query = "SELECT * FROM members WHERE users_id = :users_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    $resultMemberId = $stmt->fetch(PDO::FETCH_ASSOC);

    $members_id = $resultMemberId["member_id"];
    $query = "SELECT * FROM plans WHERE DATE(date) = CURDATE() AND members_id = :members_id  ;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":members_id", $members_id);
    $stmt->execute();
    $resultMembersId = $stmt->fetch(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM contract WHERE members_id = :members_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":members_id", $members_id);
    $stmt->execute();
    $resultDate = $stmt->fetch(PDO::FETCH_ASSOC);

    $expirationDate = (!empty(isset($resultDate["contract_Expiration"]))) ? new DateTime($resultDate["contract_Expiration"]) : "No Contract Yet"; 
    $renewalDate = (!empty(isset($resultDate["contract_Renewal"]))) ? new DateTime($resultDate["contract_Renewal"]) : "No Contract Yet"; 

    $currentDate = new DateTime();
?>  

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="../css/dashboard.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
        <div class="side-nav">
            <div class="user">
            <a href="../profile/profile_index.php">
                <?php
                    echo ($resultMemberId['profile_picture'] ==! "") ? '<img src="../../upload_images/' . $resultMemberId["profile_picture"] . '" class="user-img">' : '<img src="../../image/no-profile.png">';
                ?>
            </a>
                <p><?php
                        if(isset($_SESSION["user_username"])){
                            $username = $_SESSION["user_username"];
                            echo '<p id="username">' . $username . '</p>';
                        }
                     ?></p>
            </div>
            <div class="navs-div">
                <ul>
                    <a href="dashboard.php">
                        <li id="dashboard-li"><img src="../../image/dashboard.png" class="dashboard-img"><p>DASHBOARD</p></li>
                    </a>
                    <a href="../plans/plans.php">
                        <li id="plans-li"><img src="../../image/plans.png" class="members-img"><p>PLANS</p></li>
                    </a>
                    <a href="../progress/progress.php">
                        <li id="progress-li"><img src="../../image/progress.png" class="members-img"><p>PROGRESS</p></li>
                    </a>
                    <a href="../attendance/attendance.php">
                        <li id="attendance-li"><img src="../../image/attendance.png" class="dashboard-img"><p>ATTENDANCE</p></li>
                    </a>
                </ul>
                <ul>
                    <a href="../logout.php">
                        <li id="logout-li"><img src="../../image/logout-icon.png" class="logout-img"><p>LOGOUT</p></li>
                    </a>
                </ul>
            </div>
        </div>
        <div class="dashboard-informations">
            <div class="date">
                <?php
                    echo '<h1 class="date-h1">' . date('l') . '</h1>';
                    echo '<p class="date-p">' . date('d/m/y') . '</p>';
                ?>
            </div>
            <div class="workout-day">
                <?php
                    echo '<h1 class="workout-h1">WORKOUT DAY:</h1>';
                    echo (!empty(isset($resultMembersId["workout_day"]))) ? '<p class="workout-p">' . htmlspecialchars($resultMembersId["workout_day"]) . '</p>' : "<p class='workout-p'>NO PLAN YET";
                ?>
            </div>
            <div class="contract-expiration">
                <?php
                    if($expirationDate == "No Contract Yet"){
                        echo '<p id="no-contract">NO CONTRACT</p>';
                                    
                    }else{
                        $interval = $currentDate->diff($expirationDate);

                        if ($currentDate > $expirationDate) {
                            echo '<p id="no-contract">CONTRACT EXPIRED.</p>';
                        } else {
                            echo "<h1 class='contract-h1'>CONTRACT LEFT: <h1><p class='contract-p'>" . $interval->days . " days </p>";
                        }
                    }
                ?>
            </div>
            <h2>INCOMING WORKOUT PLANS</h2>
            <div class="workout-img">
                <?php
                    $query = "SELECT * FROM plans WHERE members_id = :members_id AND date >= CURDATE();";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":members_id", $members_id);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                            echo '<ul>';
                                if(isset($row["workout_day"]) && $row["workout_day"] == "PULL DAY"){
                                    echo '<img src="../../image/pull-day.jpg">';
                                }else if(isset($row["workout_day"]) && $row["workout_day"] == "PUSH DAY"){
                                    echo '<img src="../../image/push-day.jpg">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "LEG DAY"){
                                    echo '<img src="../../image/leg-day.jpg">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "UPPER BODY"){
                                    echo '<img src="../../image/upper-body-exercise.jpg">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "LOWER BODY"){
                                    echo '<img src="../../image/lower-body-day.jpg">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "FULL BODY"){
                                    echo '<img src="../../image/full-body-workout.png">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "CORE DAY"){
                                    echo '<img src="../../image/core-day.jpg">';
                                }
                                else if(isset($row["workout_day"]) && $row["workout_day"] == "CARDIO DAY"){
                                    echo '<img src="../../image/cardio-day.png">';
                                }
                                echo '<div class="text-class">';
                                    echo '<div class="work-day">';
                                         echo '<li><p>' . htmlspecialchars($row["workout_day"]) . '</p></li>'; 
                                    echo '</div>';
                                    echo '<div class="day-date">';
                                        echo '<li><p id="day-id">' . htmlspecialchars($row["day"]) . '</p></li>'; 
                                        echo '<li><p id="date-id">' . htmlspecialchars($row["date"]) . '</p></li>'; 
                                    echo '</div>';
                                echo '</div>';
                            echo '</ul>';
                    }
                ?>
            </div>
            
    </div>
    <script>
        let username = document.getElementById("username").innerText;
        username = username.toUpperCase();
        document.getElementById("username").innerText = username;
    </script>
</body>
</html>
