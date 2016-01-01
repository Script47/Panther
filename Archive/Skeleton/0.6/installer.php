<?php

/*
    Panther Installer
 */

require_once('config/config.php');

$db_error = true;

// Make sure the connection is alive...

if ($db->ping()) {
    $db_error = false;
}

$ready = true;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sql = file_get_contents('db.sql'); //Get the contents of db.sql.

    if ($db->multi_query($sql)) {

        header("Location: installer.php?installed=");
        exit;

    } else {

        echo $db->error; //Show the error, if failed.

    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panther Installer</title>

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>

    <style>

        body {
            background: #108a93;
            font-family: 'Open Sans', sans-serif;
            color: #333333;
            font-weight: 300;
        }

        .container {
            max-width: 960px;
        }

        #installer {
            margin: 0 auto;
            background: #ffffff;
            padding: 10px;
        }


    </style>

    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div id="installer" class="container">
        <h1>Panther Installer</h1>

        <?php if (isset($_GET['installed'])): ?>
            <div class="alert alert-success">
                Installation successful! <a href="index">Visit your game!</a>
            </div>
        <?php else: ?>

        <?php if ($db_error): ?>
            <div class="alert alert-warning">
                Could not connect to database. Have you configured yet?
            </div>
        <?php endif; ?>

        <p class="lead">Hello and welcome to Panther Installer.</p>

        <h2>Instructions</h2>

        <ol>
            <li>Create a database (or use a existing one)</li>
            <li>Configure config/config.php. You need to set up the database settings accordingly.</li>
            <li>Click the button 'Install'</li>
        </ol>

        <?php if ($ready): ?>
            <div class="alert alert-success">
                You are ready to begin the installation...
            </div>
        <?php endif; ?>

        <form method="post" action="installer.php">
            <button type="submit" class="btn btn-default">Install</button>
        </form>

        <p>That's it!</p>

        <?php endif; ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
  </body>
</html>
