<?php
include_once('mods/globals.php');
/*
 * Allows a user to train their stats, cool.
 * -sniko
 * 
 * Additional SQL
 * 
 */
define('module_title', 'Upgrade your character');
?>

<?php
if($user->getStat('upgrade_points') <= 0) {
    echo '<div class="alert alert-error">You have no upgrade points</div>';
    return false;
}
if (array_key_exists('stat', $_GET)) {
    //See if we have enough upgrade points
    if ($user->getStat('upgrade_points') <= 0) {
        echo '<div class="alert alert-error">You don\'t have enough upgrade points!</div>';
    } else {
        $name = '';
        //See if stat is trainable  
        $stat_id = filter_input(INPUT_GET, 'stat', FILTER_SANITIZE_NUMBER_INT) ?: 0;
        $sql = "SELECT `stat_name` FROM `stats` WHERE ((`on_char_creator`=1) OR (`in_gym`=1)) AND `stat_id`=$stat_id";
        $get_stat = $db->prepare($sql);
        $get_stat->execute();
        $get_stat->store_result();
        if($get_stat->num_rows) {
            $user->setStat($stat_id, $user->getStat($user->getStatName($stat_id))+1);
            $user->setStat($user->getStatId('upgrade_points'), $user->getStat('upgrade_points')-1);
            echo '<div class="alert alert-success">You trained '. $user->getStatName($stat_id) .' successfully!</div>';
        } else {
            echo '<div class="alert alert-error">You cannot train this stat!</div>';
        }
        $get_stat->close();
    }
}
?>

<div class="pull-right">
    <span class="label label-success"><?php echo $user->getStat('upgrade_points'); ?> Upgrade points</span> 
</div>
<br /><br />
<table class="table table-bordered">
    <tr><th>Statistic</th>
        <th>Current Value</th>
        <th>Train</th>
    </tr>
    <?php
    //Get stats
    $sql = "SELECT `stat_id`,`stat_name`,`description` FROM `stats` WHERE (`on_char_creator`=1) OR (`in_gym`=1)";
    $get_stats = $db->prepare($sql);
    $get_stats->execute();
    $get_stats->bind_result($stat_id, $stat_name, $description);
    $get_stats->store_result();
    while ($get_stats->fetch()) {
        echo '<tr>  <td><a href="#" data-toggle="tooltip" data-original-title="'. stripslashes($description) .'" rel="tooltip">' . ucwords($stat_name) . '</a> </td> 
                    <td>' . number_format($user->getStat($stat_name),0) . '</td>
                    <td><a href="?stat=' . $stat_id . '">Train</a></td>
              </tr>';
    }
    ?>
</table>
<script type="text/javascript">
$('[rel=tooltip]').tooltip();
</script>


