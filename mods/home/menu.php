<?php

if(isset($_SESSION['uid']) && isset($_SESSION['loggedin'])) {
    echo '<li><a href="home">Home</a></li>';
    
    $userID = $_SESSION['uid'];
    $selectNewNotifications = $db->query("SELECT * FROM `users` WHERE id=$userID");
    $getNewNotifications = mysqli_fetch_assoc($selectNewNotifications);

    if($getNewNotifications['new_events'] > 0) {
        echo '<li><a href="events"><b>Events ('.$getNewNotifications['new_events'].')</b></a></li>';
    } else {
        echo '<li><a href="events">Events (0)</a></li>';
    }
    
    if($getNewNotifications['new_mail'] > 0) {
        echo '<li><a href="mailbox"><b>Mailbox ('.$getNewNotifications['new_mail'].')</b></a></li>';
    } else {
        echo '<li><a href="mailbox">Mailbox (0)</a></li>';
    }
    
    echo '<li><a href="gym">Gym</a></li>';
    echo '<li><a href="guessthenumber">Guess The Number</a></li>';
    echo '<li><a href="hacks">Hacks</a></li>';
    echo '<li><a href="logout">Logout</a></li>';
}
?>