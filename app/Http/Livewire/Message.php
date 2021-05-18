<?php

namespace App\Http\Livewire;

use http\Env\Request;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Message extends Component
{
    public $sender;
    public $receivers = [];
    public $title = '';
    public $body = '';
    public $users;
    public $receiver;
    public $filesnames = [];

    use WithFileUploads;

    public function sendMessage()
    {
        $this->validate([
            'receivers' => 'required',
            'title' => 'required',
            'body' => 'required']);
        $files = '';
        foreach ($this->filesnames as $filename) {
            $fl = $filename->store('files', 'public');
            $fl = str_replace(['files/'], '', $fl);
            $data['name'] = $fl;
            $fl = \App\Models\File::create($data);
            $files .= $fl->id . ",";
        }

        $currentUser = \Auth::user();
        foreach ($this->receivers as $receiver) {
            $this->receiver = $receiver;
            $message = ['sender' => $currentUser->id,
                'receiver' => $receiver,
                'files' => $files,
                'title' => $this->title,
                'body' => $this->body
            ];


            \App\Models\Message::create($message);
        }
        $this->emit('message-sent');
        return back()->with('message_sent', "Message Has Been Sent Successfully");
    }

    public function render()
    {
        $currentUser = \Auth::user();

        if (\Auth::user()->hasRole('admin'))
            $this->users = \App\Models\User::all();
        if (\Auth::user()->hasRole('accountant'))
            $this->users = \App\Models\User::role('user')->get();
        return view('livewire.message', ['users' => $this->users, 'currentUser' => $currentUser->id]);
    }
}
