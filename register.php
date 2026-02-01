<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register for Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Register for Event</h1>
</header>
<form method="post">
    <label for="user_id">User ID:</label>
    <input type="text" name="user_id" required>

    <label for="participant_name">Your Name:</label>
    <input type="text" name="participant_name" required>

    <label for="event_id">Event ID:</label>
    <input type="text" name="event_id" value="<?php echo isset($_GET['event_id']) ? $_GET['event_id'] : ''; ?>" required>

    <input type="submit" name="register" value="Register">
</form>
<?php
if(isset($_POST['register'])){
    $user_id = $_POST['user_id'];
    $participant_name = $_POST['participant_name'];
    $event_id = $_POST['event_id'];

    // Validate user
    $user_check = $conn->query("SELECT full_name FROM Users WHERE user_id='$user_id'");
    if($user_check->num_rows > 0){
        $user = $user_check->fetch_assoc();
        if($user['full_name'] === $participant_name){
            // Validate event
            $event_check = $conn->query("SELECT * FROM Events WHERE event_id='$event_id'");
            if($event_check->num_rows > 0){
                $sql = "INSERT INTO Registrations (user_id, participant_name, event_id) 
                        VALUES ('$user_id','$participant_name','$event_id')";
                if($conn->query($sql) === TRUE){
                    echo "<div class='success-message'>✅ Registration successful!</div>";
                } else {
                    echo "<div class='error-message'>❌ Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='error-message'>⚠️ Event ID does not exist.</div>";
            }
        } else {
            echo "<div class='error-message'>⚠️ Name does not match the User ID.</div>";
        }
    } else {
        echo "<div class='error-message'>⚠️ User ID does not exist.</div>";
    }
}
?>
</body>
</html>
