### 认证

```
$auth = Auth::getInstance([
    'class' => MyIdentity::class,
    'type' => 'jwt',
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