<?php

namespace Janfish\Auth\Token;

class Jwt implements TokenInterface
{

    private $_data;
    private $_alg;
    private $_secret;
    private $_expire;
    private $_iss;

    const DEFAULT_JWT_ALG = 'HS256'; //HASH_HMAC_SHA256
    const DEFAULT_ISS = 'Jwt Auth'; //HASH_HMAC_SHA256

    /**
     * Author:Robert
     *
     * @param array $options
     * @throws \Exception
     */
    public function setOptions(array $options): void
    {
        if (!isset($options['secret']) || !$options['secret']) {
            throw new \Exception('算法错误');
        }
        $this->_iss = $options['iss'] ?? self::DEFAULT_ISS;
        $this->_alg = $options['alg'] ?? self::DEFAULT_JWT_ALG;
        $this->_secret = $options['secret'];
        $this->_expire = time() + ($options['expire'] ?? 86400);

    }

    /**
     * Author:Robert
     *
     * @param array $data
     * @return string
     */
    public function generateToken(array $data): string
    {
        try {
            $token = [
                'iss' => $this->_iss,
                'iat' => time(),
                'exp' => $this->_expire,
                'data' => $data,
            ];
            return \Firebase\JWT\JWT::encode($token, $this->_secret, $this->_alg);
        } catch (\Exception $exception) {
            return '';
        }
    }

    /**
     * Author:Robert
     *
     * @param $array
     * @return array
     */
    private function object2array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object2array($value);
            }
        }
        return $array;
    }

    /**
     * Author:Robert
     *
     * @param string $token
     * @return array
     */
    public function parseToken(string $token)
    {
        try {
            $payload = \Firebase\JWT\JWT::decode($token, $this->_secret, [$this->_alg]);
            if (!$payload || !isset($payload->data)) {
                return [];
            }
            return $this->object2array($payload->data);
        } catch (\Exception $exception) {
            return [];
        }
    }
}
