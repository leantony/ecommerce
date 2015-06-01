<?php namespace App\Http\Controllers\Frontend;

use app\Antony\DomainLogic\Modules\Contact\Base\ContactMessagesEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactMessage\ContactMessageRequest;

class InfoController extends Controller
{

    /**
     * @var ContactMessagesEntity
     */
    private $msg;

    /**
     * @param ContactMessagesEntity $contactMessageRepo
     */
    public function __construct(ContactMessagesEntity $contactMessageRepo)
    {

        $this->msg = $contactMessageRepo;
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
        return $this->msg->send($request->except("_session, g-recaptcha-response"))->handleRedirect($request);
    }

}
