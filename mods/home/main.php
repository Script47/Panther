<?php
include_once('mods/globals.php');
/*
 * The page you go to when you login
 * The page to see if you have created your character
 * Displays general information on your character :)
 */
$upgradeButton = ($user->getStat('upgrade_points') > 0) ? '<a href="gym" class="btn">Upgrade</a>' : '&nbsp;';
?>

<h4>My Home</h4>
<table class="table table-condensed">
    <tr> <th><?php echo $upgradeButton; ?></th> <td><img src='<?php echo $user->getStat('avatar'); ?>' alt='Avatar' width='50px' height='50px' /></td> </tr>
    <tr> <th>Character Name</th> <td><a href="profile"><?php echo $user->getStat('char_name'); ?></a></td> </tr>
    <tr> <th>Level</th> <td><?php echo $user->getLevel(); ?></td> </tr>
    <tr> <th>Money</th> <td><?php echo money_formatter($user->getMoney($_SESSION['uid'])); ?></td> </tr>
<?php
//Get stats
    $sql = "SELECT `stat_name`,`description` FROM `stats` WHERE (`on_char_creator`=1) OR (`in_gym`=1)";
    $get_stats = $db->prepare($sql);
    $get_stats->execute();
    $get_stats->bind_result($stat_name, $description);
    $get_stats->store_result();
    while ($get_stats->fetch()) {
        echo '<tr>  <td><a href="#" data-toggle="tooltip" data-original-title="'. stripslashes($description) .'" rel="tooltip">' . ucwords($stat_name) . '</a> </td> 
                    <td>' . number_format($user->getStat($stat_name),0) . '</td>
              </tr>';
    }
echo '</table>';    
?>
<script type="text/javascript">
$('[rel=tooltip]').tooltip();
</script>
