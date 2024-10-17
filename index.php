<?php
    require_once 'include/config.php';
    require_once 'include/session.php';
    require_once 'Login/login_view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#000000">
    <title>Login</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" type="text/css" href="css/login.css?v=<?php echo time(); ?>">
    <link rel="manifest" href="manifest.json">
</head>
<body>
    <div class="inner-container" style="position: relative;">
        <div class="icon">
            <img src="image/logo.png" alt="">
        </div>
        <form action="Login/login.php" method="post">
            <div class="row-username">
                <img src="image/user-icon.png"><input type="text" name="username" placeholder="Username:">
            </div>
            <div class="row-password">
                <img src="image/password-icon.png">
                <input type="password" name="password" placeholder="Password:" id="password">
                
                <span class="password-toggle-icon">
                    <img id="toggleIcon" src="image/no-view-password.png" alt="Toggle Password Visibility">
                </span>
            </div>

            <button class="login-button" onclick="view_button()">Login</button>
        </form>
            <div class="error"><?php
                login_errors();
            ?></div>
    </div>
    <script src="main.js"></script>

    <script>
        const passwordField = document.getElementById("password");
        const toggleIcon = document.getElementById("toggleIcon");

        toggleIcon.addEventListener("click", function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.src = "image/view-password.png"; 
            } else {
                passwordField.type = "password";
                toggleIcon.src = "image/no-view-password.png";
            }
        });

</script>
</body>
</html>