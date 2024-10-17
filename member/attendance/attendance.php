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


$this_time = $current_time;

if($members_id){
    $query = "SELECT * FROM attendance WHERE members_id = :members_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":members_id", $members_id);
    $stmt->execute();
    $time_out_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $time_out = isset($time_out_result["Mtime_out"]) ? $time_out_result["Mtime_out"] : null;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member</title>
    <link rel="stylesheet" type="text/css" href="../css/attendance.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="header">
        <div class="attendance_napud">
            <div class="row">
            <div class="attendance-labels">
                    <h1>MORNING ATTENDANCE</h1>
                    <h1>NOON TIME ATTENDANCE</h1>
                    <h1>AFTERNOON ATTENDANCE</h1>
                    <h1>EVENING ATTENDANCE</h1>
                </div>
                <div class="column-one">
                    <form action="../attendance_funct/morning_time_in.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Mtime_in" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-in">TIME IN</button>
                    </form>
                    <form action="../attendance_funct/noon_time_in.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Ntime_in" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-in">TIME IN</button>
                    </form>
                    <form action="../attendance_funct/afternoon_time_in.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Atime_in" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-in">TIME IN</button>
                    </form>
                    <form action="../attendance_funct/evening_time_in.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Etime_in" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-in">TIME IN</button>
                    </form>
                </div>
                <div class="column-two">
                    <form action="../attendance_funct/morning_time_out.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Mtime_out" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-out">TIME OUT</button>
                    </form>
                    <form action="../attendance_funct/noon_time_out.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Ntime_out" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-out">TIME OUT</button>
                    </form>
                    <form action="../attendance_funct/afternoon_time_out.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Atime_out" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-out">TIME OUT</button>
                    </form>
                    <form action="../attendance_funct/evening_time_out.php?members_id=<?php echo $members_id; ?>" method="post">
                        <input type="hidden" name="Etime_out" value="<?php echo $this_time; ?>">
                        <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
                        <button id="button-time-out">TIME OUT</button>
                    </form>
                </div>
                
            </div>
        </div>
        <div class="attendance-error-success">
            <?php
                attendance();
            ?>
        </div>
        <div class="side-nav">
            <div class="user">
            <a href="../profile/profile_index.php">
            <?php
             echo ($result['profile_picture'] ==! "") ? '<img src="../../upload_images/' . $result["profile_picture"] . '" class="user-img">' : '<img src="../../image/no-profile.png">';
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
                    <a href="../dashboard/dashboard.php">
                        <li id="dashboard-li"><img src="../../image/dashboard.png" class="dashboard-img"><p>DASHBOARD</p></li>
                    </a>
                    <a href="../plans/plans.php">
                        <li id="plans-li"><img src="../../image/plans.png" class="members-img"><p>PLANS</p></li>
                    </a>
                    <a href="../progress/progress.php">
                        <li id="progress-li"><img src="../../image/progress.png" class="members-img"><p>PROGRESS</p></li>
                    </a>
                    <a href="attendance.php">
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
