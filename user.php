<?php
require_once "vendor/autoload.php";
use App\DB;
$db = new DB();
session_start();
$user_id = $_SESSION["user_id"] ?? 0;
?>

<!doctype html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">
    <meta name = "viewport"
          content = "width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv = "X-UA-Compatible" content = "ie=edge">
    <title>Блог</title>
    <link rel = "stylesheet" href = "assets/css/common.css">
    <?php if ($user_id): ?>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
        <link rel = "stylesheet" href = "assets/css/new_post.css">
    <?php else: ?>
        <link rel = "stylesheet" href = "assets/css/user.css">
    <?php endif; ?>
</head>
<body>
<script src="assets/js/common.js" defer></script>

<?php include "include/header.php"?>

<?php
if ($user_id) {
    include "include/user_post.php";
}
else{
    include "include/user_login.php";
}
?>

<?php if ($user_id): ?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js" defer></script>
    <script src="assets/js/new_post.js" defer></script>
<?php else: ?>
    <script src="assets/js/user.js" defer></script>
<?php endif; ?>

<?php include "include/footer.php"?>

</body>
</html>