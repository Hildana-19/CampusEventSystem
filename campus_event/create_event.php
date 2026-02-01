<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Create a New Event</h1>
</header>
<form method="post">
    <label for="event_name">Event Name:</label>
    <input type="text" name="event_name" required>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea>

    <label for="start_date">Start Date:</label>
    <input type="datetime-local" name="start_date" required>

    <label for="end_date">End Date:</label>
    <input type="datetime-local" name="end_date" required>

    <label for="organizer_id">Organizer:</label>
    <select name="organizer_id" required>
        <?php
        $users = $conn->query("SELECT user_id, full_name FROM Users WHERE user_type='Organizer'");
        while($row = $users->fetch_assoc()){
            echo "<option value='".$row['user_id']."'>".$row['full_name']."</option>";
        }
        ?>
    </select>

    <label for="venue_id">Venue:</label>
    <select name="venue_id" required>
        <?php
        $venues = $conn->query("SELECT venue_id, venue_name, capacity FROM Venues");
        while($row = $venues->fetch_assoc()){
            echo "<option value='".$row['venue_id']."'>".$row['venue_name']." (Capacity: ".$row['capacity'].")</option>";
        }
        ?>
    </select>

    <input type="submit" name="create" value="Create Event">
</form>
<?php
if(isset($_POST['create'])){
    $event_name = $_POST['event_name'];
    $description = $_POST['description'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $organizer_id = $_POST['organizer_id'];
    $venue_id = $_POST['venue_id'];

    // Get organizer name
    $org = $conn->query("SELECT full_name FROM Users WHERE user_id='$organizer_id'")->fetch_assoc();
    $organizer_name = $org['full_name'];

    $sql = "INSERT INTO Events (event_name, description, start_date, end_date, organizer_id, organizer_name, venue_id)
            VALUES ('$event_name','$description','$start_date','$end_date','$organizer_id','$organizer_name','$venue_id')";
    if($conn->query($sql) === TRUE){
        echo "<div class='success-message'>✅ Event created successfully!</div>";
    } else {
        echo "<div class='error-message'>❌ Error: " . $conn->error . "</div>";
    }
}
?>
</body>
</html>
