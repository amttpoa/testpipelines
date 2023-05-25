<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Livewire\Component;
// use Mail;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;
    public $success;
    protected $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'subject' => '',
        'message' => 'required|min:5',
    ];

    public function contactFormSubmit()
    {
        $contact = $this->validate();
        // dd($contact);

        $contact = new Contact();
        $contact->name = $this->name;
        $contact->email = $this->email;
        $contact->subject = $this->subject;
        $contact->message = $this->message;
        $contact->ip_address = \Request::ip();
        $contact->save();

        // Mail::send('email',
        // array(
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'message' => $this->message,
        //     ),
        //     function($message){
        //         $message->from('your_email@your_domain.com');
        //         $message->to('your_email@your_domain.com', 'Bobby')->subject('Your Site Contect Form');
        //     }
        // );

        $this->success = 'Thank you for reaching out to us!';

        $this->clearFields();
    }

    private function clearFields()
    {
        $this->name = '';
        $this->email = '';
        $this->subject = '';
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
