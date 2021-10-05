<?php

namespace FactumMart\API\LIB;

use SessionHandler;

class AppSessionHandler extends SessionHandler {

    private $_sessionName = 'FactumMartSession';
    private $_sessionMaxLifeTime = 0;
    private $_sessionPath = '/';
    private $_sessionSavePath = \SESSIONS_SAVE_PATH;
    private $_sessionDomain = 'api.factum.mart';
    private $_sessionSSL = false;
    private $_sessionHTTPOnly = true;
    private $_sessionTTL = 5;

    private $_sessionUserId;

    private $_encryptionCipherAlgo = 'blowfish';
    private $_encryptionPassKey = '$2y$10$1e6b93aa6b33e12cbcf84fbe125e232774874ea701ee';
    private $_encryptionIV = 'UN!V3RS3';

    public function __construct($userId) {
        $this->_sessionUserId = $userId;
        \ini_set('session.save_handler', 'files');
        \ini_set('session.save_path', $this->_sessionSavePath);
        \ini_set('session.use_cookies', 1);
        \ini_set('session.use_only_cookies', 1);

        \session_name($this->_sessionName);
        \session_save_path($this->_sessionSavePath);
        \session_set_cookie_params(
            $this->_sessionMaxLifeTime,
            $this->_sessionPath,
            $this->_sessionDomain,
            $this->_sessionSSL,
            $this->_sessionHTTPOnly
        );
        \session_set_save_handler($this, true); 
    }

    public function __get($key) {
        return \false !== $_SESSION[$key] ? $_SESSION[$key] : \false;
    }

    public function __set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function __isset($key) {
        return isset($_SESSION[$key]) ? true : false;
    }

    private function encrypt($data) {
        $encrypted = \openssl_encrypt(
            $data, 
            $this->_encryptionCipherAlgo, 
            $this->_encryptionPassKey, 
            0, 
            $this->_encryptionIV
        );
        return $encrypted;
    }

    public function decrypt($data) {
        $decrypted = \openssl_decrypt(
            $data,
            $this->_encryptionCipherAlgo,
            $this->_encryptionPassKey,
            0,
            $this->_encryptionIV
        );
        return $decrypted;
    }

    public function read($id) {
        $encryptedData = parent::read($id);
        if(!$encryptedData) {
            return '';
        } else {
            return $this->decrypt($encryptedData);
        }
    }

    public function write($id, $data) {
        return parent::write($id, $this->encrypt($data));
    }

    public function start() {
        if('' === \session_id()) {
            if(\session_start()) {
                $this->setSessionStartTime();
                $this->generateFingerPrint($this->_sessionUserId);
                $this->checkSessionValidity();
                return bin2hex(random_bytes(32));
            }
        }
    }
    
    private function setSessionStartTime() {
        if(!isset($this->sessionStartTime)) {
            $this->sessionStartTime = time();
        }
        return true;
    }

    private function checkSessionValidity() {
        if(\time() - $this->sessionStartTime > $this->_sessionTTL * 60) {
            $this->renewSession();
            $this->generateFingerPrint($this->_sessionUserId);
        } else {
            return \true;
        }
    }

    private function renewSession() {
        $this->sessionStartTime = time();
        return \session_regenerate_id(true);
    }

    private function generateFingerPrint($userId) {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $this->fingerPrintSalt = openssl_random_pseudo_bytes(32);
        $this->userId = $userId;
        $sessionId = \session_id();
        $this->fingerPrint = \md5($userAgent . $this->fingerPrintSalt . $sessionId . $userId);
    }

    public function isValidFingerPrint() {
        if(!isset($this->fingerPrint)) {
            $this->generateFingerPrint($this->_sessionUserId);
        }
        $fingerPrint = \md5($_SERVER['HTTP_USER_AGENT'].$this->fingerPrintSalt . \session_id() . $this->_sessionUserId);
        if($fingerPrint === $this->fingerPrint) {
            return \true;
        }
        return \false;
    }

    public function kill() {
        session_unset();
        setcookie(
            $this->sessionName,
            '',
            time() - 1000,
            $this->sessionPath,
            $this->sessionDomain,
            $this->sessionSSL,
            $this->sessionHTTPOnly,
        );
        session_destroy();
    }

}