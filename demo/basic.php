<?php


use Janfish\Auth\Auth;


include dirname(__DIR__).'/vendor/autoload.php';
include './MyIdentity.php';


$token = '1231231231';
$auth = Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'basic',
]);


$token = $auth->generateToken('zeng444', 'password');

if ($auth->authorize($token) === false) {
    echo '失败';
    die();
}
print_r([
    $auth->getIdentity(),
    $auth->getExtendedData(),
]);
