<h3>Welcome...</h3>
<div class="row-fluid marketing">
    <div class="span6">
        <h4>Let's play...</h4>
        <p>
            <?php
            if (array_key_exists('email', $_POST)) {
                //Sort out the bind params
                $id = '';
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $email = encryptpasscode($email);
                $passcode = encryptpasscode($_POST['passcode']); 
                //Do the database talking
                $query = $db->prepare("SELECT `id` FROM `users` WHERE ((`email`=?) AND (`password`=?))");
                $query->bind_param("ss", $email, $passcode);                
                $query->execute();
                $query->bind_result($id);
                $query->store_result();
                if ($query->num_rows) {
                    $query->fetch();
                    $_SESSION['uid'] = $id;
                    $_SESSION['loggedin'] = 1;
                    ob_clean();
                    header('Location: home');
                    exit;
                } else {
                    echo '<div class="alert alert-error">Incorrect details...</div>';
                }
            }
            ?>
        <form action="" method="POST">
            <label>Email</label><input type="text" name="email" /> <br />
            <label>Passcode</label><input type="password" name="passcode" /> <br />
            <button type="submit" class="btn btn-primary">Play</button>
        </form>
        </p>
    </div>
    <div class="span6">
        <h4>About</h4>
        <p><?php echo stripslashes(settings('game_description')); ?></p>
    </div>
    <div class="span6">
        <h4>Statistics</h4>
        <p>1 members online.</p>
    </div>
</div>
