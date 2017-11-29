<?php

if (!function_exists('apiUri')) {
    function apiUri($uri)
    {
        return 'http://localhost:3000'.$uri;
    }
}
