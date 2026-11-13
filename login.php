<?php
session_start();
require 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password"])) {
            $_SESSION["username"] = $row["username"];
            $message = "<p style='color:green;'>Login successful! Welcome, <b>" . htmlspecialchars($row["username"]) . "</b> (" . htmlspecialchars($row["email"]) . ").</p>";
        } else {
            $message = "<p style='color:red;'>Invalid password.</p>";
        }
    } else {
        $message = "<p style='color:red;'>User not found.</p>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CAT2 Login</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 25px 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 360px; }
        input { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #107c10; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Student Login</h2>
        <?= $message ?>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p><a href="signup.php">Create an account</a> | <a href="feedback.php">Feedback</a></p>
    </div>
</body>
</html>