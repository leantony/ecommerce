<?php namespace app\Antony\DomainLogic\Modules\Checkout;

use Illuminate\Http\Request;

trait CheckoutRedirector
{

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getStepDoneResponse(Request $request)
    {
        $success = $this->getSuccessStatus();

        if ($success) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Action completed successfully', 'stepData' => $this->retrieveStepData(), 'target' => $this->redirectBack ? url(app('url')->previous()) : route($this->nextStepRoute)]);
            } else {
                flash()->overlay('Action completed successfully');

                return $this->redirectBack ? redirect()->back() : redirect()->route($this->nextStepRoute);
            }
        } elseif (is_null($success)) {
            if ($request->ajax()) {
                return response()->json(['message' => "You had already done this step", 'stepData' => $this->retrieveStepData(), 'target' => route($this->nextStepRoute)]);
            }
            flash()->overlay("You had already done this step");

            return redirect()->route($this->nextStepRoute);

        } else {

            if ($request->ajax()) {
                return response()->json(['message' => 'An error occurred. Please try again', 'stepData' => $this->retrieveStepData()]);
            }
            flash()->error('An error occurred. Please try again');

            return redirect()->back()->withInput($request->all());
        }
    }

    /**
     * @return bool|null
     */
    public function getSuccessStatus()
    {

        if ($this->getStepStatus() === AbstractCheckoutProcessor::STEP_COMPLETE) {
            return true;
        } elseif ($this->getStepStatus() === AbstractCheckoutProcessor::STEP_ALREADY_DONE) {
            return null;
        } else {
            return false;
        }
    }
}