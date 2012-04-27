<?php
/**
 * sacado de libreria EtuDev
 */
class EtuDev_Cookie_Helper {

	protected $prefix = '';

	public function __construct($prefix = 'app_') {
		$this->prefix = $prefix ? : '';
	}

	public function get($name) {
		$key   = $this->prefix . $name;
		$value = array_key_exists($key, $_COOKIE) ? unserialize(base64_decode($_COOKIE[$key])) : null;
		if ($value == null) {
			return false;
		}
		return $value;
	}

	public function set($name, $value, $expiration = 0, $domain = '') {
		$enc = base64_encode(serialize($value));
		return self::setCookieLive($this->prefix . $name, $enc, $expiration, '/', $domain);
	}

	public function expireToday() {
		return strtotime(date('Y-m-d 00:00:00', strtotime('+1 day')));
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