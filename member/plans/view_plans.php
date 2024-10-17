<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';

    $plans_id = isset($_GET["plans_id"]) ? $_GET["plans_id"] : "NO ID FOUND";
    $members_id = isset($_GET["members_id"]) ? $_GET["members_id"] : "NO ID FOUND";
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/view_plans.css?v=<?php echo time(); ?>">
</head>
<body>
    
    <div class="container">
    <a href="plans.php" id="back-a"><img src="../../image/arrow-icon.png"></a>
        <?php
            $query = "SELECT * FROM plans WHERE plans_id = :plans_id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":plans_id", $plans_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo '<div class="box-title">';
                echo '<p id="exercise-title">EXERCISES:</p>';
                echo '<p id="diet-title">DIET PLAN:</p>';
            echo '</div>';
            
                foreach($result as $row){
                    $exercises = explode(",", $row["exercise"]); 
                    echo '<div class="title">';
                        echo '<p>' . $row["workout_day"] . '</p>';
                    echo '</div>';
                    echo '<div class="date-day">';
                        echo '<p class="day">' . $row["day"] . '</p>';
                        echo '<p class="date"> ' . $row["date"] . '</p>';
                    echo '</div>';
                        
                    echo '<div class="row">';
                        echo '<ul>';
                            echo '<div class="exercise">';
                            foreach($exercises as $exercise) {
                                
                                echo '<li>' . htmlspecialchars($exercise) . '</li>';
                            }
                            if($exercises == "Leg Press"){
                                echo '<img src="../../image/logo.png">';
                            }
                            echo '</div>';
                            echo '<div class="diet">';
                                echo '<p id="diet-p">' . $row["diet_plan"] . '</p>';
                            echo '</div>';
                        echo '</ul>';
                    echo '</div>';
                }
        ?>
        <div class="buttons-domain">
            <button onclick="showPopup(<?php echo $row['plans_id']; ?>, <?php echo $row['members_id']; ?>)" id="delete-button">DELETE</button>
            <a href="edit_plans.php?plans_id=<?php echo $plans_id; ?>" id="edit-button">EDIT</a>
        </div>

        <div id="confirmPopup-<?php echo $row['plans_id']; ?>" class="popup">
            <div class="popup-content">
                <h2>Are you sure you want to delete this plan?</h2>
                <form action="../functionalities/plans_Delete.php" method="post">
                    <input type="hidden" name="plans_id" value="<?php echo $row["plans_id"]; ?>">
                    <input type="hidden" name="members_id" value="<?php echo $row["members_id"]; ?>">
                    <button type="submit" id="yesButton">YES</button>
                </form>
                <button id="noButton" onclick="hidePopup(<?php echo $row['plans_id']; ?>)">NO</button>
            </div>
        </div>
    </div>
    <script>
        document.getElementById("delete-Button").disabled=true;
        function showPopup(id, memberId) {
            const popup = document.getElementById(`confirmPopup-${id}`);
            popup.style.display = "flex";
        }

        function hidePopup(id) {
            const popup = document.getElementById(`confirmPopup-${id}`);
            popup.style.display = "none";
        }

        window.onclick = function(event) {
            const popups = document.querySelectorAll('.popup');
            popups.forEach(function(popup) {
                if (event.target === popup) {
                    popup.style.display = "none";
                }
            });
        }
    </script>
</body>
</html>
