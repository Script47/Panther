Panther Skeleton 0.1
* This is free open source code
* Author www.sniko.net

Panther is a lightweight game 'engine', to help programmers start
with something 'useful' for their text-based game adventure.

If you'd like to support the development of this, please go here:
www.sniko.net/page/donate


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
* Push the update to your forked repository
* Send a pull request
* I'll review, and potentially accept your contribution, depending on if they work or not

- How to update stats
* Adding 10 to users strength
    $user->setStat($user->getStatId('str'), $user->getStat('str')+10);
* Subtracting 10 from users strength
    $user->setStat($user->getStatId('str'), $user->getStat('str')-10);
* Setting users strength to 5
    $user->setStat($user->getStatId('str'), 5);


- Author notes
Please do not resell panther, as it is intended to be open source.
www.sniko.net 