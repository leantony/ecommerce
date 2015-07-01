<?php

namespace App\Http\Controllers\Frontend\Reviews;

use app\Antony\DomainLogic\Modules\Reviews\ReviewsRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reviews\ReviewProductRequest;

class ReviewsController extends Controller
{

    /**
     * @var reviewsRepository
     */
    private $productReviews;

    /**
     * @param ReviewsRepository $productReviews
     */
    public function __construct(ReviewsRepository $productReviews)
    {

        $this->productReviews = $productReviews;
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // $reviews = $this->productReviews->get();
        return redirect()->back();
    }

    /**
     * Allows users to submit a product review
     *
     * @param ReviewProductRequest $request
     * @param $productID
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(ReviewProductRequest $request, $productID)
    {
        $data = array_add($request->all(), 'product_id', $productID);

        $this->data = $this->productReviews->add($data);

        $this->setSuccessMessage("Your review was saved");

        return $this->handleRedirect($request);
    }


    /**
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Allows users to update their reviews
     *
     * @param ReviewProductRequest $request
     * @param $id
     *
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(ReviewProductRequest $request, $id)
    {
        $this->data = $this->productReviews->edit($id, $request->all());

        $this->setSuccessMessage("Your review has been updated");

        return $this->handleRedirect($request);
    }

}