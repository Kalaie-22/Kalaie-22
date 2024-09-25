<?php
include 'db.php';
$query = $pdo->query("SELECT * FROM quizzes");
$quizzes = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<html>
    <link rel="stylesheet" type="text/css" href="css/style.css">
<head>
    <title>Online Quiz System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/style.css">
</html>

<body>
<div class="container">
    <h1 class="text-center">Available Quizzes</h1>
    <div class="list-group mt-4">
        <?php foreach ($quizzes as $quiz): ?>
            <a href="quiz.php?quiz_id=<?= $quiz['id'] ?>" class="list-group-item list-group-item-action">
                <?= $quiz['quiz_title'] ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
