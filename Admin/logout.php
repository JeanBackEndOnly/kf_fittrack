<?php

header("Location: ../index.php");
session_start();
session_unset();
session_destroy();

die();