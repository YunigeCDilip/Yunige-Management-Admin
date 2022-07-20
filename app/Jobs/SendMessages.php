<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Message;
use Illuminate\Bus\Queueable;
use App\Mail\SendMessageEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data['sender'] = User::find($this->message->sender_id);
        $messageModel = Message::find($this->message->id);
        $data['subject'] = $messageModel->subject;
        $data['messages'] = $messageModel->message;
        $users = User::whereHas('messages', function($query) use($messageModel){
            $query->where('message_id', $messageModel->id);
        })->where('active_status', true)->get();

        if($users){
            foreach($users as $user){
                $data['receiver'] = $user->name;
                if($data['sender']->id != $user->id){
                    if($user->email != ''){
                        Mail::to($user->email)->send(new SendMessageEmail($data));
                    }
                }
            }
        }
        $messageModel->sent = true;
        $messageModel->save();
    }
}
