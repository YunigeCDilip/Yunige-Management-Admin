<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Message;
use App\Models\MessageDetail;
use Illuminate\Bus\Queueable;
use App\Mail\SendMessageEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendMessageDetail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    private $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MessageDetail $message)
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
        $messageModel = Message::find($this->message->message_id);
        $data['subject'] = $messageModel->subject;
        $data['messages'] = $this->message->message;
        $receiver = User::find($messageModel->sender_id);
        $data['receiver'] = $receiver->name;
        if($receiver->email != ''){
            Mail::to($receiver->email)->send(new SendMessageEmail($data));
        }
    }
}
