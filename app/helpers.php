<?php

if (!function_exists('inputOld')) {
    function inputOld($name, $model = null)
    {
        return old($name, request($name) ?? $model ?? null);
    }
}