<?php
namespace VGPM\Lib;
/**
 *
 * 加密类
 * @author  胡威
 * @version $Id: Crypt.php,v0.1 2010/11/11 $;
 */
class Crypt {
	private static $_key = 'vgpm';

	public static function setKey($key) {
		if (!empty($key)) {
			self::$_key = $key;
		}
	}

	public static function getKey() {
		return self::$_key;
	}

	/**
	 * openssl 加密
	 *
	 * @param string $source
	 *
	 * @return string
	 */
	public static function encode($source) {
		if (!$source) {
			return false;
		}
		$key              = self::getKey();
		$iv               = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, trim($source), MCRYPT_MODE_ECB, $iv);
		return trim(self::bin2hex($encrypted_string));
	}

	/**
	 * openssl 解密
	 *
	 * @param string $source
	 *
	 * @return string
	 */
	public static function decode($source) {
		if (!$source) {
			return false;
		}
		$key              = self::getKey();
		$iv               = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, self::hex2bin($source), MCRYPT_MODE_ECB, $iv);
		return trim($decrypted_string);
	}

	/**
	 * hex to bin  bin2hex
	 * @return string
	 */
	public static function hex2bin($data) {
		$len = strlen($data);
		return pack("H" . $len, $data);
	}

	public static function bin2hex($data) {
		return bin2hex($data);
	}


}