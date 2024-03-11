<?php

declare(strict_types=1);

if (!function_exists('carbon')) {
    /**
     * Get a Carbon instance for the current date and time.
     *
     * @param DateTimeZone|string|null $tz
     *
     * @return \Illuminate\Support\Carbon
     */
    function carbon(DateTimeZone|string|null $tz = null): \Illuminate\Support\Carbon
    {
        return \Illuminate\Support\Carbon::now($tz);
    }
}

if (!function_exists('when')) {
    function when(bool $condition, callable $true, ?callable $false = null)
    {
        if ($condition) {
            return $true();
        }
        if ($false) {
            return $false();
        }

        return null;
    }
}
