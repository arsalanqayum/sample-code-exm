<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Handle authorization before other policy
     *
     * @param User $user
     * @param $ability
     * @return mixed
     */
    public function before($user, $ability)
    {
        if($user->isAdmin() || $user->isCompany()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can create orders.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        if($user->isAdmin() && $order->company_id == null) {
            return true;
        }

        if($user->isCompany() && $user->company->id == $order->company_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can restore the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the order.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
