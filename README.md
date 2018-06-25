Panther Skeleton 1.0
-

Panther is a lightweight game 'engine'(read: skeleton), to help programmers start
with something 'useful' for their text-based game adventure.

DO NOT USE THIS UNLESS TOLD OTHERWISE.

Quick Guide

- **How to create a module**
 * Go to mods/
 * Create a new folder for your module
 * Create the main.php page
 * Go to mods/home
 * Edit mods/home/menu.php

- **How to disable a module**
 * Go to mods/
 * Find the module to disable
 * Create disabled.panther in the module directory
 * Simply delete the disabled.panther file to enable it again

- **How to contribute to Panther Skeleton**
 * Fork it on GitHub (https://github.com/snikonet/PantherSkeleton)
 * Push the update to me
 * I'll review&pull it

- **How to update stats**
 * Adding 10 to users strength
    `$user->setStat($user->getStatId('str'), $user->getStat('str')+10);`
 * Subtracting 10 from users strength
    `$user->setStat($user->getStatId('str'), $user->getStat('str')-10);`
 * Setting users strength to 5
    `$user->setStat($user->getStatId('str'), 5);`

- **Updates**
 * Hacks have been added; just create an account, and you'll see it in the menu.

- **Author notes**

Please do not resell panther, as it is intended to be open source.
www.sniko.net 
