<?php
include 'db.php';

$quiz_id = $_GET['quiz_id'];
$query = $pdo->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$query->execute([$quiz_id]);
$questions = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<html>
<head>
    <title>Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Quiz</h1>

    <form action="score.php" method="POST">
        <?php foreach ($questions as $question): ?>
            <div class="mb-4">
                <h5><?= $question['question_text'] ?></h5>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" value="a" required>
                    <label class="form-check-label"><?= $question['option_a'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" value="b">
                    <label class="form-check-label"><?= $question['option_b'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" value="c">
                    <label class="form-check-label"><?= $question['option_c'] ?></label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" value="d">
                    <label class="form-check-label"><?= $question['option_d'] ?></label>
                </div>
            </div>
        <?php endforeach; ?>
        <input type="hidden" name="quiz_id" value="<?= $quiz_id ?>">
        <button type="submit" class="btn btn-primary">Submit Quiz</button>
    </form>
</div>
</body>
</html>
