<?php

namespace App\Http\Controllers;

use App\DistributorApplicationMessage;
use Dymantic\Secretary\Secretary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DistributorApplicationsController extends Controller
{
    public function store(Secretary $secretary)
    {
        sleep(3);
        Notification::fake();
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'country' => '',
            'company' => '',
            'website' => '',
            'application_message' => 'required',
            'referrer' => '',
        ]);

        $message = new DistributorApplicationMessage($data);

        $secretary->receive($message);
    }
}
