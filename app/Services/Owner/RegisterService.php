<?php

namespace App\Services\Owner;

use App\User;
use App\UserProfile;
use Illuminate\Support\Arr;

class RegisterService
{
    /**
     * Save user profile
     *
     * @param mixed $request
     * @param User $user
     * @return void
     */
    public function saveUserProfile($request, User $user)
    {
        $userProfile = new UserProfile();
        $userProfile->fill(
            Arr::except($request->except($user->getFillable()), ['languages', 'time_to_chats', 'companySlug'])
        );
        $userProfile->language = implode(',', $request->languages);
        $userProfile->user_id = $user->id;
        $userProfile->time_to_chat = implode(',', $request->time_to_chats);
        $userProfile->save();
    }
}