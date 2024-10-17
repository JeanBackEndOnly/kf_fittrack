<?php
require_once '../../include/config.php';
require_once '../../include/session.php';
require_once '../functionalities/view.php';

$member_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : "NO USER ID";

$query = "SELECT * FROM members
          WHERE users_id = :member_id;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":member_id", $member_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$members_id = isset($result["member_id"]) ? $result["member_id"] : null; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="../css/plans.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
        <div class="plan-title">
            <h1>GOALS TO ACHIEVE</h1>
            <h3>TODAY</h3>
        </div>
        <div class="today">
            <?php
            if ($members_id !== null) {
                    $sql = "SELECT * FROM plans WHERE members_id = :members_id AND date = CURDATE();"; 
                    $planStmt = $pdo->prepare($sql);
                    $planStmt->bindParam(":members_id", $members_id);
                    $planStmt->execute();
                    $plans = $planStmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($plans as $row) {
                        echo '<a href="view_plans.php?plans_id=' . $row["plans_id"] . '&members_id=' . $row["members_id"] .'" class="a-tag">'; 
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
                        echo '</a>';
                    }
                    }else {
                    echo '<p>No plans found for this member.</p>';
                }

                    ?>
        </div>
        <div class="upcoming-plans">
            <h3>UP COMING PLANS</h3>
        </div>
        <div class="plans-container">
            <?php
                if ($members_id !== null) {
                    $sql = "SELECT * FROM plans WHERE members_id = :members_id AND date > CURDATE();"; 
                    $planStmt = $pdo->prepare($sql);
                    $planStmt->bindParam(":members_id", $members_id);
                    $planStmt->execute();
                    $plans = $planStmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($plans as $row) {
                        echo '<a href="view_plans.php?plans_id=' . $row["plans_id"] . '&members_id=' . $row["members_id"] .'" class="a-tag">'; 
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
                        echo '</a>';
                    }
                } else {
                    echo '<p>No plans found for this member.</p>';
                }
            ?>
            <div class="delete_notification">
                <?php delete_Success(); ?>
            </div>
        </div>
        <a href="index_plans.php" class="plans-button"><button><img src="../../image/add.png"></button></a>  
        <div class="side-nav">
            <div class="user">
            <a href="../profile/profile_index.php">
            <?php
                echo ($result['profile_picture'] ==! "") ? '<img src="../../upload_images/' . $result["profile_picture"] . '" class="user-img">' : '<img src="../../image/no-profile.png">';
            ?>
            </a>
                <p><?php
                    if (isset($_SESSION["user_username"])) {
                        $username = $_SESSION["user_username"];
                        echo '<p id="username">' . $username . '</p>';
                    } 
                ?></p>
            </div>
            
            <div class="navs-div">
                <ul>
                    <a href="../dashboard/dashboard.php">
                        <li id="dashboard-li"><img src="../../image/dashboard.png" class="dashboard-img"><p>DASHBOARD</p></li>
                    </a>
                    <a href="plans.php">
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
    </div>
    
    <script>
        let username = document.getElementById("username").innerText;
        username = username.toUpperCase();
        document.getElementById("username").innerText = username;
    </script>
</body>
</html>