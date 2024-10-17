<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div id="loading-screen">
        <img id="logo" src="../../image/logo.png" alt="Loading Icon" class="loading-icon"  loading="lazy">
    </div>

    <style>
    #loading-screen {
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        overflow: hidden;
        opacity: 1;
        transition: opacity 0.5s ease-out;
    }

    .loading-icon {
        width: 200px;
        height: 200px;
    }

    #loading-screen.hide {
        visibility: hidden;
        opacity: 0;
        pointer-events: none;
    }
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }

    #logo {
        animation: rotate 1s linear infinite; 
    }

    </style>

    <script>
        window.addEventListener("load", function() {
            const loadingScreen = document.getElementById("loading-screen");
            
            setTimeout(function() {
                loadingScreen.classList.add("hide");
                
                requestAnimationFrame(function() {
                    loadingScreen.style.display = 'none';
                });
            }, 500); 
        });
    </script>
</body>
</html>

