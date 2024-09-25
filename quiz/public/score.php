<?php
include 'db.php';

$answers = $_POST['answers'];
$quiz_id = $_POST['quiz_id'];

$correct_answers = 0;
$total_questions = count($answers);

foreach ($answers as $question_id => $selected_option) {
    $query = $pdo->prepare("SELECT correct_option FROM questions WHERE id = ?");
    $query->execute([$question_id]);
    $correct_option = $query->fetchColumn();

    if ($correct_option == $selected_option) {
        $correct_answers++;
    }
}

$score_percentage = ($correct_answers / $total_questions) * 100;
?>

<html>
<head>
    <title>Your Score</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Your Score</h1>
    <div class="alert alert-info mt-4">
        You answered <?= $correct_answers ?> out of <?= $total_questions ?> questions correctly.
        <br>Your score is: <strong><?= round($score_percentage, 2) ?>%</strong>
    </div>
    <a href="index.php" class="btn btn-primary">Take Another Quiz</a>
</div>
</body>
</html>
