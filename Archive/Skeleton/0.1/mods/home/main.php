<?php
include_once('mods/globals.php');
/*
 * The page you go to when you login
 * The page to see if you have created your character
 * Displays general information on your character :)
 */
?>

<h4>My Home</h4>
<table class="table table-condensed">
    <tr> <th>&nbsp;</th> <td><img src='<?php echo $user->getStat('avatar'); ?>' alt='Avatar' width='50px' height='50px' /></td> </tr>
    <tr> <th>Character Name</th> <td><?php echo $user->getStat('char_name'); ?></td> </tr>
    <tr> <th>Health</th> <td><?php echo $user->getStat('hp'); ?></td> </tr>
    <tr> <th>Strength</th> <td><?php echo $user->getStat('str'); ?></td> </tr>
    <tr> <th>Defence</th> <td><?php echo $user->getStat('def'); ?></td> </tr>
    <tr> <th>Luck</th> <td><?php echo $user->getStat('luck'); ?></td> </tr>
</table>
