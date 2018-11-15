<?php

namespace App\Models;

use Illuminate\Support\Collection;

/**
 * Trait LikesUsersTrait
 * @package App\Models
 */
trait LikesUsersTrait
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLikesUsersAttribute(): Collection
    {
        return $this->likes()
            ->join('users', 'love_likes.user_id', '=', 'users.id')
            ->select('name')
            ->limit(15)
            ->get();
    }
}