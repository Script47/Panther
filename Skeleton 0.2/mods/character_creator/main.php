<?php
include_once('mods/globals.php');
/*
 * Create your character. Genuis invention, right?
 */
if (character_is_set_up($_SESSION['uid'])) {
    ob_clean();
    header('Location: home');
    exit;
}
?>

<h4>Character Creator</h4>

<?php
if (array_key_exists('char_name', $_POST)) {

    $charname = filter_input(INPUT_POST, 'char_name', FILTER_SANITIZE_STRING, 'UTF-8');
    $avatar = file_exists($_POST['avatar']) && getimagesize($_POST['avatar']) ? $_POST['avatar'] : 'public/avatars/avatar-1.jpg';

    if (strlen(trim($charname)) <= 3) {
        echo '<div class="alert alert-error">Please make your character name more than 2 characters in length</div>';
    } else {
        global $db;
        //Do the database talking
        $query = $db->prepare("UPDATE `users` SET `char_name`=?,`avatar`=? WHERE (`id`=?)");
        if ($query) {
            $query->bind_param("ssi", $charname, $avatar, $_SESSION['uid']);
            $query->execute();
            $query->store_result();
            if ($query->affected_rows) {
                ob_clean();
                header('Location: home');
                exit;
            } else {
                echo '<div class="alert alert-error">Try again later... sorry</div>';
            }
        } else {
            echo '<div class="alert alert-error">Try again later...</div>';
        }
    }
}
?>
<form action="" method="POST">
    <label for='char_name'>Character Name</label> <input type="text" name="char_name" /> <br />
    <label for='avatar'>Avatar</label> <?php echo list_avatars('avatar'); ?> <br />
    <button type="submit" class="btn btn-primary">Create Character</button>
</form>
</p>

<?php

function list_avatars($name) {
    $return = null;
    foreach (glob("public/avatars/*.jpg") as $filename) {
        $return .= "<input type='radio' name='$name' value='$filename'><img src='$filename' alt='Avatar' height='50px' width='50px' /><br />\n";
    }
    return $return;
}
