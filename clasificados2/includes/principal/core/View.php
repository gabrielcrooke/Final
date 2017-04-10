<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');



    class View
    {
        private $aExported;
        private $aCurrent;
        private static $instance;

        public static function newInstance()
        {
            if(!self::$instance instanceof self) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        function __construct()
        {
            $this->aExported = array();
        }

        //to export variables at the business layer
        function _exportVariableToView($key, $value)
        {
            $this->aExported[$key] = $value;
        }

        //to get the exported variables for the view
        function _get($key)
        {
            if ($this->_exists($key)) {
                return($this->aExported[$key]);
            } else {
                return '';
            }
        }

        //only for debug
        function _view($key = null)
        {
            if ($key) {
                print_r($this->aExported[$key]);
            } else {
                print_r($this->aExported);
            }
        }

        function _next($key)
        {
            if (is_array($this->aExported[$key])) {
                $this->aCurrent[$key] = current( $this->aExported[$key] );
                if ( $this->aCurrent[$key] ) {
                    next( $this->aExported[$key] );
                    return true;
                }
            }
            return false;
        }

        function _current($key)
        {
            if ( isset($this->aCurrent[$key]) && is_array($this->aCurrent[$key]) ) {
                return $this->aCurrent[$key];
            } elseif ( is_array($this->aExported[$key]) ) {
                $this->aCurrent[$key] = current( $this->aExported[$key] );
                return $this->aCurrent[$key];
            }
            return '';
        }

        function _key($key)
        {
            if ( is_array($this->aExported[$key]) ) {
                $_key = key( $this->aExported[$key] ) -1;
                if($_key==-1) {
                    $_key = count($this->aExported[$key]) -1;
                }
                return $_key;
            }
            return false;
        }

        function _seek($key, $position)
        {
            if ( is_array($this->aExported[$key]) ) {
                $this->_reset($key);
                for($k = 0;$k<=$position;$k++) {
                    $res = $this->_next($key);
                    if(!$res) {
                        return false;
                    }
                }
                return true;
            }
            return false;
        }

        function _reset($key)
        {
            if ( !array_key_exists($key, $this->aExported) ) {
                return array();
            }
            if ( !is_array( $this->aExported[$key] ) ) {
                return array();
            }
            return reset($this->aExported[$key]);
        }

        function _exists($key)
        {
            return ( isset($this->aExported[$key]) ? true : false );
        }

        function _count($key)
        {
            if (isset($this->aExported[$key]) && is_array($this->aExported[$key])) {
                return count($this->aExported[$key]);
            }
            return -1; // @TOFIX @FIXME ?? why ? why not 0 ?
        }

        function _erase($key)
        {
            unset($this->aExported[$key]);
            unset($this->aCurrent[$key]);
        }
    }

?>
