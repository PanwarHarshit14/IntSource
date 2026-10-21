<?php

namespace App\Http\Controllers;

use App\Models\Contact;

abstract class Controller
{
    public $contact;

    public function __construct()
    {
        $this->contact = $contact = Contact::first();
        view()->share(compact('contact'));
    }
}
