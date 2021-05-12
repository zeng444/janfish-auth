<?php


use Janfish\Auth\Auth;


include dirname(__DIR__).'/vendor/autoload.php';
include './MyIdentity.php';


$token = '1231231231';
$auth = Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'jwt',
    'setting' => [
        'alg' => 'HS256',
        'secret' => '123123123',
    ],

]);


$token = $auth->generateToken(1, ['name' => '白痴asads']);

if ($auth->authorize($token) === false) {
    echo '失败';
    die();
}
print_r([
    $auth->getIdentity(),
    $auth->getExtendedData(),
]);
