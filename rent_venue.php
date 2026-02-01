<?php include("db_connect.php"); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Rent Venue</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Rent a Venue</h1>
</header>
<form method="post">
    <label for="renter_id">Renter ID:</label>
    <input type="text" name="renter_id" required>

    <label for="renter_name">Renter Name:</label>
    <input type="text" name="renter_name" required>

    <label for="venue_id">Select Venue:</label>
    <select name="venue_id" required>
        <?php
        $venues = $conn->query("SELECT venue_id, venue_name FROM Venues");
        while($row = $venues->fetch_assoc()){
            echo "<option value='".$row['venue_id']."'>".$row['venue_name']."</option>";
        }
        ?>
    </select>

    <label for="rental_date">Rental Date:</label>
    <input type="datetime-local" name="rental_date" required>

    <label for="purpose">Purpose:</label>
    <input type="text" name="purpose" required>

    <input type="submit" name="rent" value="Rent Venue">
</form>
<?php
if(isset($_POST['rent'])){
    $renter_id = $_POST['renter_id'];
    $renter_name = $_POST['renter_name'];
    $venue_id = $_POST['venue_id'];
    $rental_date = $_POST['rental_date'];
    $purpose = $_POST['purpose'];

    // Validate renter
    $user_check = $conn->query("SELECT full_name FROM Users WHERE user_id='$renter_id'");
    if($user_check->num_rows > 0){
        $user = $user_check->fetch_assoc();
        if($user['full_name'] === $renter_name){
            // Validate venue
            $venue_check = $conn->query("SELECT * FROM Venues WHERE venue_id='$venue_id'");
            if($venue_check->num_rows > 0){
                $sql = "INSERT INTO Rentals (renter_id, renter_name, venue_id, rental_date, purpose)
                        VALUES ('$renter_id','$renter_name','$venue_id','$rental_date','$purpose')";
                if($conn->query($sql) === TRUE){
                    echo "<div class='success-message'>✅ Venue rented successfully!</div>";
                } else {
                    echo "<div class='error-message'>❌ Error: " . $conn->error . "</div>";
                }
            } else {
                echo "<div class='error-message'>⚠️ Venue ID does not exist.</div>";
            }
        } else {
            echo "<div class='error-message'>⚠️ Renter name does not match the ID.</div>";
        }
    } else {
        echo "<div class='error-message'>⚠️ Renter ID does not exist.</div>";
    }
}
?>
</body>
</html>
