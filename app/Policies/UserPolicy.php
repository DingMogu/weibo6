<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    //更新资料授权
    public function update(User $currentUser,User $user)
    {
        return $currentUser->id === $user->id;
    }
    //管理员删除用户授权
    public function destroy(User $currentUser,User $user)
    {
        return $currentUser->is_admin && $currentUser->id !== $user->id;
    }

    //关注授权
    public function follow(User $currentUser, User $user)
    {
        return $currentUser->id !== $user->id;
    }
}
