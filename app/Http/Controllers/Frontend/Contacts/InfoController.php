<?php

namespace App\Http\Controllers\Frontend\Contacts;

use app\Antony\DomainLogic\Modules\Contact\ContactMessageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessage\ContactMessageRequest;

class InfoController extends Controller
{

    /**
     * @var ContactMessageRepository
     */
    private $msg;

    /**
     * @param ContactMessageRepository $contactMessageRepo
     */
    public function __construct(ContactMessageRepository $contactMessageRepo)
    {

        $this->msg = $contactMessageRepo;

        $this->useOverlay = true;
    }

    /**
     * Display the about page
     *
     * @return \Illuminate\View\View
     */
    public function getAbout()
    {
        return view('frontend.info.about');
    }


    /**
     * Display the terms of agreement page
     *
     * @return \Illuminate\View\View
     */
    public function getTerms()
    {
        return view('frontend.info.policy');
    }


    /**
     * Display the contact page
     *
     * @return \Illuminate\View\View
     */
    public function getContact()
    {
        return view('frontend.info.contact');
    }

    /**
     * Save a contact message
     *
     * @param ContactMessageRequest $request
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function postContactMessage(ContactMessageRequest $request)
    {
        $this->data = $this->msg->send($request->except("_session, g-recaptcha-response"));

        $this->setSuccessMessage("Your message was sent successfully. Thank you");

        return $this->handleRedirect($request);
    }

}
