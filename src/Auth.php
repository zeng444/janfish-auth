<?php

namespace Janfish\Auth;


/**
 * Author:Robert
 *
 * Class Auth
 * @package Janfish\Auth
 * @property $_instance AuthInterface
 * @property $_authResult AuthResult
 */
class Auth
{

    private static $_self;
    private $_type;


    private $_instance;

    private $_identityClass;

    private $_authResult;

    const JWT_TYPE = 'jwt';
    const BASIC_TYPE = 'basic';

    const AUTH_ALG_CLASS_MAP = [
        self::JWT_TYPE => \Janfish\Auth\Token\Jwt::class,
        self::BASIC_TYPE => \Janfish\Auth\Token\Basic::class,
    ];

    /**
     * Author:Robert
     *
     * @param array $options
     * @return Auth
     * @throws \Exception
     */
    public static function getInstance(array $options)
    {
        if (!self::$_self) {
            self::$_self = new self($options);
        }
        return self::$_self;
    }

    /**
     * Auth constructor.
     * @param array $options
     * @throws \Exception
     */
    public function __construct(array $options)
    {
        if (!isset($options['type']) || !in_array($options['type'], array_keys(self::AUTH_ALG_CLASS_MAP))) {
            throw new \Exception('不存在的认证算法');
        }
        if (!isset($options['class'])) {
            throw new \Exception('验证对象不存在');
        }
        $this->_identityClass = $options['class'];
        $this->_type = $options['type'];
        $model = self::AUTH_ALG_CLASS_MAP[$this->_type];
        $this->_instance = new $model();
        $this->_instance->setOptions($options['setting'] ?? []);
    }

    /**
     * Author:Robert
     *
     * @param string $token
     * @return bool
     * @throws \Exception
     */
    public function authorize(string $token): bool
    {
        $identityModel = $this->_identityClass;
        $identityModel = new $identityModel();
        if (!$identityModel instanceof IdentityInterface) {
            throw new \Exception('认证未实现');
        }
        $playLoad = $this->_instance->parseToken($token);
        if (!$playLoad) {
            return false;
        }
        $this->_authResult = $identityModel->login($playLoad, $this->_type);
        return $this->_authResult->isIdentity();
    }

    /**
     * Author:Robert
     *
     * @param $id
     * @param $extends
     * @return string
     */
    public function generateToken($id, $extends): string
    {
        return $this->_instance->generateToken([
            'id' => $id,
            'ext' => $extends,
        ]);
    }

    /**
     * Author:Robert
     *
     * @return int|null
     */
    public function getIdentity(): ?string
    {
        if (!$this->_authResult->isIdentity()) {
            return null;
        }
        return $this->_authResult->getIdentity();
    }

    /**
     * Author:Robert
     *
     * @return array
     */
    public function getExtendedData()
    {
        if (!$this->_authResult->isIdentity()) {
            return [];
        }
        return $this->_authResult->getExtendedData();
    }

}
