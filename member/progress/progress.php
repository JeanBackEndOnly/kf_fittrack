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
    <link rel="stylesheet" type="text/css" href="../css/progress.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
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
                        echo '<p id="username">' . htmlspecialchars($username) . '</p>'; 
                    } 
                ?></p>
            </div>
            <div class="navs-div">
                <ul>
                    <a href="../dashboard/dashboard.php">
                        <li id="dashboard-li"><img src="../../image/dashboard.png" class="dashboard-img"><p>DASHBOARD</p></li>
                    </a>
                    <a href="../plans/plans.php">
                        <li id="plans-li"><img src="../../image/plans.png" class="members-img"><p>PLANS</p></li>
                    </a>
                    <a href="progress.php">
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
        <div class="workout-progress">
            <h1>WORKOUT PROGRESS</h1>
        </div>
        <div class="progress-container">
            <?php
                if ($members_id !== null) {
                    $sql = "SELECT * FROM progress WHERE members_id = :members_id;"; 
                    $planStmt = $pdo->prepare($sql);
                    $planStmt->bindParam(":members_id", $members_id);
                    $planStmt->execute();
                    $plans = $planStmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($plans as $row) {
                        echo '<a href="view_progress.php?progress_id=' . $row["progress_id"] . '" class="a-tag">'; 
                            echo '<ul>';
                                if (!empty($row["image_file"])) {
                                    echo '<img src="../../upload_images/' . htmlspecialchars($row["image_file"]) . '" alt="Progress Image" class="progress-image">';
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
        </div>
    </div>
    <div class="popDelete">
                <?php delete_Successfully(); ?>
        </div>
    <div class="add-div">
                <a href="index_progress.php"><img src="../../image/add.png"></a>  
            </div>
    <script>
        let username = document.getElementById("username").innerText;
        username = username.toUpperCase();
        document.getElementById("username").innerText = username;
    </script>
</body>
</html>