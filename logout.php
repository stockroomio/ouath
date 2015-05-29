<?php
session_start();
unset($_SESSION['github_data']); 
header("Location: index.php");
?>