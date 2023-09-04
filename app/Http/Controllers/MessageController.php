<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Message;
use App\Events\NewMessage;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function getParticipants(Request $request)
{
    // Récupérez l'utilisateur actuellement authentifié
     // Récupérez l'utilisateur actuellement authentifié
     $user = $request->id_auth;
     $participantsWithLastMessages = [];

     // Retrieve the IDs of participants based on messages
     $participantIds = Message::where(function ($query) use ($user) {
         $query->where('from', $user)
             ->orWhere('to', $user);
     })->pluck('from', 'to')->toArray();

     // Combine the sender and receiver IDs to get all participants
     $participantIds = array_merge(array_values($participantIds), array_keys($participantIds));
     // Remove duplicates
     $participantIds = array_unique($participantIds);

     // Retrieve user information for the participants
     $participants = User::whereIn('user_id', $participantIds)->where('user_id','!=',$user)->get();

     foreach ($participants as $participant){

        $participantId = $participant->user_id;

     $lastMessage = Message::whereIn('from', [$user, $participantId])
     ->whereIn('to', [$user, $participantId])
     ->orderBy('created_at', 'desc')
     ->first();



 $participantsWithLastMessages[] = [
     'user' => $participant,
     'last_message' => $lastMessage,
 ];};
     return response()->json(['participants' => $participantsWithLastMessages]);
}

    public function getMessages(Request $request)
    {
        // Récupérez l'utilisateur actuellement authentifié
         // Récupérez l'utilisateur actuellement authentifié
         $auth = $request->id_auth;
         $user = $request->id_user;

        $messages = Message::where(function ($query) use ($user, $auth) {
            $query->where('from', $user)
                ->where('to', $auth);
        })->orWhere(function ($query) use ($user, $auth) {
            $query->where('from', $auth)
                ->where('to', $user);
        })->orderBy('created_at', 'asc')->get();
        return response()->json([
            'messages' => $messages,
        ]);
    }
    public function store(Request $request)
{
    $from = $request->from;
    $to = $request->to;
    $content=$request->content;
     // Get the authenticated user

     $message = new Message();
     $message->content = $content;
     $message->from =$from; // L'ID de l'expéditeur
     $message->to = $to; // L'ID du destinataire
     $message->save();

     event(new NewMessage($message));
    return response()->json($message, 201);
}

}
