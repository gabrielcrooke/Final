<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    require_once LIB_PATH . 'htmlpurifier/HTMLPurifier.auto.php';

    class Params
    {
        private static $_purifier;
        private static $_config;
        private static $_request;
        private static $_server;

        function __construct() { }

        static function init() {
            self::$_request = array_merge($_GET, $_POST);
            self::$_server = $_SERVER;
        }

        static function getParam($param, $htmlencode = false, $xss_check = true, $quotes_encode = true)
        {
            if ($param == "") return '';
            if (!isset(self::$_request[$param])) return '';

            $value = self::_purify(self::$_request[$param], $xss_check);

            if ($htmlencode) {
                if($quotes_encode) {
                    return htmlspecialchars(stripslashes($value), ENT_QUOTES);
                } else {
                    return htmlspecialchars(stripslashes($value), ENT_NOQUOTES);
                }
            }

            if(get_magic_quotes_gpc()) {
                $value = strip_slashes_extended($value);
            }

            return ($value);
        }

        static function existParam($param)
        {
            if ($param == "") return false;
            if (!isset(self::$_request[$param])) return false;
            return true;
        }

        static function getServerParam($param, $htmlencode = false, $xss_check = true, $quotes_encode = true)
        {
            if ($param == "") return '';
            if (!isset(self::$_server[$param])) return '';

            $value = self::_purify(self::$_server[$param], $xss_check);

            if ($htmlencode) {
                if($quotes_encode) {
                    return htmlspecialchars(stripslashes($value), ENT_QUOTES);
                } else {
                    return htmlspecialchars(stripslashes($value), ENT_NOQUOTES);
                }
            }

            if(get_magic_quotes_gpc()) {
                $value = strip_slashes_extended($value);
            }

            return ($value);
        }

        static function existServerParam($param)
        {
            if ($param == "") return false;
            if (!isset(self::$_server[$param])) return false;
            return true;
        }

        static function getServerParamsAsArray($xss_check = true)
        {
            $value = self::_purify(self::$_server, $xss_check);

            if(get_magic_quotes_gpc()) {
                return strip_slashes_extended($value);
            }

            return $value;
        }

        static function getFiles($param)
        {
            if (isset($_FILES[$param])) {
                return ($_FILES[$param]);
            }

            return "";
        }

        static function getParamsAsArray($what = "", $htmlencode = false, $xss_check = true, $quotes_encode = true)
        {
            switch ($what) {
                case("get"):
                    $value = $_GET;
                break;
                case("post"):
                    $value = $_POST;
                break;
                case("cookie"):
                    return $_COOKIE;
                    break;
                case("files"):
                    return $_FILES;
                    break;
                case("request"): // This should not be called, as it depends on server's configuration
                    return $_REQUEST;
                    break;
                default:
                    $value = self::$_request;
                break;
            }

            $value = self::_purify($value, $htmlencode, $xss_check, $quotes_encode);

            if(get_magic_quotes_gpc()) {
                return strip_slashes_extended($value);
            }

            return $value;
        }

        static function setParam($key, $value)
        {
            self::$_request[$key] = $value;
        }

        static function unsetParam($key)
        {
            unset(self::$_request[$key]);
        }

        static function _view()
        {
            print_r(self::getParamsAsArray());
        }

        static private function _purify($value, $xss_check)
        {
            if( !$xss_check ) {
                return $value;
            }

            self::$_config = HTMLPurifier_Config::createDefault();
            self::$_config->set('HTML.Allowed', '');
            self::$_config->set('Cache.SerializerPath', osc_uploads_path());

            if( !isset(self::$_purifier) ) {
                self::$_purifier = new HTMLPurifier(self::$_config);
            }

            if( is_array($value) ) {
                foreach($value as $k => &$v) {
                    $v = self::_purify($v, $xss_check); // recursive
                }
            } else {
                $value = self::$_purifier->purify($value);
            }

            return $value;
        }
    }

?>
