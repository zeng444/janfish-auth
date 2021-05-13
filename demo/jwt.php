<?php


use Janfish\Auth\Auth;


include dirname(__DIR__) . '/vendor/autoload.php';
include './MyIdentity.php';


$token = '1231231231';
$auth = Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'jwt',
    'setting' => [
        'alg' => 'HS256',
        'secret' => '54s5s5',
    ],

]);


$token = $auth->generateToken(1, ['name' => '白痴asads'], 100);
sleep(2);
try{
    if ($auth->authorize($token) === false) {
        echo '失败' . PHP_EOL;
        die();
    }
}catch (\Janfish\Auth\Exception\ExpiredException $e){
    echo '超时了' . PHP_EOL;
    die();
}catch (\Exception $e){
    echo '失败ma' . PHP_EOL;
    die();
}
print_r([
    $auth->getIdentity(),
    $auth->getExtendedData(),
]);