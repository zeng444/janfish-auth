<?php

namespace Janfish\Auth;

use Janfish\Auth\Exception\InvalidArgumentException;

/**
 * Author:Robert
 *
 * Class Auth
 * @package Janfish\Auth
 */
class Auth
{

    const JWT_TYPE = 'jwt';
    const BASIC_TYPE = 'basic';
    const AUTH_ALG_CLASS_MAP = [
        self::JWT_TYPE   => \Janfish\Auth\Token\Jwt::class,
        self::BASIC_TYPE => \Janfish\Auth\Token\Basic::class,
    ];
    /**
     * @var
     */
    private static $_self;

    /**
     * @var mixed
     */
    private $_type;
    /**
     * @var \Janfish\Auth\Token\TokenInterface
     */
    private $_instance;
    /**
     * @var \Janfish\Auth\IdentityInterface
     */
    private $_identityClass;
    /**
     * @var \Janfish\Auth\AuthResult
     */
    private $_authResult;

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
     * @param array $options
     * @return static
     * @throws \Exception
     * @author Robert
     */
    public static function getInstance(array $options): self
    {
        if (!self::$_self) {
            self::$_self = new self($options);
        }
        return self::$_self;
    }

    /**
     * @param string $token
     * @return bool
     * @throws InvalidArgumentException
     */
    public function authorize(string $token): bool
    {
        $identityModel = $this->_identityClass;
        $identityModel = new $identityModel();
        if (!$identityModel instanceof IdentityInterface) {
            throw new InvalidArgumentException('认证未实现');
        }
        $playLoad = $this->_instance->parseToken($token);
        if (!$playLoad) {
            return false;
        }
        $this->_authResult = $identityModel->authenticate($playLoad, $this->_type);
        return $this->_authResult->isIdentity();

    }

    /**
     * Author:Robert
     *
     * @param string $id
     * @param array $extends
     * @param int $expire
     * @return string
     */
    public function generateToken(string $id, $extends, int $expire = 86400): string
    {
        return $this->_instance->generateToken([
            'id'  => $id,
            'ext' => $extends,
        ], $expire);
    }

    /**
     * @author Robert
     */
    public function reset(): void
    {
        if ($this->_authResult) {
            $this->_authResult = null;
        }
    }

    /**
     * @return string|null
     * @author Robert
     */
    public function getIdentity(): ?string
    {
        if (!$this->_authResult) {
            return null;
        }
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
    public function getExtendedData(): array
    {
        if (!$this->_authResult) {
            return [];
        }
        if (!$this->_authResult->isIdentity()) {
            return [];
        }
        return $this->_authResult->getExtendedData();
    }

}
