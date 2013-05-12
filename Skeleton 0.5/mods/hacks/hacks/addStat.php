<?php
include_once('mods/globals.php');
mysqli_report(MYSQLI_REPORT_ALL);
if (array_key_exists('stat_name', $_POST)) {
    $name = filter_input(INPUT_POST, 'stat_name');
    $desc = filter_input(INPUT_POST, 'desc');
    $default = filter_input(INPUT_POST, 'default_val');
    $onchar = (isset($_POST['on_char'])) ? 1 : 0;
    $ingym = (isset($_POST['in_gym'])) ? 1 : 0;
    $query = "INSERT INTO `stats` (`stat_name`,`description`,`default_val`,`on_char_creator`,`in_gym`) VALUES (?,?,?,?,?)";
    $sql = $db->prepare($query);
    $sql->bind_param('sssii', $name, $desc, $default, $onchar, $ingym);
    $sql->execute();
    $id = $sql->insert_id;
    $sql->close();
    unset($sql, $query);
    $query = "ALTER TABLE `users_stats` ADD `stat_" . $id . "` VARCHAR(10) NOT NULL DEFAULT " . $default;
    $sql = $db->prepare($query);
    $sql->execute();
    $sql->close();
    unset($sql, $query);
    echo '<div class="alert alert-success">Stat has been added</div>';
}
?>

<div class="alert alert-danger">No validation/verification will be done on the inputs - delete file after use</div>
<form action="" method="post">
    <table class="table">
        <tr><td>Stat Name</td> <td><input type="text" name="stat_name" /></td></tr>
        <tr><td>Description</td> <td><input type="text" name="desc" /></td></tr>
        <tr><td>Default Value</td> <td><input type="text" name="default_val" /></td></tr>
        <tr><td>On Char Creator</td> <td><input type="checkbox" name="on_char" /></td></tr>
        <tr><td>In Gym</td> <td><input type="checkbox" name="in_gym" /></td></tr>
        <tr><td colspan="2"><button type="submit">Add Stat</button></td></tr>
    </table>
</form>
