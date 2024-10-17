<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';

    $progress_id = isset($_GET["progress_id"]) ? $_GET["progress_id"] : "Id not found!";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/view_progress.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <a href="progress.php" id="a-back"><img src="../../image/arrow-icon.png"></a>
        <?php
            $query = "SELECT * FROM progress WHERE progress_id = :progress_id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":progress_id", $progress_id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach($result as $row){
                $exercises = explode(",", $row["exercise"]); 
                echo '<div class="title">';
                    echo'<p>' . $row["workout_day"] . '</p>';
                echo'</div>';
                echo '<div class="date">';
                    echo'<p id="p-day">' . $row["day"] . '</p>';
                    echo'<p id="p-date">' . $row["date"] . '</p>';
                echo'</div>';
                
                echo '<div class="image-exercise">';
                    echo'<p class="img"><img src="../../upload_images/' . $row["image_file"] . '"></p>';
                    echo '<ul>';
                    echo'<p id="p-exercise">HIGHLIGHT EXERCISES</p>';
                    foreach($exercises as $exercise) {
                        echo '<li>' . htmlspecialchars($exercise) . '</li>';
                    }
                    echo '</ul>';
                echo '</div>';
            }
        ?>
        <div class="buttons-domain">
            <button onclick="showPopup(<?php echo $row['progress_id']; ?>, <?php echo $row['members_id']; ?>)" id="delete-button">DELETE</button>
            <button id="edit-button"><a href="edit_progress.php?progress_id=<?php echo $row["progress_id"]; ?>">EDIT</a></button>
        </div>

        <div id="confirmPopup-<?php echo $row['progress_id']; ?>" class="popup">
            <div class="popup-content">
                <h2>ARE YOU SURE YOU WANT TO DELETE THIS PLAN?</h2>
                <form action="../functionalities/progress_Delete.php" method="post">
                    <input type="hidden" name="progress_id" value="<?php echo $row["progress_id"]; ?>">
                    <button type="submit" id="yesButton">YES</button>
                </form>
                <button id="noButton" onclick="hidePopup(<?php echo $row['progress_id']; ?>)">NO</button>
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