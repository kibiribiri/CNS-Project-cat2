<?php
require 'db.php';
$status = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $student_name = trim($_POST["student_name"]);
    $topic        = trim($_POST["topic"]);
    $comments     = trim($_POST["comments"]);

    if (!empty($student_name) && !empty($topic) && !empty($comments)) {
        $stmt = $conn->prepare("INSERT INTO feedback (student_name, topic, comments) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $student_name, $topic, $comments);
        if ($stmt->execute()) {
            $status = "<p style='color:green;'>Feedback submitted successfully!</p>";
        } else {
            $status = "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    }
}

$result = $conn->query("SELECT id, student_name, topic, comments, submitted_at FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 30px; }
        .container { max-width: 750px; margin: auto; background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        input, textarea { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        button { padding: 10px 20px; background: #0078d4; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #0078d4; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Course Feedback Form (POST & Retrieve)</h2>
        <?= $status ?>
        <form method="POST" action="">
            <label>Student Name:</label>
            <input type="text" name="student_name" required>
            <label>Topic:</label>
            <input type="text" name="topic" required>
            <label>Comments:</label>
            <textarea name="comments" rows="3" required></textarea>
            <button type="submit">Submit Feedback</button>
        </form>

        <h3>Saved Records from CAT2.feedback</h3>
        <table>
            <tr>
                <th>ID</th><th>Student Name</th><th>Topic</th><th>Comments</th><th>Submitted At</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row["id"] ?></td>
                <td><?= htmlspecialchars($row["student_name"]) ?></td>
                <td><?= htmlspecialchars($row["topic"]) ?></td>
                <td><?= htmlspecialchars($row["comments"]) ?></td>
                <td><?= $row["submitted_at"] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <p><a href="index.php">Back to Home</a></p>
    </div>
</body>
</html>
