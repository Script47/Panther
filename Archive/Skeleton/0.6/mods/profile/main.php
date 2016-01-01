<?php
include "mods/globals.php";

$user_exists = TRUE;
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ? : 0;
$exists = "SELECT `id` FROM `users` WHERE `id`=?";
$do = $db->prepare($exists);
if ($do) {
    $do->bind_param('i', $id);
    $do->execute();
    $do->store_result();
    if (!$do->num_rows) {
        $user_exists = FALSE;
    }
}

if (!$user_exists) {
    $id = $_SESSION['uid'];
}

$user = new \user_class($id);

if (!$user->getStat('char_name')) {
    define('module_title', 'Profile');
    echo '<div class="alert alert-error">Their character is not set up, yet!</div>';
    return;
}

define('module_title', $user->getStat('char_name'));
?>

<div class="pull-left">
    <h6>Statistics</h6>
    <small>Level:</small> <?php echo $user->getLevel(); ?><br />
    <?php
    //Get stats
    $sql = "SELECT `stat_name`,`description` FROM `stats` WHERE (`on_char_creator`=1) OR (`in_gym`=1)";
    $get_stats = $db->prepare($sql);
    $get_stats->execute();
    $get_stats->bind_result($stat_name, $description);
    $get_stats->store_result();
    while ($get_stats->fetch()) {
        echo '<small><a href="#" data-toggle="tooltip" data-original-title="' . stripslashes($description) . '" rel="tooltip">' . ucwords($stat_name) . '</a> 
                         ' . number_format($user->getStat($stat_name), 0) . '</small><br />';
    }
    ?>
    <br />
</div>
<div class="pull-right">
    <?php
    $item = new item_class();
    ?>
            <p style="text-align:center;">&middot; Attack &middot; Message &middot;</p> <br />
            <strong>Head</strong> <?php echo ($item->getName($user->getEquipSlot('head')) ?: 'Nothing'); ?> <br />
            <strong>Torso</strong> <?php echo ($item->getName($user->getEquipSlot('torso')) ?: 'Nothing'); ?> <br />
            <strong>Weapon</strong> <?php echo ($item->getName($user->getEquipSlot('weapon')) ?: 'Nothing'); ?> <br />
            <strong>Shield</strong> <?php echo ($item->getName($user->getEquipSlot('shield')) ?: 'Nothing'); ?> <br /> 
            <strong>Legs</strong> <?php echo ($item->getName($user->getEquipSlot('legs')) ?: 'Nothing'); ?> <br /> 
            <strong>Boots</strong> <?php echo ($item->getName($user->getEquipSlot('boots')) ?: 'Nothing'); ?>  <br />
</div>
<script type="text/javascript">
    $('[rel=tooltip]').tooltip();
</script>
