<?php

namespace Domain\Common;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Entity
 * @package Domain\Entities
 */
abstract class Entity extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface
     */
    protected $updatedAt;

    /**
     * @var
     */
    protected $deletedAt;

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @return mixed
     */
    public function getCreatedAtHumansAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Generates an unique iterated name.
     *
     * @param $column
     * @param $name
     * @return string
     */
    protected function generateIteratedName($column, $name): string
    {
        $entity = new $this;
        try {
            // Requires soft delete
            $existing = $entity->withTrashed();
        } catch (\Exception $e) {
            $existing = $entity;
        }

        $existing->where($column, 'LIKE', "{$name}%")
            ->orderBy($column, 'desc')
            ->get();

        if ($existing->count() > 0) {
            $sequence = (int)str_replace($name, '', $existing->first()->{$column});
            return $name . ($sequence + 1);
        } else {
            return $name;
        }

    }
}