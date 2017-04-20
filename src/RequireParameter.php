<?php

namespace smtech\StMarksSearch;

use Exception;

/**
 * Require parameters
 *
 * @author Seth Battis <SethBattis@stmarksschool.org>
 */
trait RequireParameter
{
    /**
     * Require that a specific parameter key exists (and optionally has a
     * particular class as one of its parents)
     *
     * @param mixed[string] $params
     * @param string $key
     * @param string|false $class (Optional, defaults to `FALSE`) name of class
     *                            to require as a parent
     * @return void
     * @throws Exception If the required parameter is not set (or does not
     *         have the correct parent class, if `$class` is specified)
     */
    protected function requireParameter($params, $key, $class = false)
    {
        assert(isset($params[$key]), new Exception("`$key` param required"));

        if ($class !== false && is_string($class)) {
            assert(
                is_a($params[$key], $class),
                new Exception(
                    "`$key` must be an instance of `$class`, instance of " .
                    get_class($params[$key]) . ' passed instead'
                )
            );
        }
    }


    /**
     * Force a boolean result from a particular parameter key
     *
     * @param mixed[string] $params
     * @param string $key    [description]
     * @return boolean `TRUE` iff `$params[$key]` exists and has a true value
     *                        (`1`, `'yes'`, `'true'`, `true`, etc.), `FALSE`
     *                        otherwise.
     */
    protected function forceBooleanParameter($params, $key)
    {
        return isset($params[$key]) && filter_var($params[$key], FILTER_VALIDATE_BOOLEAN);
    }
}
