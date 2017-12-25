<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{

	public function show()
    {

    	return view('contact.contact-form');
    }

    public function send(Request $request)
    {
    	$this->validate($request, [
        	'name' => 'required',
        	'title' => 'nullable',
        	'email' => 'required|email',
        	'reason' => 'required',
        	'message' => 'required'
        ]);
        
        Mail::send('email',
            array(
                   'name' => $request->get('name'),
                   'email' => $request->get('email'),
                   'title' => $request->get('reason').' - '.$request->get('title'),
                   'user_message' => $request->get('message')
               ), function($message)
           { 
               $message->to('olastivos@gmail.com', 'Admin')->subject('Test');
           });
 

        return back()->with('success', 'Το μήνυμα εστάλη επιτυχώς. Ευχαριστούμε για την επικοινωνία!');
    }
}
