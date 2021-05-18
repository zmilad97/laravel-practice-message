<?php

namespace App\Http\Controllers;

use App\Models\Message;
use File;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Ramsey\Uuid\Generator\RandomGeneratorFactory;
use ZanySoft\Zip\Zip;
use ZipArchive;

class MessageController extends Controller
{
    use WithPagination;

    public function allMessages()
    {
        $currentUser = \Auth::user();
        $messages = Message::where('receiver', $currentUser->id)->paginate(10);
        return view('allMessages', compact('messages'));
    }

    public function getMessageById($id)
    {
        $currentUser = \Auth::user();
        $message = Message::where('id', $id)->first();
        if ($message->receiver == $currentUser->id) {
            return view('single-message', compact(['message']));
        }
    }


    public function getMessageFiles($messageId)
    {

        $message = Message::where('id', $messageId)->first();
        $files = explode(',', $message->files);
        $messageFilesNames = [];
        if (count($files) > 0) {
            $filesId = \array_diff($files, ['']);
            foreach ($filesId as $id) {
                $f = \App\Models\File::where('id', $id)->first();
                array_push($messageFilesNames, $f->name);
            }
        }
        $zip = new ZipArchive;
        $zipName = rand(100, 999) . time() . '.zip';
        if ($zip->open(public_path($zipName), ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $fls = File::files(storage_path('app/public/files'));
            foreach ($fls as $key => $value) {
                $flname = pathinfo($value);
                if (in_array($flname['basename'], $messageFilesNames))
                    $zip->addFile($value, $flname['basename']);
            }
            $zip->close();
            return response()->download(public_path($zipName));
        }
    }


    public function test()
    {
        $filename = 'file.zip';
        $zip = new ZipArchive();
        $zip->open(public_path($filename), ZipArchive::CREATE | ZipArchive::OVERWRITE);
//        $zip->addFile(public_path('favicon.ico'));
        $zip->close();
        return response()->download(public_path($filename));

    }
}
