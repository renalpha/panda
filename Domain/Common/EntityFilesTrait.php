<?php

namespace Domain\Common;

/**
 * Trait EntityFilesTrait
 * @package Domain\Common
 */
trait EntityFilesTrait
{
    /**
     * @return string
     */
    public function getCoverAttribute()
    {
        return '/storage/uploads/photos/' . $this->file;
    }
}