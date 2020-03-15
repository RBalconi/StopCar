<?php
session_start();
include('../util/urls.php');

// unset($_SESSION['namesession']); // Destroy session chosen;
session_destroy();
header('Location: '.urlIndex);
exit();