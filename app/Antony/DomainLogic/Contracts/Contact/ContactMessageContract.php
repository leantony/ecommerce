<?php namespace app\Antony\DomainLogic\Contracts\Contact;

interface ContactMessageContract
{

    /**
     * Sends the contact message
     *
     * @param $data
     *
     * @return mixed
     */
    public function send($data);
}