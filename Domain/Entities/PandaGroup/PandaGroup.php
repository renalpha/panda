<?php

namespace Domain\Entities\PandaGroup;

use Domain\Common\AggregateRoot;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

/**
 * Class PandaGroup
 * @package Domain\Entities\PandaGroup
 */
class PandaGroup extends AggregateRoot
{
    use Notifiable, SoftDeletes;

    /**
     * Mass assign variables.
     *
     * @var array
     */
    protected $fillable = ['name', 'label', 'uuid'];

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'panda_groups';

    /**
     * @param int $id
     * @return bool
     */
    public function findUserById(int $id): bool
    {
        return $this->users->contains('user_id', $id);
    }

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(new PandaGroupUser());
    }

    /**
     * Set the label value.
     *
     * @param $value
     */
    public function setLabelAttribute($value): void
    {
        if (isset($value)) {
            if ($value !== $this->label) {
                // Set slug
                $this->attributes['label'] = $this->generateIteratedName('label', $value);
            }
        } else {
            // Otherwise empty the slug
            $this->attributes['label'] = null;
        }
    }

    /**
     * Find user in current group.
     *
     * @param int $userId
     * @return bool
     */
    public function findUserInGroup(int $userId)
    {
        return in_array($userId, array_column($this->users->toArray(), 'user_id'), true);
    }
}