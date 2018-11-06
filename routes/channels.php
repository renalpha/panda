<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int)$user->id === (int)$id;
});

Broadcast::channel('users.group.notification.{groupId}', function ($user, $groupId) {
    \Illuminate\Support\Facades\Log::info($groupId);
    return count(\Domain\Entities\PandaGroup\PandaGroupUser::where('panda_group_id', $groupId)->where('user_id', auth()->user()->id)->select('user_id')->get()) > 0;
});