<?php
define('module_title', 'Sign up!');
?>

<div class="row-fluid marketing">
    <div class="span6">
        <h2 class="title">Let's play (soon)...</h2>
        <p>
            <?php
            if (array_key_exists('email', $_POST)) {
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $raw_email = $email;
                $passcode = $_POST['passcode'];
                if (empty($email) OR empty($passcode)) {
                    echo '<div class="alert alert-error">Please fill in all input areas!</div>';
                } elseif ($_POST['passcode'] != $_POST['cpasscode']) {
                    echo '<div class="alert alert-error">Passcodes do not match!</div>';
                } else {
                    $query = $db->prepare("INSERT INTO `users` (`email`,`password`) VALUES (?,?)");
                    $query->bind_param("ss", $email, $passcode);
                    $passcode = encryptpasscode($passcode);
                    $query->execute();
                    $query->store_result();
                    if ($query->affected_rows) {
                        $id = $query->insert_id;

                        /* Now insert user into users_stats */
                        $insert = $db->prepare("INSERT INTO `users_stats` (`uid`) VALUES (?)");
                        $insert->bind_param("i", $id);
                        $insert->execute();
                        /* Now, modify it, so it has data. :) */
                        $get_stats = $db->prepare("SELECT `stat_id`,`default_val` FROM `stats` ORDER BY `stat_id` ASC");
                        $get_stats->execute();
                        $get_stats->bind_result($sid, $value);
                        $get_stats->store_result();
                        while ($get_stats->fetch()) {
                            $qry = "UPDATE `users_stats` SET `stat_" . $sid . "`='{$value}' WHERE `uid`=$id";
                            $update = $db->prepare($qry);
                            $update->execute();
                        }
                            
                        /* Now, insert into users_equip */
                        $insert = $db->prepare("INSERT INTO `users_equip` (`uid`) VALUES (?)");
                        $insert->bind_param("i", $id);
                        $insert->execute();

                        $_SESSION['uid'] = $id;
                        $_SESSION['loggedin'] = 1;
                        ob_clean();
                        header('Location: home');
                        exit;
                    } else {
                        echo '<div class="alert alert-error">Something is wrong with our system, please try again later...</div>';
                    }
                }
            }
            ?>
        <div id="login">
            <form action="" method="POST" class="form-inline">
                <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                        <input type="text" name="email" autocomplete="off" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="passcode">Passcode</label>
                    <div class="controls">
                        <input type="password" name="passcode" autocomplete="off" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="cpasscode">Confirm</label>
                    <div class="controls">
                        <input type="password" name="cpasscode" autocomplete="off" />
                    </div>
                </div>                

                <p><input type="submit" value="Sign up" class="submit" /></p>

            </form>
        </div>
        </p>
    </div>
    <div class="span6">
        <h2 class="title">About</h2>
        <p><?php echo stripslashes(settings('game_description')); ?></p>
    </div>
    <div class="span6">
        <h2 class="title">Terms of Gaming</h2>
        <p><?php echo stripslashes(nl2br(settings('tos'))); ?></p>
    </div>
</div>