### 认证组件

#### JWT

```
$auth = Janfish\Auth\Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'jwt',
    'setting' => [
        'alg' => 'HS256',
        'secret' => '123123123',
     ],
]);
$token = $auth->generateToken(1, ['name' => 'username']);

try{
    if ($auth->authorize($token) === false) {
        echo '失败';
        die();
    }
    print_r([
        $auth->getIdentity(),
        $auth->getExtendedData(),
    ]);
}catch (\Janfish\Auth\Exception\ExpiredException $e){
     echo '超时了' . PHP_EOL;
     die();
}catch (\Exception $e){
     echo '失败ma' . PHP_EOL;
     die();
}


```

#### Basic

```
$auth = Janfish\Auth\Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'basic'
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
```


#### Reset

```
$auth = Janfish\Auth\Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'basic'
]);
$auth->reset();
```