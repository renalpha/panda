<?php

namespace Domain\Services;

class SanitzeService
{
    /**
     * Strip inline javascript tags.
     *
     * @param string $string
     * @return null|string|string[]
     */
    public function stripInlineJavascript(string $string)
    {
        return preg_replace('\bon\w+=\S+(?=.*>)', '', $string);
    }
}