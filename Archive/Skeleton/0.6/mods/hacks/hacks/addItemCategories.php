<?php
include_once('mods/globals.php');
mysqli_report(MYSQLI_REPORT_ALL);
if (array_key_exists('name', $_POST)) {
    $name = filter_input(INPUT_POST, 'name');
    $query = "INSERT INTO `items_categories` (`name`) VALUES (?)";
    $sql = $db->prepare($query);
    $sql->bind_param('s', $name);
    $sql->execute();
    $id = $sql->insert_id;
    $sql->close();
    unset($sql, $query);
    echo '<div class="alert alert-success">Category has been added</div>';
}
?>

<div class="alert alert-danger">No validation/verification will be done on the inputs - delete file after use</div>
<form action="" method="post">
    <table class="table">
        <tr><td>Category Name</td> <td><input type="text" name="name" /></td></tr>
        <tr><td colspan="2"><button type="submit">Add Category</button></td></tr>
    </table>
</form>
