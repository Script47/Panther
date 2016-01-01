<?php
include_once('mods/globals.php');

if(array_key_exists('hack', $_GET)) {
    switch($_GET['hack']) {
        case 'addStat' : include_once('mods/hacks/hacks/addStat.php'); break;
        case 'addItemCategory' : include_once('mods/hacks/hacks/addItemCategories.php'); break;
        case 'addItem' : include_once('mods/hacks/hacks/addItem.php'); break;
        default: choose_hack(); break;
    } 
} else {
    choose_hack();
    return;
}

function choose_hack() {
    echo '<table class="table">
            <tr>
               <td><a href="?hack=addStat">Add Stat</a></td> <td>Allows you to add stats</td>
            </tr>
            <tr>
               <td><a href="?hack=addItemCategory">Add Item Category</a></td> <td>Allows you to add item categories</td>
            </tr>  
            <tr>
               <td><a href="?hack=addItem">Add Item</a></td> <td>Allows you to add items</td>
            </tr>                
          </table>';
}
?>