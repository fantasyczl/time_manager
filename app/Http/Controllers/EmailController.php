<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;

class EmailController extends Controller
{
    //

    public function getEmail() {
        return view('auth.email');
    }

    public function postEmail(Request $request) {
        $to = $request->input('to');
        $subject = $request->input('subject');
        $body = $request->input('body');

        if (empty($to) || empty($subject) || empty($body)) {
            return back()->withInput();
        }

        Mail::raw($body, function($message) use ($to, $subject) {
            $message->to($to);
            $message->subject($subject);
        });
    }
}
