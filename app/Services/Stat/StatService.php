<?php
namespace App\Services\Stat;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatService
{
    /**
     * conversation stats
     *
     * @return array
     */
    public function getConversationStat()
    {
        $currentConversation    =    DB::table('buyer_owner_chats')->where('chat_lead_status','!=','terminated')->where('owner_reply_to_request','yes')->whereDate('created_at', Carbon::today())->count();
        $dailyConversation      =    DB::table('buyer_owner_chats')->where('owner_reply_to_request','yes')->whereDate('created_at', Carbon::today())->count();
        $weeklyConversation     =    DB::table('buyer_owner_chats')->where('owner_reply_to_request','yes')->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->count();
        $totalConversation      =    DB::table('buyer_owner_chats')->where('owner_reply_to_request','yes')->count();
        return [
            'currentConversation'   =>  $currentConversation,
            'dailyConversation'     =>  $dailyConversation,
            'weeklyConversation'    =>  $weeklyConversation,
            'totalConversation'     =>  $totalConversation
        ];
    }

    /**
     * last conversation
     *
     * @return \Illuminate\Support\Collection
     */
    public function conversationListing()
    {
        return $lastConversation =  DB::table('buyer_owner_chats')
            ->join('buyers','buyer_owner_chats.buyer_id','=','buyers.id')
            ->join('users','buyer_owner_chats.owner_id','=','users.id')
            ->where('owner_reply_to_request','yes')->whereDate('buyer_owner_chats.created_at', Carbon::today())->get();
    }
    /**
     * Undocumented function
     *
     * @return void
     */
    public function leadListing()
    {
        return $lastConversation =  DB::table('buyer_owner_chats')
        ->join('buyers','buyer_owner_chats.buyer_id','=','buyers.id')
        ->join('users','buyer_owner_chats.owner_id','=','users.id')
        ->where('owner_reply_to_request','yes')->whereDate('buyer_owner_chats.created_at', Carbon::today())->get();

      return $lastConversation =  DB::table('buyer_owner_chats')
          ->join('buyers','buyer_owner_chats.buyer_id','=','buyers.id')
          ->join('users','buyer_owner_chats.owner_id','=','users.id')
          ->where('owner_reply_to_request','yes')->whereDate('buyer_owner_chats.created_at', Carbon::today())->get();
    }
}
