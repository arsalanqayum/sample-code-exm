<?php

namespace App\Policies;

use App\Campaign;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
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
     * Determine whether the user can view any campaigns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function view(User $user, Campaign $campaign)
    {
        return $campaign->company->user_id == $user->id;
    }

    /**
     * Determine whether the user can create campaigns.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function update(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can delete the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function delete(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can restore the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function restore(User $user, Campaign $campaign)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the campaign.
     *
     * @param  \App\User  $user
     * @param  \App\Campaign  $campaign
     * @return mixed
     */
    public function forceDelete(User $user, Campaign $campaign)
    {
        //
    }
}
