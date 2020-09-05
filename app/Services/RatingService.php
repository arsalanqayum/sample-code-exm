<?php

namespace App\Services;

use App\OwnerChat;
use App\OwnerRating;

class RatingService
{
    /**
     * Check if the incoming parameter is invalid rating from 1 - 5, can be string
     *
     * @param string|int $rating
     * @return bool
     */
    private function isValidRating($rating)
    {
        $ratings = ['1', '2', '3', '4', '5'];

        return in_array($rating, $ratings);
    }

    /**
     * Give rating to owner from buyer owner chat
     *
     * @param string|int $rating
     * @param OwnerChat $ownerChat
     * @return void
     */
    public function giveRating($rating, OwnerChat $ownerChat)
    {
        if($this->isValidRating($rating)) {
            $ownerRating = new OwnerRating;
            $ownerRating->fill(['rating' => (int)$rating ]);
            $ownerRating->user_id = $ownerChat->user_id;
            $ownerRating->owner_chat_id = $ownerChat->id;
            if($ownerRating->save()) {
                $ownerChat->status = OwnerChat::TERMINATED;
                $ownerChat->save();
            }
        }
    }
}