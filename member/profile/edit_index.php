<?php
    require_once '../../include/config.php';
    require_once '../../include/session.php';
    require_once '../functionalities/view.php';
    
    if (isset($_GET["member_id"])) {
        $member_id = $_GET["member_id"];
    } else {
        echo "member_id not retrieved";
    }

    try {
        $query = "SELECT * FROM members WHERE member_id = :member_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":member_id", $member_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result === false) {
            throw new Exception("No member found with the provided member_id");
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="../css/edit_profile.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <a href="profile_index.php" class="back-button">
            <img src="../../image/arrow-icon.png">
        </a>
        <div class="information">
            <form action="../functionalities/profile_Edit.php?member_id=<?php echo $member_id; ?>" method="post" enctype="multipart/form-data">

                <input type="hidden" value="<?php echo $member_id; ?>" name="member_id">
                <input type="hidden" name="current_profile_picture" value="<?php echo htmlspecialchars($result['profile_picture']); ?>">

                <?php
                if (!empty($result['profile_picture'])) {
                    echo '<label for="pfp"><img src="../../upload_images/' . htmlspecialchars($result["profile_picture"]) . '"></label>';
                } else {
                    echo '<label for="pfp"><img src="../../image/adding-icon.png"> </label>';
                }
                ?>
                <input type="file" class="pfp" name="profile_picture" id="pfp">

                <div class="form-column">
                    <div class="column-one">
                        <input type="text" value="<?php echo htmlspecialchars($result["fullName"]); ?>" name="fullName" placeholder="Full Name" required>
                        <input type="email" value="<?php echo htmlspecialchars($result["email"]); ?>" name="email" placeholder="E-mail" required>
                        <input type="text" value="<?php echo htmlspecialchars($result["address"]); ?>" name="address" placeholder="Address" required>
                    </div>
                    <div class="column-two">
                        <input type="text" value="<?php echo htmlspecialchars($result["phone_no"]); ?>" name="phone_no" placeholder="Phone #" required>
                        <select name="gender" id="gender">
                            <option value="MALE" <?php if ($result["gender"] == "MALE") echo 'selected'; ?>>MALE</option>
                            <option value="FEMALE" <?php if ($result["gender"] == "FEMALE") echo 'selected'; ?>>FEMALE</option>
                        </select>
                        <input type="text" value="<?php echo htmlspecialchars($result["age"]); ?>" name="age" placeholder="Age" required>
                    </div>
                </div>
                <button type="submit"><img src="../../image/edit-icon.png" id="edit-img">EDIT</button>
            </form>
            <?php
                error_success_edit();
            ?>
        </div>
    </div>
</body>
</html>
