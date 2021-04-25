  
<?php


ini_set("display_errors", 1);

require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

//including headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

const EXAMPLE_JWT_SECRET_KEY = "owt125";
const EXAMPLE_JWT_ENCODE_ALG = 'HS512';

$headers = getallheaders();

$jwtString = $headers["Authorization"];
try
{
    // Add leeway to avoid errors on clock skew.
    // See https://stackoverflow.com/questions/40411014/
    if (property_exists(JWT::class, 'leeway')) {
        JWT::$leeway = max(JWT::$leeway, 60);
    }

    $token = JWT::decode($jwtString, EXAMPLE_JWT_SECRET_KEY, [EXAMPLE_JWT_ENCODE_ALG]);
    $email = isset($token->data->email) ? $token->data->email : '';
    echo "User with email ".$email." is trying to logout!";
}
catch (Exception $e)
{
    // If that user doesn't exist, send a 401 Error
    header('HTTP/1.0 401 Unauthorized');
    exit(0);
}