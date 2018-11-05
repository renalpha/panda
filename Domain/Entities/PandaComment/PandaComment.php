<?php

namespace Domain\Entities\PandaComment;

use Cog\Contracts\Love\Likeable\Models\Likeable as LikeableContract;
use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class PandaComment
 * @package Domain\Entities\PandaComments
 */
class PandaComment extends AggregateRoot implements LikeableContract
{
    use Likeable;
    /**
     * @var string
     */
    protected $table = 'comments';

    /**
     * Mass assign vars.
     *
     * @var array
     */
    protected $fillable = ['commentable_id', 'commentable_type', 'user_id', 'data'];

    /**
     * Get all of the owning commentable models.
     */
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getCommentAttribute()
    {
        return json_decode($this->data, false)->comment;
    }

    /**
     * Get comment.
     *
     * @return string
     */
    public function getNameAttribute()
    {
        try {
            return json_decode($this->data, false)->name;
        } catch (\Exception $e) {
            return 'Anonymous';
        }
    }
}