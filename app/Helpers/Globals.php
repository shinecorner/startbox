<?php

/***************************************************************************************
 ** ALTER VALUE
 ***************************************************************************************/

/**
 * Generate a raw DB query to search for a JSON field.
 *
 * @param  array|json  $json
 *
 * @throws \Exception
 *
 * @return \Illuminate\Database\Query\Builder
 */
if (!function_exists('castToJson')) {
    function castToJson($json)
    {
        // Convert from array to json and add slashes, if necessary.
        if (is_array($json)) {
            $json = addslashes(json_encode($json));
        }
        // Or check if the value is malformed.
        elseif (is_null($json) || is_null(json_decode($json))) {
            throw new \Exception('A valid JSON string was not provided.');
        }
        return \DB::raw("CAST('{$json}' AS JSON)");
    }
}

/**
 * Get boolean value of 'true' or 'false' strings
 */
if (!function_exists('castToBool')) {
    function castToBool(string $value)
    {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('getProperty')) {
    function getProperty($obj, $property, $failedReturn = null)
    {
        if (property_exists($obj, $property)) {
            return $obj->$property;
        }
        return $failedReturn;
    }
}

if (!function_exists('jsonEncodeDecode')) {
    function jsonEncodeDecode($data)
    {
        return json_decode(json_encode($data));
    }
}

/**
 * Removes all chars except digits
 *
 * @return string
 */
if (!function_exists('digits')) {
    function digits(string $value)
    {
        return filter_var($value, FILTER_SANITIZE_NUMBER_INT);
    }
}

/***************************************************************************************
 ** AUTHORIZATION
 ***************************************************************************************/

/**
 * Check if user authenticated and he's an admin.
 */
if (!function_exists('isAdmin')) {
    function isAdmin()
    {
        return (bool) optional(auth()->user())->isAdmin();
    }
}

/**
 * Check if user is not admin.
 */
if (!function_exists('isNotAdmin')) {
    function isNotAdmin()
    {
        return !isAdmin();
    }
}

/***************************************************************************************
 ** TIMEZONES
 ***************************************************************************************/

/**
 * Check if user is not admin.
 */
if (!function_exists('getAuthTimezone')) {
    function getRequestTimezone()
    {
        $timezone = request()->input('timezone');
        if ($timezone) {
            return $timezone;
        }
        $user = auth()->user();
        if ($user) {
            return $user->getTimezone();
        }
        return 'UTC';
    }
}

/***************************************************************************************
 ** OTHER
 ***************************************************************************************/

/**
 * Generate an unique key based on given keys.
 * Keys can be passed both as an array or as arguments.
 */
if (!function_exists('generateUniqueKey')) {
    function generateUniqueKey(): string
    {
        // Transform key to an array of keys if it's not an array yet.
        $keys = is_array(func_get_args()[0]) ? func_get_args()[0] : func_get_args();

        return 'unq_' . implode('_', $keys);
    }
}

/*
 * Run Invokable Class
 */
if (! function_exists('handle')) {
    function handle($invokableClass)
    {
        return $invokableClass();
    }
}

if (!function_exists('isValidIpAddress')) {
    function isValidIpAddress($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP);
    }
}