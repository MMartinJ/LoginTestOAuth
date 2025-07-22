<?php
session_start();

require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/config.php";

$client = new Google\Client;
 
$client->setClientId($config['client_id']);
$client->setClientSecret($config['client_secret']);
$client->setRedirectUri($config['redirect_uri']);




if (! isset($_GET['code'])) {
    // If we don't have an authorization code, redirect the user to Google's OAuth 2.0 server
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
    exit;
} else {
    // If we have an authorization code, exchange it for an access token
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    
    // Set the access token on the client
    $client->setAccessToken($token);
    
    // Get user info
    $oauth2 = new Google\Service\Oauth2($client);
    $userInfo = $oauth2->userinfo->get();

    // ✅ Guardar en sesión
    $_SESSION['userid'] = $userInfo->id;
    $_SESSION['name'] = $userInfo->name;
    $_SESSION['email'] = $userInfo->email;

    // 🔁 Redirigir al index (o página segura)
    header('Location: index.php');
    exit;
    
    //echo 'User ID: ' . htmlspecialchars($userInfo->id) . '<br>';
    //echo 'Name: ' . htmlspecialchars($userInfo->name) . '<br>';
    //echo 'Email: ' . htmlspecialchars($userInfo->email) . '<br>';
}

?>