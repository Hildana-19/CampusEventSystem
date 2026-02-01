<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Register to Campus Event System</h1>
</header>

<form method="post">
    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" id="full_name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="phone">Phone:</label>
    <input type="text" name="phone" id="phone" required>

    <label for="user_type">User Type:</label>
    <select name="user_type" id="user_type" required>
        <option value="">-- Select Type --</option>
        <option value="Student">Student</option>
        <option value="Staff">Staff</option>
        <option value="Outsider">Outsider</option>
    </select>

    <input type="submit" name="register_user" value="Register">
</form>

<?php
if(isset($_POST['register_user'])){
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $user_type = $_POST['user_type'];

    // Validate email uniqueness
    $check = $conn->query("SELECT * FROM Users WHERE email='$email'");
    if($check->num_rows > 0){
        echo "<div class='error-message'>⚠️ Email already registered. Please use another.</div>";
    } else {
        $sql = "INSERT INTO Users (full_name,email,phone,user_type)
                VALUES ('$full_name','$email','$phone','$user_type')";
        if($conn->query($sql) === TRUE){
            echo "<div class='success-message'>✅ User registered successfully! Redirecting to homepage...</div>";
            echo "<meta http-equiv='refresh' content='3;url=index.php'>";
        } else {
            echo "<div class='error-message'>❌ Error: " . $conn->error . "</div>";
        }
    }
}
?>
</body>
</html>
