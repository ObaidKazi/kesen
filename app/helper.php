<?php

if (!function_exists('checkRequestUrl')) {
    function checkRequestUrl($patterns,$currentUrl)
    {
        foreach ($patterns as $pattern) {
            // If the pattern contains 'regex:', treat it as a regular expression
            if (strpos($pattern, 'regex:') === 0) {
                $regex = substr($pattern, 6); // Extract the regex pattern
                if (preg_match($regex, $currentUrl)) {
                   return true;
                }
            } else {
                // Otherwise, treat it as a simple string match
                if (fnmatch($pattern, $currentUrl)) {
                    echo "Current URL matches the pattern: $pattern";
                    return true;
                }
            }
        }
        return false;
    }
}
?>