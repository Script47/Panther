<?php
include_once('mods/globals.php');
mysqli_report(MYSQLI_REPORT_ALL);
if (array_key_exists('name', $_POST)) {
    $name = filter_input(INPUT_POST, 'name');
    $desc = filter_input(INPUT_POST, 'desc');
    $category = filter_input(INPUT_POST, 'category');
    $sellprice = filter_input(INPUT_POST, 'sell_price');
    $buy_price = filter_input(INPUT_POST, 'buy_price');
    $slot = filter_input(INPUT_POST, 'slot');
    $query = "INSERT INTO `items` (`name`,`category`,`description`,`buy_price`,`sell_price`,`equip_slot`) VALUES (?,?,?,?,?,?)";
    $sql = $db->prepare($query);
    $sql->bind_param('sisiis', $name, $category, $desc, $buy_price, $sellprice, $slot);
    $sql->execute();
    $id = $sql->insert_id;
    $sql->close();
    unset($sql, $query);
    echo '<div class="alert alert-success">Item has been added</div>';
}
?>

<div class="alert alert-danger">No validation/verification will be done on the inputs - delete file after use</div>
<form action="" method="post">
    <table class="table">
        <tr><td>Item Name</td> <td><input type="text" name="name" /></td></tr>
        <tr><td>Category</td> <td><?php echo category_dropdown(); ?></td></tr>
        <tr><td>Description</td> <td><input type="text" name="desc" /></td></tr>
        <tr><td>Buy Price</td> <td><input type="text" name="buy_price" /></td></tr>
        <tr><td>Sell Price</td> <td><input type="text" name="sell_price" /></td></tr>
        <tr><td>Equip Slot</td> <td><?php echo equipslot_dropdown(); ?></td></tr>
        <tr><td colspan="2"><button type="submit">Add Item</button></td></tr>
    </table>
</form>

<?php
function category_dropdown() {
global $db;
    $return = "<select name='category'>";
    $query = "SELECT `category_id`,`name` FROM `items_categories`";
    $sql = $db->prepare($query);
    $sql->execute();
    while($sql->fetch()) {
        $sql->bind_result($id,$name);
        $return .= "<option value='{$id}'>{$name}</option>";
    }
    $return .= "</select>";
    return $return;
}

function equipslot_dropdown() {
global $db;
    $return = "<select name='slot'>";
    $array = array('head','weapon','shield','torso','legs','boots');
    foreach($array as $slot) {
        $return .= "<option value='{$slot}'>{$slot}</option>";
    }
    $return .= "</select>";
    return $return;    
}
?>