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
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'country' => '',
            'company' => '',
            'website' => '',
            'application_message' => 'required',
            'referrer' => '',
            'referrer_other' => ''
        ]);

        if($data['referrer'] === 'other' && request('referrer_other', false)) {
            $data['referrer'] = request('referrer_other');
        }

        $message = new DistributorApplicationMessage($data);

        $secretary->receive($message);
    }
}
