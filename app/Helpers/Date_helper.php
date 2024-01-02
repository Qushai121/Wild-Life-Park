<?php

if (!function_exists('format_datetime')) {
    /**
     * Format the given date and time string.
     *
     * @param string $dateTimeString The original date and time string.
     * @param string $format The desired format.
     * @return string Formatted date and time.
     */
    function format_datetime($dateTimeString, $format = 'd F Y')
    {
        $dateTime = new \DateTime($dateTimeString);
        return $dateTime->format($format);
    }
}
