<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/view.php';

    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;

    if ($user_id === null) {
        die("No user ID found in the session.");
    }

    $query = "SELECT members.member_id FROM members
            INNER JOIN users ON members.users_id = users.id
            WHERE users.id = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $result["member_id"]; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workout Plan</title>
    <link rel="stylesheet" type="text/css" href="../css/index_plans.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <div class="back-Button">
            <a href="plans.php"><img src="../../image/arrow-icon.png"></a>
        </div>
        <p id="title">PERSONALIZE YOUR FITNESS JOURNEY</p>
        <div class="row">
            <div class="row-one">
                <form action="../functionalities/plans_Add.php?member_id=<?php echo $result["member_id"]; ?>" method="post" onsubmit="return validateCheckboxes();">
                    <input type="hidden" value="<?php echo $result["member_id"]; ?>" name="member_id">
                    <select name="day" id="day" required>
                        <option value="NONE" selected>Select Workout Day</option>
                        <option value="MONDAY">Monday</option>
                        <option value="TUESDAY">Tuesday</option>
                        <option value="WEDNESDAY">Wednesday</option>
                        <option value="THURSDAY">Thursday</option>
                        <option value="FRIDAY">Friday</option>
                        <option value="SATURDAY">Saturday</option>
                        <option value="SUNDAY">Sunday</option>
                    </select>
                    <input type="date" name="date" class="date-input" required>
                    <select name="workout_day" id="workout_day" required onchange="updateWorkoutExercises()" >
                        <option value="NONE" selected>Select Workout Program</option>
                        <option value="PULL DAY">Pull Day</option>
                        <option value="PUSH DAY">Push Day</option>
                        <option value="LEG DAY">Leg Day</option>
                        <option value="UPPER BODY">Upper Body Day</option>
                        <option value="LOWER BODY">Lower Body Day</option>
                        <option value="FULL BODY">Full Body Workout</option>
                        <option value="CORE DAY">Core Day</option>
                        <option value="CARDIO DAY">Cardio Day</option>
                    </select>
                    <div class="row-two">
                    <div id="exercise-options" class="exercise-options">
                    </div>
            </div>
                            <div class="row-three">
                            <div id="selected-exercises">
                                <p>Selected Exercises:</p>
                                <ul id="exercises-list">
                            </div>
                            <div class="diet-plan">
                                <textarea type="text" name="diet_plan" placeholder="Input Diet Plan..." required></textarea>
                            </div>
                            </div>
                            <button class="create-button">CREAT PLAN</button>
                        </div>
                </form>
                <div class="success-popup">
                    <?php success_plans(); ?>
                </div>
        </div>
    </div>

    <script>
        function updateWorkoutExercises() {
            const workoutDay = document.getElementById("workout_day").value;
            const exerciseOptionsDiv = document.getElementById("exercise-options");
            exerciseOptionsDiv.innerHTML = ""; 

            let exercises = [];

            if (workoutDay === "PULL DAY") {
                exercises = ["Pull-ups", "Barbell Rows", "Lat Pulldown", "Deadlifts"];
            } else if (workoutDay === "PUSH DAY") {
                exercises = ["Push-ups", "Bench Press", "Overhead Press", "Dips"];
            } else if (workoutDay === "LEG DAY") {
                exercises = ["Squats", "Deadlifts", "Leg Press", "Lunges", "Bulgarian Split Squat", "Step-Ups",
                    "Leg Extensions", "Leg Curls", "Glute Bridge", "Lunges", "Hip Thrusts", "Calf Raises",
                    "Smith Machine Squats", "Sumo Deadlift", "Hack Squat", "Farmer's Walk"];
            } else if (workoutDay === "UPPER BODY") {
                exercises = ["Bicep Curls", "Tricep Dips", "Chest Fly", "Shoulder Press"];
            } else if (workoutDay === "LOWER BODY") {
                exercises = ["Squats", "Leg Press", "Calf Raises", "Hamstring Curls"];
            } else if (workoutDay === "FULL BODY") {
                exercises = ["Burpees", "Deadlifts", "Push-ups", "Mountain Climbers"];
            } else if (workoutDay === "CORE DAY") {
                exercises = ["Planks", "Sit-ups", "Russian Twists", "Leg Raises"];
            } else if (workoutDay === "CARDIO DAY") {
                exercises = ["Running", "Cycling", "Jump Rope", "Rowing"];
            } else {
                exercises = []; 
            }

            exercises.forEach(function(exercise) {
                let checkboxLabel = document.createElement("label");
                let checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.value = exercise;
                checkbox.name = "exercise[]";  
                checkbox.onchange = displaySelectedExercises;
                checkboxLabel.appendChild(checkbox);
                checkboxLabel.appendChild(document.createTextNode(exercise));
                exerciseOptionsDiv.appendChild(checkboxLabel);
                exerciseOptionsDiv.appendChild(document.createElement("br"));
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

        window.onload = updateWorkoutExercises;
    </script>
</body>
</html>
