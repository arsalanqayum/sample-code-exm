<?php

namespace App\Filters;

class UserFilter extends Filter
{
    /**
     * Fields that can be filters
     *
     * @var array
     */
    protected $filters = ['age_range', 'gender', 'communication_type', 'time_to_chat'];

    /**
     * Filter users by age range
     *
     * @param string $age_range
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function age_range($age_range)
    {
        if($age_range) {
            return $this->builder->whereHas('profile', function($query) use($age_range) {
                $query->where('age_range', $age_range);
            });
        }

        return $this->builder;
    }

    /**
     * Filter users by gender
     *
     * @param string $gender
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function gender($gender)
    {
        if($gender) {
            return $this->builder->whereHas('profile', function($query) use($gender) {
                $query->where('gender', $gender);
            });
        }

        return $this->builder;
    }

    /**
     * Filter users by communication type profile
     *
     * @param string $communication_type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function communication_type($communication_type)
    {
        if($communication_type) {
            return $this->builder->whereHas('profile', function($query) use($communication_type) {
                $query->where('communication_type', $communication_type);
            });
        }

        return $this->builder;
    }

    /**
     * Filter users by time to chat
     *
     * @param string $time_to_chat
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function time_to_chat($time_to_chat)
    {
        if($time_to_chat) {
            return $this->builder->whereHas('profile', function($query) use($time_to_chat) {
                $query->where('time_to_chat', $time_to_chat);
            });
        }

        return $this->builder;
    }
}