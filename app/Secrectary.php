<?php


namespace App;


use Illuminate\Notifications\Notifiable;

class Secretary
{
    use Notifiable;

    public $email;
    public $slack;

    public function __construct($contact_points)
    {
        $this->email = $contact_points['email'];
        $this->slack = $contact_points['slack'];
    }

    public function getKey()
    {
        return 1;
    }

    public function routeNotificationForSlack()
    {
        return $this->slack;
    }
}