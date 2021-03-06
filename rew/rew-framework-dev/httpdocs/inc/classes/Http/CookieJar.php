<?php

/**
 * Http_Cookie_Jar
 *
 * Used to manage signed, encrypted Cookies. Provides:
 *
 * - Cookie integrity and authenticity with HMAC
 * - Confidentiality with symmetric encryption
 * - Protection from replay attack if using SSL or TLS
 * - Protection from interception if using SSL or TLS
 *
 * Requirements:
 *
 * - libmcrypt > 2.4.x
 *
 */
class Http_CookieJar
{

    /**
     * Server secret key
     * @var string
     */
    protected $_secret = '';

    /**
     * Cryptographic algorithm used to encrypt cookies data
     * @var int
     */
    protected $_algorithm = MCRYPT_RIJNDAEL_256;

    /**
     * Cryptographic mode (CBC, CFB ...)
     * @var int
     */
    protected $_mode = MCRYPT_MODE_CBC;

    /**
     * mcrypt module resource
     * @var resource
     */
    protected $_cryptModule = null;

    /**
     * Enable high confidentiality for cookie value (symmetric encryption)
     * @var bool
     */
    protected $_highConfidentiality = true;

    /**
     * Enable SSL support
     * @var bool
     */
    protected $_ssl = false;

    /**
     * Cookie objects
     * @var array[Cookie]
     */
    protected $_cookies = array();

    /**
     * Constructor
     *
     * Initialize cookie manager and mcrypt module.
     *
     * @param   string      $secret     Server's secret key
     * @param   array       $config
     * @return void
     * @throws  Exception               If secret key is empty
     * @throws  Exception               If unable to open mcypt module
     */
    public function __construct($secret, $config = null)
    {
        if (empty($secret)) {
            throw new Exception('You must provide a secret key');
        }
        $this->_secret = $secret;
        if ($config !== null && !is_array($config)) {
            throw new Exception('Config must be an array');
        }
        if (is_array($config)) {
            if (isset($config['high_confidentiality'])) {
                $this->_highConfidentiality = $config['high_confidentiality'];
            }
            if (isset($config['mcrypt_algorithm'])) {
                $this->_algorithm = $config['mcrypt_algorithm'];
            }
            if (isset($config['mcrypt_mode'])) {
                $this->_mode = $config['mcrypt_mode'];
            }
            if (isset($config['enable_ssl'])) {
                $this->_ssl = $config['enable_ssl'];
            }
        }
        if (extension_loaded('mcrypt')) {
            $this->_cryptModule = mcrypt_module_open($this->_algorithm, '', $this->_mode, '');
            if ($this->_cryptModule === false) {
                throw new Exception('Error while loading mcrypt module');
            }
        }
    }

    /**
     * Get the high confidentiality mode
     *
     * @return bool TRUE if cookie data encryption is enabled, or FALSE if it isn't
     */
    public function getHighConfidentiality()
    {
        return $this->_highConfidentiality;
    }

    /**
     * Enable or disable cookie data encryption
     *
     * @param   bool        $enable  TRUE to enable, FALSE to disable
     * @return  CookieJar
     */
    public function setHighConfidentiality($enable)
    {
        $this->_highConfidentiality = (bool) $enable;
        return $this;
    }

    /**
     * Get the SSL status (enabled or disabled?)
     *
     * @return bool TRUE if SSL support is enabled, or FALSE if it isn't
     */
    public function getSSL()
    {
        return $this->_ssl;
    }

    /**
     * Enable SSL support (not enabled by default)
     *
     * Pro: Protect against replay attack
     * Con: Cookie's lifetime is limited to SSL session's lifetime
     *
     * @param   bool        $enable TRUE to enable, FALSE to disable
     * @return  CookieJar
     */
    public function setSSL($enable)
    {
        $this->_ssl = (bool) $enable;
        return $this;
    }

    /**
     * Get Cookies for Response
     *
     * @return array[Cookie]
     */
    public function getResponseCookies()
    {
        return $this->_cookies;
    }

