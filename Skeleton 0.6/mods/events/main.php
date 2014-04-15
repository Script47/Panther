<?php
/**
 * Events Module
 * Developed By: Script47
 */

updateAllEvents($_SESSION['uid']);

echo '<center><h3>Events</h3>';

$selectEvents = $db->query("SELECT * FROM `events` WHERE sendTo = {$_SESSION['uid']}");

echo '<table class="table">';

echo '<th>Details</th>';
echo '<th>Message</th>';
echo '<th>Actions</th>';

while($results = mysqli_fetch_assoc($selectEvents)) {
    $changeToName = $db->query("SELECT * FROM `users` WHERE `id` = {$results['SentFrom']}");
    $getName = mysqli_fetch_assoc($changeToName);
  
    echo '<tr><td>';
    echo '['.$results['SentFrom'].']'.$getName['char_name'].'<br/>'.date('d/m/Y g:i:s A', strtotime($results['SentOn']));
    echo '</td><td>';
    echo $results['Message'];
    echo '</td><td>';
    echo "<a href='events?eID={$results['ID']}&delete=true'>Delete Event</a>";
    echo '</td></tr>';
}

if(isset($_GET['delete'])) {
    $deleteEventID = htmlspecialchars(trim($_GET['eID']));
    $deleteMessage = $db->prepare("DELETE FROM `events` WHERE `ID` = ?");
    $deleteMessage->bind_param('i', $deleteEventID);
    
    if($deleteMessage->execute()) {
        exit(header("Location: events"));
    } else {
        echo '<div class="alert alert-error">Could not delete event, try again later.</div>'; 
        exit();
    }
    $deleteMessage->close();
}

echo '</table></center>';
