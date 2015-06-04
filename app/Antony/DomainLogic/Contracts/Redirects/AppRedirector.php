<?php namespace app\Antony\DomainLogic\Contracts\Redirects;

interface AppRedirector
{

    /**
     * Handle a redirect after an operation
     *
     * @param $request
     *
     * @return mixed
     */
    public function handleRedirect($request);
}