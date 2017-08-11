<?php
/**
 * user: fangjinwei
 * date: 2017/6/16 12:20
 * desc: 加密算法
 */
class EncryptExt {
    private $desKey = "F@#$%!DFWEG558JW";//Only keys of sizes 16, 24 or 32 supported

    private $rsaPublicKey =
'-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQD23Oe6MZ/vs24agygzWXUwkaSK
amea2gxXg2ADNXNWk9syGgVuT+K4cZqQek4M9O41QzeMUbDQkzon14KMoUyj6pRw
kIOI80qafAJQxpwyGpG3CEndfJo9PZMnFBqZw2D0TkCfnM3Eo2a0pnH+x+2Ebl6E
3QtXHB2e8+tTqtAWswIDAQAB
-----END PUBLIC KEY-----';
    private $rsaPrivateKey =
'-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQD23Oe6MZ/vs24agygzWXUwkaSKamea2gxXg2ADNXNWk9syGgVu
T+K4cZqQek4M9O41QzeMUbDQkzon14KMoUyj6pRwkIOI80qafAJQxpwyGpG3CEnd
fJo9PZMnFBqZw2D0TkCfnM3Eo2a0pnH+x+2Ebl6E3QtXHB2e8+tTqtAWswIDAQAB
AoGBAKpeCDqStuspbMo1TBAsI9lyGhlAl+Hhq/TVgPSV9dSBVBw+oxLfZPufw2kE
T0tX2fG+Qt6/HgTEJrWKYNmHFCkM3aka2juPVo2t+tgE3C3AitOK97Xv6nMV/Ofi
tHgBZ6JJrsi1VaN7/rztxLEm2u10OXKNAi7pRYhvYJ6ghn+5AkEA/sBTE+Yyx7mE
j6caBK3wqmIg1AABj4GfAnS6NocJGAn8vsgnJwzK5tGtnyY+UYWv6GL+67qa8Q4Q
5wlXHLYRpQJBAPgSrpMSaFAs75zf2jMo2dw46gDDaPMFJEgryhhSCMbq7dccITQT
77ndMahLJBaXWboZ5A5TJv/vHlxA+s+a53cCQFAoGbvgKcg4MmK09HXWeSxTVfr+
yX7rDSpLqi/wC0d6FQG+nrslxk4cWaIC+YbTJsdbJtTrUUdZ4q2ffb5191UCQDf6
10Q/AiUdjtDCvxWOYWNNwJh9gEBe56oVn5xPXsWsnBFPurpqyU0S+jK1CibC7q+N
SiZlY0ab6ij9TNvuY88CQQC21Ei0uzdOjTnn6fxhp5W8x6vlqZGmRYQFRZG3e/RO
lnUMOHzhtk3qk5ZR1jsUD39/M9yb/aQDqFaaZdanaS3S
-----END RSA PRIVATE KEY-----';

    /**
     * RSA非对称加密(公钥加密) data为117个字符以内,加密后的内容通常含有特殊字符，需要编码转换，在网络间通过url传输时要注意base64编码是否是url安全的
     * @param string $data
     * @return string
     */
    public function RsaPublicEncrypt($data){
        openssl_public_encrypt($data,$encrypted,$this->rsaPublicKey,OPENSSL_PKCS1_PADDING);
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    /**
     * RSA解密(私钥解密)
     * @param string $encrypted
     * @return mixed
     */
    public function RsaPrivateDecrypt($encrypted){
        openssl_private_decrypt(base64_decode($encrypted),$decrypted,$this->rsaPrivateKey,OPENSSL_PKCS1_PADDING);
        return $decrypted;
    }

    /**
     * Ios RSA加密
     * @param string $data
     * @return string
     */
    public function iosPublicEncrypt($data) {
        openssl_public_encrypt($data, $encrypted, $this->rsaPublicKey,OPENSSL_PKCS1_PADDING);
        $encrypted = base64_encode($encrypted);
        return $encrypted;
    }

    /**
     * Ios RSA解密
     * @param string $encrypted
     * @return mixed
     */
    public function iosPrivateDecrypt($encrypted) {
        openssl_private_decrypt(base64_decode($encrypted), $decrypted, $this->rsaPrivateKey,OPENSSL_PKCS1_PADDING);
        return $decrypted;
    }

    /**
     * 对称性加密算法DES
     * @param string $data
     * @return string
     */
    public function DesEncrypt($data){
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $pad = $size - (strlen($data) % $size);
        $data = $data . str_repeat(chr($pad), $pad);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->desKey, $iv);
        $data = mcrypt_generic($td, $data);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);
        return $data;
    }

    /**
     * DES解密
     * @param string $encrypted
     * @return string
     */
    public function DesDecrypt($encrypted){
        $decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->desKey, base64_decode($encrypted), MCRYPT_MODE_ECB);
        $dec_s = strlen($decrypted);
        $padding = ord($decrypted[$dec_s-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }
}