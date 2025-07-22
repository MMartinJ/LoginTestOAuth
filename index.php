<?php
require __DIR__ . "/config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Google Login Example</title>
    </head>
    <body>

        <a href="<?= $url ?>">Sign in with Google</a>
    </body>
</html>