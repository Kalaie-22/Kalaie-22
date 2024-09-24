

<!---OMS--->
<!---PUBLIC--->
<!---db.php--->
<?php
$host = 'localhost';
$dbname = 'quiz';
$user = 'root';    
$pass = '';     

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>

<!---index.php--->
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

<!---quiz.php--->
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

<!---score.php--->
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

