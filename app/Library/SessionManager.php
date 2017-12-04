<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 30.11.17
 * Time: 21:26
 */

namespace App\Library;

/**
 * Class SessionManager
 * @package Mvc\Library
 */
class SessionManager {

    const TYPE_SUCCESS = 'success';
    const TYPE_ERROR = 'danger';
    const TYPE_INFO = 'info';

    /**
     * starts session, sets cookie params and validate if the session is hijacked
     */
    public static function sessionStart() {
        session_name('blog_session');

        session_set_cookie_params(0, '/', $_SERVER['SERVER_NAME'], isset($_SERVER['HTTPS']), true);
        session_start();
        if (self::validateSession()) {
            if (!self::preventHijacking()) {
                $_SESSION = [];
                $_SESSION['ipAddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                self::regenerateSession();
            } elseif (rand(1, 100) <= 10) {
                self::regenerateSession();
            }
        } else {
            $_SESSION = [];
            session_destroy();
            session_start();
        }
    }

    public static function authenticate() {
        if (empty($_POST['name']) || empty($_POST['password'])) {
            return false;
        }
        $name = $_POST['name'];
        $password = $_POST['password'];
        if (!$name == 'user' || !$password == 'password') {
            return false;
        }
        $_SESSION['authenticated'] = true;
        return true;
    }

    public static function isAuthenticated() {
        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            return false;
        }
        return true;
    }

    /**
     * adds an error to the session errors array
     *
     * @param string $value
     */
    public static function addError($value) {
        $_SESSION['ERRORS'][] = $value;
    }

    /**
     * adds an error to the session errors array
     *
     * @param string $value
     * @param $type
     */
    public static function addMessage($value, $type) {
        $_SESSION['MESSAGES'][] = [
            'message' => $value,
            'type' => $type
        ];
    }

    /**
     * return all errors in the session and clears them
     *
     * @return bool|array
     */
    public static function getErrors() {
        if (isset($_SESSION['ERRORS'])) {
            $errors = $_SESSION['ERRORS'];
            $_SESSION['ERRORS'] = [];
            return $errors;
        }
        return false;
    }

    /**
     * return all errors in the session and clears them
     *
     * @return bool|array
     */
    public static function getMessages() {
        if (isset($_SESSION['MESSAGES'])) {
            $messages = $_SESSION['MESSAGES'];
            $_SESSION['MESSAGES'] = [];
            return $messages;
        }
        return false;
    }

    /**
     *  regenerates the session
     */
    protected static function regenerateSession() {
        if (isset($_SESSION['OBSOLETE']) && $_SESSION['OBSOLETE'] == true) {
            return;
        }
        $_SESSION['OBSOLETE'] = true;
        $_SESSION['EXPIRES'] = time() + 10;

        session_regenerate_id(false);

        $newSessionId = session_id();
        session_write_close();

        session_id($newSessionId);
        session_start();

        unset($_SESSION['OBSOLETE']);
        unset($_SESSION['EXPIRES']);
    }

    /**
     * @return bool
     */
    protected static function validateSession() {
        if (isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES'])) {
            return false;
        }
        if (isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    protected static function preventHijacking() {
        if (!isset($_SESSION['ipAddress']) || !isset($_SESSION['userAgent'])) {
            return false;
        }
        if ($_SESSION['ipAddress'] != $_SERVER['REMOTE_ADDR']) {
            return false;
        }
        if ($_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']) {
            return false;
        }
        return true;
    }

    /**
     * destroys the session
     */
    public static function sessionDestroy() {
        session_destroy();
    }
}
