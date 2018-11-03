<?php

namespace App\Models;

use Cog\Laravel\Love\Likeable\Models\Traits\Likeable;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class Notification
 * @package App\Models
 */
class Notification extends DatabaseNotification
{
    use Likeable;
}