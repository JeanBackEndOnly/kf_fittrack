<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/view.php';

    $user_id = isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
    $plans_id = isset($_GET["plans_id"]) ? $_GET["plans_id"] : null;

    if ($user_id === null) {
        die("No user ID found in the session.");
    }

    $query = "SELECT members.member_id FROM members
            WHERE users_id = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $member_id = $result["member_id"];

   $query = "SELECT * FROM plans WHERE plans_id = :plans_id;";
   $stmt = $pdo->prepare($query);
   $stmt->bindParam(":plans_id", $plans_id);
   $stmt->execute();
   $plansResult = $stmt->fetch(PDO::FETCH_ASSOC);
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
            <a href="view_plans.php?plans_id=<?php echo $plans_id; ?>&members_id=<?php echo $member_id; ?>"><img src="../../image/arrow-icon.png"></a>
        </div>
        <p id="title">PERSONALIZE YOUR FITNESS JOURNEY</p>
        <div class="row">
            <div class="row-one">
                <form action="../functionalities/plans_Edit.php?members_id=<?php echo $result["member_id"]; ?>" method="post" onsubmit="return validateCheckboxes();">
                    <input type="hidden" value="<?php echo $result["member_id"]; ?>" name="member_id">
                    <input type="hidden" value="<?php echo $plans_id; ?>" name="plans_id">

                    <select name="day" id="day" required>
                        <option value="<?php echo $plansResult["day"]; ?>" selected><?php echo $plansResult["day"]; ?></option>
                        <option value="MONDAY">Monday</option>
                        <option value="TUESDAY">Tuesday</option>
                        <option value="WEDNESDAY">Wednesday</option>
                        <option value="THURSDAY">Thursday</option>
                        <option value="FRIDAY">Friday</option>
                        <option value="SATURDAY">Saturday</option>
                        <option value="SUNDAY">Sunday</option>
                    </select>
                    <input type="date" name="date" class="date-input" value="<?php echo $plansResult["date"]; ?>" required>

                    <select name="workout_day" id="workout_day" required onchange="updateWorkoutExercises()" >
                        <option value="<?php echo $plansResult["workout_day"]; ?>" selected><?php echo $plansResult["workout_day"]; ?></option>
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
                                <?php
                                    $exercises = explode(",", $plansResult["exercise"]);
                                    foreach($exercises as $exercise){
                                        echo '<li>' . $exercise . '</li>';
                                    }
                                ?>
                                <ul id="exercises-list">
                            </div>
                            <div class="diet-plan">
                                <textarea type="text" name="diet_plan" placeholder="Input Diet Plan..." value="<?php echo $plansResult["diet_plan"]; ?>" required><?php echo $plansResult["diet_plan"]; ?></textarea>
                                <button class="create-button">CREAT PLAN</button>
                            </div>
                            </div>
                            <button class="create-button">UPDATE</button>
                        </div>
                        
                    
                </form>

                <div class="back-Button">
                    <a href="view_plans.php?plans_id=<?php echo $plans_id; ?>">Back</a>
                </div>
                <div class="success-popup">
                    <div>
                        <?php
                            success_plans(); 
                            plans_updated();
                        ?>
                    </div>
                    
            </div>
        </div>
        
    </div>

    <script>

    let selectedExercises = <?php echo json_encode($exercises); ?>; 

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

        // Check if the exercise is in the selected exercises
        if (selectedExercises.includes(exercise)) {
            checkbox.checked = true; // Set checkbox to checked if it's selected
        }

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