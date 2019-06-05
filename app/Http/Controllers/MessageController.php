<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function addMessage(Request $request)
    {

    
        DB::table("messages")->insert(["recipientId"=>$request->recipientId,
                                        "senderId"=>5,
                                        "text"=>$request->text,
                                        "state"=>"unread",
                                        "object"=>$request->object,
                                        "created_at"=>date('Y-m-d h-i-s')]);
        return $this->sendConfirmation("Message enregistré!", 200);
    }

    //public function getAll

    public function getAllSentMessages($senderId)
    {
        $messages = DB::table('messages')->where('senderId', $senderId)->get();
        return $this->sendResult($messages, 200);
    }

    public function getAllReceivedMessages($recipientId){
        $messages = DB::table('messages')->where("recipientId", $recipientId)->get();
        return $this->sendResult($messages, 200);
    }

    public function getUnreadMessages($recipientId)
    {
        $messages = DB::table('messages')->where(['recipientId'=>$recipientId, "state" => "unread"])->get();
        return $this->sendResult($messages, 200);
    }
    
}
