<?php
/**
 * Mailbox Module
 * Developed By: Script47
 */

function updateNewMail($id) {
    global $db;
    return $db->query("UPDATE `users` SET new_mail=new_mail+1 WHERE id=$id");
}

echo '<center><h3>Mailbox</h3>';

$userID = $_SESSION['uid'];

$updateNewMail = $db->query("UPDATE `users` SET new_mail=0 WHERE id=$userID");

$selectMail = $db->query("SELECT * FROM `mailbox` WHERE `SendTo` = $userID ORDER BY `SentOn` DESC");

echo '<a href="mailbox?newMessage=true">New Message</a><br/>';

if(isset($_GET['newMessage'])) {
    echo '<br/>';
    $selectUsers = $db->query("SELECT * FROM `users`");
    $getUsers = mysqli_fetch_assoc($selectUsers);
    
    echo '<br/>';
    echo '<form method="post">';
             ?>
            <select name="sendTo">
            <?php
            while($getUsers = mysqli_fetch_assoc($selectUsers)) {
                echo "<option value='{$getUsers['id']}'>".$getUsers['char_name']."</option>";
            }
            ?>
            </select><br/>
            <?php   
            echo '<input type="text" name="Subject" placeholder="Subject" title="Subject" spellcheck="true" autocomplete="off" required>
            <br/>
            <textarea rows="12" cols="45" style="resize: none; cursor: auto; width: auto;" name="Message" placeholder="Message" title="Message" spellcheck="true" autocomplete="off" required></textarea>
            <br/>
            <input type="Submit" name="sendNewMessage" value="Send Message">
          </form>';
            if(isset($_POST['sendNewMessage'])) {
                if($_POST['sendTo'] == $userID) {
                    echo "<div class='alert alert-error'>You can't send messages to yourself.</div>";
                } else if(!isset($_POST['Message']) || empty ($_POST['Message'])) {
                    echo '<div class="alert alert-error">You missed out the message field.</div>';                    
                } else {
                    $subject = htmlspecialchars(trim($_POST['Subject']));
                    $message = htmlspecialchars(trim($_POST['Message']));
                    $sendTo = htmlspecialchars(trim($_POST['sendTo']));
                    
                    $insertMessage = $db->prepare("INSERT INTO `mailbox` (SendTo, SentFrom, Subject, Message) VALUES (?, ?, ?, ?)");
                    $insertMessage->bind_param('iiss', $sendTo, $userID, $subject, $message);
                    
                    if($insertMessage->execute()) {
                        updateNewMail($sendTo);
                        echo '<div class="alert alert-success">Message sent.</div>';
                    } else {
                        echo '<div class="alert alert-error">Message could not be sent, please try again later.</div>';
                    }
                }
          }
}

echo '<table class="table">';

echo '<th>Details</th>';
echo '<th>Subject</th>';
echo '<th>Actions</th>';

while ($getMail = mysqli_fetch_assoc($selectMail)) {
    $changeIDToName = $db->query("SELECT * FROM `users` WHERE `id` = {$getMail['SentFrom']}");
    $getUsername = mysqli_fetch_assoc($changeIDToName);
    
    echo '<tr><td>';
    echo '['.$getMail['SentFrom'].']'.$getUsername['char_name'].'<br/>'.date('d/m/Y g:i:s A', strtotime($getMail['SentOn']));
    echo '<td>';
    echo stripslashes($getMail['Subject']);
    echo '<td>';
    echo "<a href='mailbox?mID={$getMail['ID']}&read=true'>Read Message</a><br/>";
    echo "<a href='mailbox?mID={$getMail['ID']}&delete=true'>Delete Message</a>";
    echo '</td></tr>';
}
echo '</table>';

if(isset($_GET['read'])) {
    $messageID = htmlspecialchars(trim($_GET['mID']));
    
    $selectMessageByID = $db->query("SELECT * FROM `mailbox` WHERE `ID` = $messageID");
    $selectSpecificMessage = mysqli_fetch_assoc($selectMessageByID);
    
    echo "<input style='resize: none; cursor: default; width: auto;' type='text' value='{$selectSpecificMessage['Subject']}' disabled /><br/>";
    echo '<textarea rows="12" cols="120" style="resize: none; cursor: default; width: auto;" disabled="true">'.$selectSpecificMessage['Message'].'</textarea><br/>';
    echo "<input style='resize: none; cursor: default; width: auto;' type='text' value='{$getUsername['char_name']}' disabled /><br/>";
    echo "<input style='resize: none; cursor: default; width: auto;' type='text' value='".date('d/m/Y g:i:s A', strtotime($selectSpecificMessage['SentOn']))."' disabled /><br/>";  
    echo "<a href='mailbox?sendTo={$selectSpecificMessage['SentFrom']}&replyMessage=true'>Reply to [".$selectSpecificMessage['SentFrom']."]".$getUsername['char_name']."</a>";
}

if(isset($_GET['replyMessage'])) {
    if(isset($_GET['sendTo'])) {
        $sendTo = htmlspecialchars(trim($_GET['sendTo']));
        echo '<form method="post">
                <input type="text" name="Subject" placeholder="Subject" title="Subject" spellcheck="true" autocomplete="off" required>
                <br/>
                <textarea rows="12" cols="45" style="resize: none; cursor: auto; width: auto;" name="Message" placeholder="Message" title="Message" spellcheck="true" autocomplete="off" required></textarea>
                <br/>
                <input type="Submit" name="sendReplyMessage" value="Reply">
              </form>';
        
        if(isset($_POST['sendReplyMessage'])) {
            if(!isset($_POST['Message']) || empty($_POST['Message'])) {
                echo '<div class="alert alert-error">You missed out the message field.</div>';
            } else {
                $subject = htmlspecialchars(trim($_POST['Subject']));
                $message = htmlspecialchars(trim($_POST['Message']));
                
                $insertReplyMessage = $db->prepare("INSERT INTO `mailbox` (SendTo, SentFrom, Subject, Message) VALUE (?, ?, ?, ?)");
                $insertReplyMessage->bind_param('iiss', $sendTo, $userID, $subject, $message);
                
                if($insertReplyMessage->execute()) {
                    updateNewMail($sendTo);
                    echo '<div class="alert alert-success">Message sent.</div>';
                } else {
                    echo '<div class="alert alert-error">Message could not be sent, please try again later.</div>';
                }
            }
        }
    }
}

if(isset($_GET['delete'])) {
    $deleteMessageID = htmlspecialchars(trim($_GET['mID']));
    $deleteMessage = $db->prepare("DELETE FROM `mailbox` WHERE `ID` = ?");
    $deleteMessage->bind_param('i', $deleteMessageID);
    
    if($deleteMessage->execute()) {
        exit(header("Location: mailbox"));
    } else {
        echo '<div class="alert alert-error">Could not delete message, try again later.</div>'; 
        exit();
    }
    $deleteMessage->close();
}
echo '</center>';