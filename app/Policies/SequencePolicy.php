<?php

namespace App\Policies;

use App\Sequence;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SequencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any sequences.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->type == 'company';
    }

    /**
     * Determine whether the user can view the sequence.
     *
     * @param  \App\User  $user
     * @param  \App\Sequence  $sequence
     * @return mixed
     */
    public function view(User $user, Sequence $sequence)
    {
        //
    }

    /**
     * Determine whether the user can create sequences.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the sequence.
     *
     * @param  \App\User  $user
     * @param  \App\Sequence  $sequence
     * @return mixed
     */
    public function update(User $user, Sequence $sequence)
    {
        //
    }

    /**
     * Determine whether the user can delete the sequence.
     *
     * @param  \App\User  $user
     * @param  \App\Sequence  $sequence
     * @return mixed
     */
    public function delete(User $user, Sequence $sequence)
    {
        //
    }

    /**
     * Determine whether the user can restore the sequence.
     *
     * @param  \App\User  $user
     * @param  \App\Sequence  $sequence
     * @return mixed
     */
    public function restore(User $user, Sequence $sequence)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the sequence.
     *
     * @param  \App\User  $user
     * @param  \App\Sequence  $sequence
     * @return mixed
     */
    public function forceDelete(User $user, Sequence $sequence)
    {
        //
    }
}
