<?php
require 'db.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);

        if ($stmt->execute()) {
            $message = "<p style='color:green;'>User <b>" . htmlspecialchars($username) . "</b> registered successfully! <a href='login.php'>Login here</a></p>";
        } else {
            $message = "<p style='color:red;'>Error: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color:red;'>Please fill in all fields.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>CAT2 Signup</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; display: flex; justify-content: center; padding-top: 50px; }
        .card { background: white; padding: 25px 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); width: 360px; }
        input { width: 100%; padding: 8px; margin: 6px 0 14px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #0078d4; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Student Sign Up</h2>
        <?= $message ?>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Register</button>
        </form>
        <p><a href="login.php">Already registered? Login</a> | <a href="feedback.php">Feedback</a></p>
    </div>
</body>
</html>