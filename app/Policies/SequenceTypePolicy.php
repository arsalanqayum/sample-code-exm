<?php

namespace App\Policies;

use App\SequenceType;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SequenceTypePolicy
{
    use HandlesAuthorization;

    /**
     * Overwrite policy before all the policies below execute
     *
     * @param User User
     * @return bool|void
     */
    public function before(User $user)
    {
        if($user->type == 'admin') {
            return true;
        }
    }

    /**
     * Determine whether the user can view any sequence types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->type == 'company';
    }

    /**
     * Determine whether the user can view the sequence type.
     *
     * @param  \App\User  $user
     * @param  \App\SequenceType  $sequenceType
     * @return mixed
     */
    public function view(User $user, SequenceType $sequenceType)
    {
        return $sequenceType->campaign->company->user_id == $user->id;
    }

    /**
     * Determine whether the user can create sequence types.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the sequence type.
     *
     * @param  \App\User  $user
     * @param  \App\SequenceType  $sequenceType
     * @return mixed
     */
    public function update(User $user, SequenceType $sequenceType)
    {
        //
    }

    /**
     * Determine whether the user can delete the sequence type.
     *
     * @param  \App\User  $user
     * @param  \App\SequenceType  $sequenceType
     * @return mixed
     */
    public function delete(User $user, SequenceType $sequenceType)
    {
        return $sequenceType->campaign->company->user_id == $user->id;
    }

    /**
     * Determine whether the user can restore the sequence type.
     *
     * @param  \App\User  $user
     * @param  \App\SequenceType  $sequenceType
     * @return mixed
     */
    public function restore(User $user, SequenceType $sequenceType)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the sequence type.
     *
     * @param  \App\User  $user
     * @param  \App\SequenceType  $sequenceType
     * @return mixed
     */
    public function forceDelete(User $user, SequenceType $sequenceType)
    {
        //
    }
}
