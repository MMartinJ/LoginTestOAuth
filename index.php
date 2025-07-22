<?php
session_start();

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/config.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$client = new Google\Client;

$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();
$url_logout = "./logout.php";
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Google Login Example</title>
    </head>
    <body>
<?php
if (isset($_SESSION['userid'])) {
    echo "<h1>Welcome, " . htmlspecialchars($_SESSION['name']) . "!</h1>";
    echo "<p>Email: " . htmlspecialchars($_SESSION['email']) . "</p>"; 
    echo "<p>User ID: " . htmlspecialchars($_SESSION['userid']) . "</p>";
    echo "<p><a href=" . $url_logout . ">Logout</a></p>";
} else {
    echo "<h1>Please log in with your Google account</h1>";         
        echo "<a href=" . $url . ">Sign in with Google</a>";
}
?>
    </body>
</html>