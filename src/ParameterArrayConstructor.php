<?php

namespace smtech\StMarksSearch;

use Exception;

class ParameterArrayConstructor
{
    public function __construct($params)
    {
        foreach ($params as $field => $value) {
            /*
             * looking for setters of the form `setField` for a field named
             * `field`
             */
            $setter = 'set' . ucfirst($field);
            $this->$setter($value);
        }
    }

    /**
     * Require that a specific parameter key exists (and optionally has a
     * particular class as one of its parents)
     *
     * @param array $params
     * @param string $key
     * @param string|false $class (Optional, defaults to `FALSE`) name of class
     *                            to require as a parent
     * @return void
     * @throws Exception If the required parameter is not set (or does not
     *         have the correct parent class, if `$class` is specified)
     */
    protected static function requireParameter($params, $key, $class = false)
    {
        if (!isset($params[$key])) {
            throw new Exception("`$key` param required");
        }

        if ($class !== false && is_string($class)) {
            if (!is_a($params[$key], $class)) {
                throw new Exception(
                    "`$key` must be an instance of `$class`, instance of " .
                    get_class($params[$key]) . ' passed instead'
                );
            }
        }
    }

    /**
     * Set a parameter to a default value if it is not set
     *
     * @param array $params
     * @param string $key
     * @param mixed $value
     * @param string|false $class
     * @return void
     */
    protected static function defaultParameter(&$params, $key, $value, $class = false)
    {
        try {
            static::requireParameter($params, $key, $class);
        } catch (Exception $e) {
            $params[$key] = $value;
        }
    }

    /**
     * Force a boolean result from a particular parameter key
     *
     * @param array $params
     * @param string $key    [description]
     * @return boolean `TRUE` iff `$params[$key]` exists and has a true value
     *                        (`1`, `'yes'`, `'true'`, `true`, etc.), `FALSE`
     *                        otherwise.
     */
    protected static function forceBooleanParameter($params, $key)
    {
        return isset($params[$key]) && filter_var($params[$key], FILTER_VALIDATE_BOOLEAN);
    }

    protected static function consumeParameters($params, $consumedParams)
    {
        return array_diff_key($params, array_flip($consumedParams));
    }

    public function __call($method, $arguments)
    {
        if (method_exists($this, $method)) {
            return $this->$method($arguments);
        } elseif (preg_match('/^([gs]et)([A-Z].*)$/', $method, $match)) {
            $verb = $match[1];
            $property = lcfirst($match[2]);
            if ($verb == 'set') {
                $this->$property = $arguments[0];
                return;
            } elseif (isset($this->$property)) {
                return $this->$property;
            } else {
                trigger_error('Fatal error: Call to undefined property ' . static::class . "::$property");
            }
        } else {
            trigger_error('Fatal error: Call to undefined method ' . static::class . "::$method");
        }
    }
}
