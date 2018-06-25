<?php
/**
 * 50/50 Module
 * Developed By: Script47
 */

include_once('mods/globals.php');

echo '<center>';

echo '<h3>Guess The Number</h3>';

echo "<p>Guess a number between 1-100, if you get it right, you will get the amount it was, if you don't you'll lose the amount it was.</p>";

echo "<b>Your Money: ".money_formatter($user->getMoney($_SESSION['uid']))."</b><br/>";

echo '<br/><form method="post">
        <input type="number" name="guess" maxlength="2" placeholder="Guess a number between 1-100" title="Your Guess" autofocus required>
        <br/>
        <input type="submit" name="play" value="Guess">
     </form>';

if(isset($_POST['play'])) {
    $guess = htmlspecialchars(trim($_POST['guess']));
    
    if(!isset($guess) || empty($guess)) {
        errorMessage("Guess field can't be empty.");
    } else if(!ctype_digit($guess) || $guess < 1 || $guess > 100) {
        errorMessage("Guess has to be an integer between 1-100.");
        exit();
    } else if($user->getMoney($_SESSION['uid']) <= 0) {
        errorMessage("You don't have enough money to play.");
    } else {
        $randomNumber = rand(1, 100);
        
        if($guess == $randomNumber) {
            $user->addMoney($randomNumber, $_SESSION['uid']);
            successMessage("You got it! You won ".money_formatter($randomNumber)."");
        } else if($guess != $randomNumber) {
            $user->minusMoney($randomNumber, $_SESSION['uid']);
            errorMessage("Sorry, you guessed wrong! You lost ".money_formatter($randomNumber).".");
        }
    }
}

echo '</center>';
