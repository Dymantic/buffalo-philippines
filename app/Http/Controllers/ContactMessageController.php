<?php

namespace App\Http\Controllers;

use App\Notifications\ContactMessageReceived;
use App\Secretary;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{

    public function create()
    {
        return view('front.contact.page');
    }

    public function store(Secretary $secretary)
    {
        request()->validate([
           'name' => 'required',
            'email' => 'required|email',
            'enquiry' => 'required'
        ]);

        $secretary->notify(new ContactMessageReceived(request()->all(['name', 'email', 'enquiry'])));
    }
}
