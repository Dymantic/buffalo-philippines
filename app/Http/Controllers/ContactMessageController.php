<?php

namespace App\Http\Controllers;

use App\Notifications\ContactMessageReceived;
use Dymantic\Secretary\ContactForm;
use Dymantic\Secretary\Secretary;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{

    public function create()
    {
        return view('front.contact.page');
    }

    public function store(Secretary $secretary, ContactForm $form)
    {
        $secretary->receive($form->contactMessage());
    }
}
