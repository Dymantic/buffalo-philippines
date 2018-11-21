<?php


namespace App;


use Dymantic\Secretary\SecretaryMessage;

class DistributorApplicationMessage implements SecretaryMessage
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function sender()
    {
        return $this->data['name'];
    }

    public function senderEmail()
    {
        return $this->data['email'];
    }

    public function body()
    {
        return 'An application to be a distributor has been received. The details are below.';
    }

    public function messageNotes()
    {
        return [
            'country' => $this->data['country'],
            'message' => $this->data['application_message']
        ];
    }

    public function toDataArray()
    {
        return [
            'name'          => $this->data['name'],
            'email'         => $this->data['email'],
            'message_body'  => $this->body(),
            'message_notes' => json_encode($this->messageNotes())
        ];
    }
}