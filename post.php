<?php
require_once "vendor/autoload.php";
use App\DB;
$db = new DB();
session_start();
$user_id = $_SESSION["user_id"] ?? 0;
if (isset($_GET["id"])) {
    $post = $db->get_post_by_id($_GET["id"]);
    if (count($post)) {
        $db->post_views($post["Id"]);
        $post["Data"] = DateTime::createFromFormat("Y-m-d", $post["Data"])->format("d.m.Y");
        $post["Tags"] = explode(",", $post["Tags"]);
        $comments = $db->get_post_comments($post["Id"]);
        $comments = array_map(function ($comment){
            $comment["Data"] = DateTime::createFromFormat("Y-m-d", $comment["Data"])->format("d.m.Y");
            return $comment;
        }, $comments);
        $autor = ($user_id === $post["User_id"]);
    }else {
        header("location: index.php");
        exit;
    }
}
else {
    header("location: index.php");
    exit;
}
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
    <link rel = "stylesheet" href = "assets/css/post.css">
</head>
<body>
<script src="assets/js/common.js" defer></script>
<script src="assets/js/post.js" defer></script>

<?php include "include/header.php"?>

<main>
    <div class="inner_container">
        <div class="post">
            <div class="post_info">
                <p class="user_name"><?= $post["User_name"] ?></p>
                <p class="data"><?= $post["Data"] ?></p>
            </div>
            <?php if ($autor): ?>
                <div class="button-delete">
                    <form id=""  action = "scripts/delete.php" method="post">
                        <input type = "hidden" name="post_id" value="<?= $post["Id"] ?>">
                        <button id="delete">Удалить пост</button>
                    </form>
                </div>
            <?php endif; ?>
            <h2><?= $post["Name"] ?></h2>
            <div class="cover">
                <img src = "<?= $post["Cover"] ?>" alt = "">
            </div>
            <div class="content">
                <?= $post["Content"] ?>
            </div>
            <div class="tags">
                <p>
                    <strong>Теги:</strong>
                    <?php  foreach ($post["Tags"] as $tag): ?>
                        <a href="index.php?filter=<?= $tag ?>"><?= $tag ?></a>
                    <?php endforeach; ?>
                </p>
            </div>
            <div class="post_stats">
                <div class = "stat">
                    <img src = "assets/image/view-eye.svg" alt = "">
                    <p><?= $post["Views"] +1 ?></p>
                </div>
                <div class = "stat">
                    <img src = "assets/image/comment-3.svg" alt = "">
                    <p><?= count($comments) ?></p>
                </div>
            </div>
        </div>
        <div class="comments">
            <h2>Коментарии</h2>
            <?php if ($user_id): ?>
                <button id="show_form">Добавить комментарий</button>
                <form id="comment_form" style="display: none" action = "scripts/add_comment.php" method="post">
                    <input type = "hidden" name="post_id" value="<?= $post["Id"] ?>">
                    <label for="comment">Введите комментарий</label>
                    <textarea name = "comment" id="comment" rows = "10"></textarea>
                    <button>Добавить</button>
                </form>
            <?php endif; ?>
            <?php if (!count($comments)): ?>
                <p>Нет комментариев</p>
            <?php endif; ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <div class="comment_info">
                        <p class="user_name"><?= $post["User_name"] ?></p>
                        <p class="data"><?= $comment["Data"] ?></p>
                    </div>
                    <p><?= $comment["Text"] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include "include/footer.php"?>
</body>
</html>