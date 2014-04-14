#### Panther Skeleton 0.5
* This is free open source code
* Author www.sniko.net

Panther is a lightweight game 'engine', to help programmers start
with something 'useful' for their text-based game adventure.

If you'd like to support the development of this, please go here:
www.sniko.net/page/donate

Installing Panther

* Download the code https://github.com/harrydenley/PantherSkeleton/archive/master.zip
* Open the .zip and you will see a bunch of different directories, these contain different versions of Panther. Extract the contents of the version you would like to use to your web root.
* Create a database and import the dbdata.sql file.
* Open config/config.php file and change database details accordingly.
* Open your web browser and visit your freshly installed Panther!

Quick Guide

- How to create a module
* Go to mods/
* Create a new folder for your module
* Create the main.php page
* Go to mods/home
* Edit mods/home/menu.php

- How to disable a module
* Go to mods/
* Find the module to disable
* Create disabled.panther in the module directory
* Simply delete the disabled.panther file to enable it again

- How to contribute to Panther Skeleton
* Fork it on GitHub (https://github.com/snikonet/PantherSkeleton)
* Push the update to me
* I'll review&pull it

- How to update stats
* Adding 10 to users strength
    $user->setStat($user->getStatId('str'), $user->getStat('str')+10);
* Subtracting 10 from users strength
    $user->setStat($user->getStatId('str'), $user->getStat('str')-10);
* Setting users strength to 5
    $user->setStat($user->getStatId('str'), 5);

#### Panther Skeleton 0.6

 * Released by Script47.
 * Scheduled for official testing :) - sniko.

#### Author notes

Please do not resell panther, as it is intended to be open source.
www.sniko.net 
