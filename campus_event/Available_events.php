<?php 
include("db_connect.php"); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Available Events</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .event-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px;
        }
        .event-card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            width: 300px;
            margin: 15px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: left;
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .event-card:hover {
            transform: scale(1.03);
        }
        .event-title {
            font-size: 20px;
            font-weight: bold;
            color: #ff6600;
            margin-bottom: 10px;
        }
        .event-subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        .event-description {
            font-size: 15px;
            margin-bottom: 15px;
        }
        .event-organizer {
            font-size: 13px;
            color: #777;
            margin-bottom: 15px;
        }
        .register-btn {
            display: block;
            background: #ff6600;
            color: white;
            padding: 10px 12px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            text-decoration: none;
            transition: background 0.3s ease;
            margin-top: auto;
            width: 100%;
            box-sizing: border-box;
        }
        .register-btn:hover {
            background: #e65c00;
        }
    </style>
</head>
<body>
<header>
    <h1 class="available-events">Available Events</h1>
</header>

<div class="event-container">
<?php
$sql = "SELECT event_id, event_name, description, start_date, end_date, organizer_name 
        FROM Events 
        WHERE end_date >= NOW() 
        ORDER BY start_date ASC";
$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        ?>
        <div class="event-card">
            <div class="event-title"><?php echo htmlspecialchars($row['event_name']); ?></div>
            <div class="event-subtitle"><?php echo $row['start_date']." - ".$row['end_date']; ?></div>
            <div class="event-description"><?php echo htmlspecialchars($row['description']); ?></div>
            <div class="event-organizer">Organized by: <?php echo htmlspecialchars($row['organizer_name']); ?></div>
            <!-- Redirects to Register to System page -->
            <a href="user_register.php" class="register-btn">Register</a>
        </div>
        <?php
    }
} else {
    echo "<p>No available events at the moment.</p>";
}
?>
</div>
</body>
</html>