    /**
     * Get Cookie with name for Response
     *
     * @param   string $cookiename The name of the Cookie
     * @return  Cookie|null Cookie, or NULL if Cookie with name not found
     */
    public function getResponseCookie($cookiename)
    {
        return isset($this->_cookies[$cookiename]) ? $this->_cookies[$cookiename] : null;
    }

    /**
     * Set a secure cookie
     *
     * @param   string  $name       Cookie name
     * @param   string  $value      Cookie value
     * @param   string  $username   User identifier
     * @param   integer $expire     Expiration time
     * @param   string  $path       Cookie path
     * @param   string  $domain     Cookie domain
     * @param   bool    $secure     When TRUE, send the cookie only on a secure connection
     * @param   bool    $httponly   When TRUE the cookie will be made accessible only through the HTTP protocol
     * @return void
     */
    public function setCookie($cookiename, $value, $username, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = null)
    {
        $secureValue = extension_loaded('mcrypt') ? $this->_secureCookieValue($value, $username, $expire) : $value;
        $this->setClassicCookie($cookiename, $secureValue, $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Delete a cookie
     *
     * @param   string  $name       Cookie name
     * @param   string  $path       Cookie path
     * @param   string  $domain     Cookie domain
     * @param   bool    $secure     When TRUE, send the cookie only on a secure connection
     * @param   bool    $httponly   When TRUE the cookie will be made accessible only through the HTTP protocol
     * @return void
     */
    public function deleteCookie($name, $path = '/', $domain = '', $secure = false, $httponly = null)
    {
        $expire = 315554400; /* 1980-01-01 */
        $this->_cookies[$name] = new Http_Cookie($name, '', $expire, $path, $domain, $secure, $httponly);
        //setcookie($name, '', $expire, $path, $domain, $secure, $httponly);
    }

    /**
     * Get a secure cookie value
     *
     * Verify the integrity of cookie data and decrypt it. If the cookie is invalid, it can be automatically destroyed (default behaviour)
     *
     * @param   string          $cookiename Cookie name
     * @param   bool            $delete     Destroy the cookie if invalid?
     * @return  string|false                The Cookie value, or FALSE if Cookie invalid
     */
    public function getCookieValue($cookiename, $deleteIfInvalid = true)
    {
        if ($this->cookieExists($cookiename)) {
            if (extension_loaded('mcrypt')) {
                $cookieValues = explode('|', $_COOKIE[$cookiename]);
                if ((count($cookieValues) === 4) && ($cookieValues[1] == 0 || $cookieValues[1] >= time())) {
                    $key = hash_hmac('sha1', $cookieValues[0] . $cookieValues[1], $this->_secret);
                    $cookieData = base64_decode($cookieValues[2]);
                    if ($cookieData !== '' && $this->getHighConfidentiality()) {
                        $data = $this->_decrypt($cookieData, $key, md5($cookieValues[1]));
                    } else {
                        $data = $cookieData;
                    }
                    if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID'])) {
                        $verifKey = hash_hmac('sha1', $cookieValues[0] . $cookieValues[1] . $data . $_SERVER['SSL_SESSION_ID'], $key);
                    } else {
                        $verifKey = hash_hmac('sha1', $cookieValues[0] . $cookieValues[1] . $data, $key);
                    }
                    if ($verifKey == $cookieValues[3]) {
                        return $data;
                    }
                }
            } else {
                return $_COOKIE[$cookiename];
            }
        }
        if ($deleteIfInvalid) {
            $this->deleteCookie($cookiename);
        }
        return false;
    }

    /**
     * Send a classic (unsecure) cookie
     *
     * @param   string  $name       Cookie name
     * @param   string  $value      Cookie value
     * @param   integer $expire     Expiration time
     * @param   string  $path       Cookie path
     * @param   string  $domain     Cookie domain
     * @param   bool    $secure     When TRUE, send the cookie only on a secure connection
     * @param   bool    $httponly   When TRUE the cookie will be made accessible only through the HTTP protocol
     * @return void
     */
    public function setClassicCookie($cookiename, $value, $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = null)
    {
        /* httponly option is only available for PHP version >= 5.2 */
        if ($httponly === null) {
            $this->_cookies[$cookiename] = new Http_Cookie($cookiename, $value, $expire, $path, $domain, $secure);
            //setcookie($cookiename, $value, $expire, $path, $domain, $secure);
        } else {
            $this->_cookies[$cookiename] = new Http_Cookie($cookiename, $value, $expire, $path, $domain, $secure, $httponly);
            //setcookie($cookiename, $value, $expire, $path, $domain, $secure, $httponly);
        }
    }

    /**
     * Verify if a cookie exists
     *
     * @param   string  $cookiename
     * @return  bool    TRUE if cookie exist, or FALSE if not
     */
    public function cookieExists($cookiename)
    {
        return isset($_COOKIE[$cookiename]);
    }

    /**
     * Secure a cookie value
     *
     * The initial value is transformed with this protocol:
     *
     *  secureValue = username|expire|base64((value)k,expire)|HMAC(user|expire|value,k)
     *  where k = HMAC(user|expire, sk) and sk is server's secret key
     *  (value)k,md5(expire) is the result an cryptographic function (ex: AES256) on "value" with key k and initialisation vector = md5(expire)
     *
     * @param   string  $value      Unsecure value
     * @param   string  $username   User identifier
     * @param   integer $expire     Expiration time
     * @return  string              Secured value
     */
    protected function _secureCookieValue($value, $username, $expire)
    {
        if (is_string($expire)) {
            $expire = strtotime($expire);
        }
        $key = hash_hmac('sha1', $username . $expire, $this->_secret);
        if ($value !== '' && $this->getHighConfidentiality()) {
            $encryptedValue = base64_encode($this->_encrypt($value, $key, md5($expire)));
        } else {
            $encryptedValue = base64_encode($value);
        }
        if ($this->_ssl && isset($_SERVER['SSL_SESSION_ID'])) {
            $verifKey = hash_hmac('sha1', $username . $expire . $value . $_SERVER['SSL_SESSION_ID'], $key);
        } else {
            $verifKey = hash_hmac('sha1', $username . $expire . $value, $key);
        }
        $result = array($username, $expire, $encryptedValue, $verifKey);
        return implode('|', $result);
    }

    /**
     * Encrypt a given data with a given key and a given initialisation vector
     *
     * @param   string  $data   Data to crypt
     * @param   string  $key    Secret key
     * @param   string  $iv     Initialisation vector
     * @return  string          Encrypted data
     */
    protected function _encrypt($data, $key, $iv)
    {
        $iv = $this->_validateIv($iv);
        $key = $this->_validateKey($key);
        mcrypt_generic_init($this->_cryptModule, $key, $iv);
        $res = @mcrypt_generic($this->_cryptModule, $data);
        mcrypt_generic_deinit($this->_cryptModule);
        return $res;
    }

    /**
     * Decrypt a given data with a given key and a given initialisation vector
     *
     * @param   string  $data   Data to crypt
     * @param   string  $key    Secret key
     * @param   string  $iv     Initialisation vector
     * @return string           Encrypted data
     */
    protected function _decrypt($data, $key, $iv)
    {
        $iv = $this->_validateIv($iv);
        $key = $this->_validateKey($key);
        mcrypt_generic_init($this->_cryptModule, $key, $iv);
        $decryptedData = mdecrypt_generic($this->_cryptModule, $data);
        $res = str_replace("\x0", '', $decryptedData);
        mcrypt_generic_deinit($this->_cryptModule);
        return $res;
    }

    /**
     * Validate Initialization vector
     *
     * If given IV is too long for the selected mcrypt algorithm, it will be truncated
     *
     * @param   string $iv Initialization vector
     * @return  string
     */
    protected function _validateIv($iv)
    {
        $ivSize = mcrypt_enc_get_iv_size($this->_cryptModule);
        if (strlen($iv) > $ivSize) {
            $iv = substr($iv, 0, $ivSize);
        }
        return $iv;
    }

    /**
     * Validate key
     *
     * If given key is too long for the selected mcrypt algorithm, it will be truncated
     *
     * @param   string $key key
     * @param   string
     */
    protected function _validateKey($key)
    {
        $keySize = mcrypt_enc_get_key_size($this->_cryptModule);
        if (strlen($key) > $keySize) {
            $key = substr($key, 0, $keySize);
        }
        return $key;
    }
}
