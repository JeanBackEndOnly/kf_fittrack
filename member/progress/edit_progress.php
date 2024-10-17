<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/view.php';

    $progress_id = isset($_GET["progress_id"]) ? $_GET["progress_id"] : "no progress_id found";

    $query = "SELECT * FROM progress WHERE progress_id = :progress_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":progress_id", $progress_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $members_id = isset($result["members_id"]) ? $result["members_id"] : "no members_id found";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Progress</title>
    <link rel="stylesheet" type="text/css" href="../css/edit_progress.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <div class="edit_Success">
            <?php
                edited_Progress();
            ?>
        </div>
        
        <a href="view_progress.php?progress_id=<?php echo $result["progress_id"]; ?>" id="a-back">
            <img src="../../image/arrow-icon.png">
        </a>
        <form action="../functionalities/progress_Edit.php" method="post" enctype="multipart/form-data" onsubmit="return validateCheckboxes();">
            <input type="hidden" name="progress_id" value="<?php echo $progress_id; ?>">
            <input type="hidden" name="members_id" value="<?php echo $members_id; ?>">
            <div class="add-image">
                <label for="image_file">
                    <img src="../../upload_images/<?php echo $result['image_file'] ?? ''; ?>" alt="Add Image" value="<?php echo $result['image_file']; ?>">
                </label>
                <input type="file" name="image_file" id="image_file" value="<?php echo $result['image_file']; ?>">
            </div>
            <div class="select-domain">
                <input type="date" id="date" name="date" class="date-input" value="<?php echo $result['date']; ?>" required>

                <select name="workout_day" id="workout_day" required onchange="updateWorkoutExercises()">
                    <option value="<?php echo $result['workout_day']; ?>" selected><?php echo $result['workout_day']; ?></option>
                    <option value="PULL DAY">Pull Day</option>
                    <option value="PUSH DAY">Push Day</option>
                    <option value="LEG DAY">Leg Day</option>
                    <option value="UPPER BODY">Upper Body</option>
                    <option value="LOWER BODY">Lower Body</option>
                    <option value="FULL BODY">Full Body</option>
                    <option value="CORE DAY">Core Day</option>
                    <option value="CARDIO DAY">Cardio Day</option>
                </select>

                <select name="day" id="day" required>
                    <option value="<?php echo $result['day']; ?>" selected><?php echo $result['day']; ?></option>
                    <option value="MONDAY">Monday</option>
                    <option value="TUESDAY">Tuesday</option>
                    <option value="WEDNESDAY">Wednesday</option>
                    <option value="THURSDAY">Thursday</option>
                    <option value="FRIDAY">Friday</option>
                    <option value="SATURDAY">Saturday</option>
                    <option value="SUNDAY">Sunday</option>
                </select>
            </div>
            
            <p id="exercise-p">SELECT EXERCISES:</p>
            <div id="exercise-options" class="exercise-options"></div>
            
            <p id="selected-p">SELECTED EXERCISES:</p>
            <div id="selected-exercises" class="selected-exercise">
                <ul id="exercises-list"></ul>
            </div>

            <button type="submit" class="create-button" onclick="button_click()" id="edit-button">EDIT</button>
        </form>
    </div>

    <script>

        function button_click() {
            let button = document.getElementById("edit-button");

            button.onclick = function() {
                console.log("Button clicked!");
            };
        }

        function updateWorkoutExercises() {
            const workoutDay = document.getElementById("workout_day").value;
            const exerciseOptionsDiv = document.getElementById("exercise-options");
            exerciseOptionsDiv.innerHTML = ""; 

            let exercises = [];
            let selectedExercises = <?php echo json_encode(explode(',', $result['exercise'])); ?>; // array of selected exercises

            switch (workoutDay) {
                case "PULL DAY":
                    exercises = ["Pull-ups", "Barbell Rows", "Lat Pulldown", "Deadlifts"];
                    break;
                case "PUSH DAY":
                    exercises = ["Push-ups", "Bench Press", "Overhead Press", "Dips"];
                    break;
                case "LEG DAY":
                    exercises = ["Squats", "Leg Press", "Lunges", "Step-Ups"];
                    break;
                case "UPPER BODY":
                    exercises = ["Bicep Curls", "Tricep Dips", "Shoulder Press"];
                    break;
                case "LOWER BODY":
                    exercises = ["Squats", "Leg Press", "Hamstring Curls"];
                    break;
                case "FULL BODY":
                    exercises = ["Burpees", "Push-ups", "Mountain Climbers"];
                    break;
                case "CORE DAY":
                    exercises = ["Planks", "Sit-ups", "Russian Twists"];
                    break;
                case "CARDIO DAY":
                    exercises = ["Running", "Cycling", "Jump Rope"];
                    break;
                default:
                    exercises = [];
            }

            exercises.forEach(function(exercise) {
                let checkboxLabel = document.createElement("label");
                let checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.value = exercise;
                checkbox.name = "exercise[]";

                // Check if the exercise is in the selected exercises from the database
                if (selectedExercises.includes(exercise)) {
                    checkbox.checked = true;
                }

                checkbox.onchange = displaySelectedExercises;
                checkboxLabel.appendChild(checkbox);
                checkboxLabel.appendChild(document.createTextNode(exercise));
                exerciseOptionsDiv.appendChild(checkboxLabel);
                exerciseOptionsDiv.appendChild(document.createElement("br"));
            });

            // Display selected exercises in list
            displaySelectedExercises();
        }

        function displaySelectedExercises() {
            const checkboxes = document.querySelectorAll('input[name="exercise[]"]:checked');
            const selectedExercises = Array.from(checkboxes).map(cb => cb.value);
            const exercisesList = document.getElementById("exercises-list");

            exercisesList.innerHTML = "";

            selectedExercises.forEach(function(exercise) {
                let listItem = document.createElement("li");
                listItem.textContent = exercise;
                exercisesList.appendChild(listItem);
            });
        }

        function validateCheckboxes() {
            const checkboxes = document.querySelectorAll('input[name="exercise[]"]:checked');
            if (checkboxes.length === 0) {
                alert('Please select at least one exercise.');
                return false;
            }
            return true;
        }

        window.onload = updateWorkoutExercises;
    </script>
</body>
</html>
