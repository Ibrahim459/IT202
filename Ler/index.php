<!doctype html>
<html lang="en">
<head>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require("bootstrap.php");
?>
</head>
    <body>
        <div class="container-fluid">
        <header>
            <nav>
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?home">Home</a>
                    </li>
                    <?php if(!Utils::isLoggedIn()):?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?register">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?story/create">Create Story</a>
                    </li>
                    <?php endif; ?>
                    <?php if(Utils::isLoggedIn()):?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?logout">Logout</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </header>
        <?php
        //uses the first key of $_GET to lookup a route and load a template
        include("routes.php");
        //Keep this at the bottom of the page so we fill the variable from templates and display it in the same request
        //otherwise flashes will only show on future page reloads
        include("flash.php");
        ?>
        </div>
    </body>
</html>