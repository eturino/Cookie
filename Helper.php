<?php
/**
 * get()
 */
class EtuDev_Cookie_Helper {

	protected $prefix = '';

	public function __construct($prefix = 'app_') {
		$this->prefix = $prefix ? : '';
	}

	/**
	 * get the cookie that has been base64 serialized and with a salt (prefix)
	 *
	 * @param $name
	 * @return bool|mixed|null
	 */
	public function getSafe($name) {
		$key   = $this->prefix . $name;
		$value = array_key_exists($key, $_COOKIE) ? unserialize(base64_decode($_COOKIE[$key])) : null;
		if ($value == null) {
			return false;
		}
		return $value;
	}

	/**
	 * @param $name
	 * @param $value
	 * @param int $expiration
	 * @param string $domain
	 * @return bool
	 */
	public function setSafe($name, $value, $expiration = 0, $domain = '') {
		$enc = base64_encode(serialize($value));
		return static::setCookieLive($this->prefix . $name, $enc, $expiration, '/', $domain);
	}

	/**
	 * @static
	 *
	 * set the cookie AND assign the value to $_COOKIE array
	 *
	 * @param string      $name
	 * @param string      $value
	 * @param int         $expire
	 * @param string      $path
	 * @param string      $domain
	 * @param bool        $secure
	 * @param bool        $httponly
	 *
	 * @return bool
	 */
	static public function setCookieLive($name, $value = '', $expire = 0, $path = '', $domain = '', $secure = false, $httponly = false) {
		//set a cookie as usual, but ALSO add it to $_COOKIE so the current page load has access
		$_COOKIE[$name] = $value;
		return setcookie($name, $value, $expire, $path, $domain, $secure, $httponly);
	}

	/**
	 * @static
	 *
	 * delete the cookie AND assign the value '' to $_COOKIE array
	 *
	 * @param string      $name
	 * @param string      $path
	 * @param string      $domain
	 * @param bool        $secure
	 * @param bool        $httponly
	 *
	 * @return bool
	 */
	static public function deleteCookieLive($name, $path = '', $domain = '', $secure = false, $httponly = false) {
		$value = time() - 1314000;

		$_COOKIE[$name] = $value;
		return setcookie($name, '', $value, $path, $domain, $secure, $httponly);
	}

	/**
	 * @static
	 *
	 * delete the cookie but leave the $_COOKIE array intact
	 *
	 * @param string      $name
	 * @param string      $path
	 * @param string      $domain
	 * @param bool        $secure
	 * @param bool        $httponly
	 *
	 * @return bool
	 */
	static public function deleteCookie($name, $path = '', $domain = '', $secure = false, $httponly = false) {
		//set a cookie as usual, but ALSO add it to $_COOKIE so the current page load has access
		return setcookie($name, '', time() - 1314000, $path, $domain, $secure, $httponly);
	}

}