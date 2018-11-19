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

    /**
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany($this, 'id', 'parent_id');
    }

    /**
     * @return mixed
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}