<?php

namespace App\Services;

use App\Buyer;
use App\Facades\Twilio;
use App\OwnerChat;
use App\OwnerChatMessage;
use App\User;
use App\VideoRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;

class ChatService
{
    /** @var RatingService */
    public $ratingService;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Finish chats between owner and visitor
     *
     * @param string $ownerPhoneNumber
     * @param string $visitorPhoneNumber
     * @return void
     */
    public function finishChat($ownerPhoneNumber, $visitorPhoneNumber)
    {
        $body = 'Conversation Finished';

        Twilio::sendSMS($ownerPhoneNumber, $body);
        Twilio::sendSMS($visitorPhoneNumber, $body);
    }

    /**
     * Send sms to owner to give rating to owner
     *
     * @param string $visitorPhoneNumber
     * @return void
     */
    public function askVisitorForFeedback($visitorPhoneNumber)
    {
        $body = 'Conversation finished. Give feedback to owner by reply 1 to 5';

        Twilio::sendSMS($visitorPhoneNumber, $body);
    }

    /**
     * Check if conversation in waiting for feedback and visitor send 1-5
     *
     * @param mixed $request
     * @return void
     */
    public function checkIfBuyerGiveFeedback($request)
    {
        $buyer = Buyer::ofPhone($request['From'])->first();

        if($buyer && $ownerChat = OwnerChat::where(['buyer_id' => $buyer->id, 'status' => OwnerChat::WAITING_FEEDBACK])->first()) {
            $this->ratingService->giveRating($request['Body'], $ownerChat);
        }
    }

    /**
     * Check if an owner reply from buyer invitation
     *
     * @param Request $request
     */
    public function checkOwnerApproval(Request $request)
    {
        $reply = Str::lower($request['Body']);

        $owner = User::ofPhone($request['From'])->first();

        //Check if owner exist
        if($owner) {
            $ownerChat = OwnerChat::where(['user_id' => $owner->id, 'status' => 'pending'])->first();

            //Check if owner chat is exist and the owner reply yes
            if($ownerChat && $reply == 'yes') {
                $this->sendConnectedMessage($ownerChat);

                $this->terminatedOtherOwners($ownerChat);
            }

            //Terminate Chat if owner reply no
            if($ownerChat && $reply == 'no') {
                $ownerChat->status = OwnerChat::TERMINATED;
                $ownerChat->save();
            }
        }
    }

    /**
     * Listen for chat between owner and buyer
     *
     * @param Request $request
     */
    public function listenForChat(Request $request)
    {
        $owner = User::ofPhone($request['From'])->first();

        $buyer = Buyer::ofPhone($request['From'])->first();

        $this->sendOwnerChatMessage($owner,'user', $request['Body']);
        $this->sendOwnerChatMessage($buyer,'buyer', $request['Body']);
    }

    /**
     * Send sms to owner and buyer if they are connected each other
     *
     * @param OwnerChat $ownerChat
     * @param string $type
     * @return void
     */
    private function sendConnectedMessage(OwnerChat $ownerChat)
    {
        if($ownerChat->type == 'sms') {
            $ownerBody = __('sms.sms_chat', ['recipient' => 'buyer']);
            $buyerBody = __('sms.sms_chat', ['recipient' => 'owner']);

            Twilio::sendSMS($ownerChat->user->phone, $ownerBody);
            Twilio::sendSMS($ownerChat->buyer->phone, $buyerBody);
        }

        if($ownerChat->type == 'video') {
            $roomName = $ownerChat->user->email."_".$ownerChat->buyer->email;

            $ownerToken = Twilio::generateVideoRoom(
                $roomName,
                $ownerChat->user->email,
            );

            $buyerToken = Twilio::generateVideoRoom(
                $roomName,
                $ownerChat->buyer->email,
            );

            $ownerVideoRoom = VideoRoom::create([
                'token' => $ownerToken,
                'name' => $roomName
            ]);

            $buyerVideoRoom = VideoRoom::create([
                'token' => $buyerToken,
                'name' => $roomName
            ]);

            $ownerLink = config('app.frontend_url')."/video_rooms/{$ownerVideoRoom->uuid}";
            $buyerLink = config('app.frontend_url')."/video_rooms/{$buyerVideoRoom->uuid}";

            $ownerBody = __('sms.video_chat', ['recipient' => 'buyer', 'link' => $ownerLink]);
            $buyerBody = __('sms.video_chat', ['recipient' => 'owner', 'link' => $buyerLink]);

            Twilio::sendSMS($ownerChat->user->phone, $ownerBody);
            Twilio::sendSMS($ownerChat->buyer->phone, $buyerBody);
        }

        $this->updateChatAfterSendConnection($ownerChat);
    }

    /**
     * Start a chat by type chat, video or sms
     *
     * @param OwnerChat $ownerChat
     * @param string $type
     */
    private function updateChatAfterSendConnection(OwnerChat $ownerChat)
    {
        //Save the owner chat to in progress, and turn the owner chat available to not_available
        $ownerChat->status = OwnerChat::IN_PROGRESS;

        if($ownerChat->save()) {
            $user = $ownerChat->user;

            $user->chat_status = 'busy';
            $user->save();
        }
    }

    /**
     * Terminated other owners if the first owner reply yes
     *
     * @param OwnerChat $ownerChat
     * @return void
     */
    private function terminatedOtherOwners(OwnerChat $ownerChat)
    {
        DB::table('owner_chats')
        ->where([
            'buyer_id' => $ownerChat->buyer_id,
            'status' => 'pending'
        ])->update(['status' => OwnerChat::TERMINATED]);
    }

    /**
     * Send message if owner chat exist
     *
     * @param mixed $sender owner/buyer
     * @param string $column primary key column
     * @param string $body
     * @return void
     */
    private function sendOwnerChatMessage($sender, $column, $body)
    {
        if($sender) {
            $ownerChat = OwnerChat::where(["{$column}_id" => $sender->id, 'status' => OwnerChat::IN_PROGRESS])->first();

            if($ownerChat) {

                // Check if sender ( owner or buyer ) want to end the conversation
                if($body == '99') {
                    $this->finishOwnerChat($ownerChat);
                } else {
                    $ownerChatMessage = new OwnerChatMessage();
                    $ownerChatMessage->body = $body;
                    $ownerChatMessage->from = $column == 'user' ? 'owner' : 'buyer';
                    $ownerChatMessage->owner_chat_id = $ownerChat->id;
                    $ownerChatMessage->save();

                    Twilio::sendSMS(
                        $ownerChat[$column == 'user' ? 'buyer' : 'user']->phone,
                        $body,
                    );

                    if($column == 'user') {
                        Event::dispatch('owner_send_chat', $ownerChat);
                    }
                }
            }
        }
    }

    /**
     * Finish owner chat
     *
     * @param OwnerChat $ownerChat
     * @return void
     */
    private function finishOwnerChat(OwnerChat $ownerChat)
    {
        $ownerChat->status = OwnerChat::WAITING_FEEDBACK;
        $ownerChat->save();

        $body = 'Conversation Finished';

        // $this->createOrder($ownerChat);

        Twilio::sendSMS($ownerChat->user->phone, $body);

        // Ask send conversation finish and ask for feedback
        $this->askVisitorForFeedback($ownerChat->buyer->phone);
    }
}