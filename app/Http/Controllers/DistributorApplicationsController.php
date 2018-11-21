<?php

namespace App\Http\Controllers;

use App\DistributorApplicationMessage;
use Dymantic\Secretary\Secretary;
use Illuminate\Http\Request;

class DistributorApplicationsController extends Controller
{
    public function store(Secretary $secretary)
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'country' => 'required',
            'application_message' => 'required'
        ]);

        $message = new DistributorApplicationMessage($data);

        $secretary->receive($message);
    }
}
