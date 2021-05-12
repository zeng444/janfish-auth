### 认证

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
if ($auth->authorize($token) === false) {
    echo '失败';
    die();
}
print_r([
    $auth->getIdentity(),
    $auth->getExtendedData(),
]);
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