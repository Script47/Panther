<?php

if(isset($_SESSION['uid']) && isset($_SESSION['loggedin'])) {
    echo '<li><a href="home">Home</a></li>';
    
    $userID = $_SESSION['uid'];
    $selectNewMail = $db->query("SELECT * FROM `users` WHERE id=$userID");
    $getNewMail = mysqli_fetch_assoc($selectNewMail);

    if($getNewMail['new_mail'] > 0) {
        echo '<li><a href="mailbox"><b>Mailbox ('.$getNewMail['new_mail'].')</b></a></li>';
    } else {
        echo '<li><a href="mailbox">Mailbox (0)</a></li>';
    }
    echo '<li><a href="hacks">Hacks</a></li>';
    echo '<li><a href="logout">Logout</a></li>';
}
?>