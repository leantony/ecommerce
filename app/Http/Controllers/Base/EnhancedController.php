<?php namespace app\Http\Controllers\Base;

use app\Http\Controllers\Base\Redirectors\ErrorAction;
use app\Http\Controllers\Base\Redirectors\SuccessAction;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class EnhancedController extends BaseController
{

    use DispatchesCommands, ValidatesRequests, SuccessAction, ErrorAction;

    /**
     * The data returned by an action
     *
     * @var mixed
     */
    protected $data;

    /**
     * Specifies is we should use routes to redirect, after an action has been completed
     * If set to false, we default to urls
     *
     * @var boolean
     */
    protected $useRoutes = false;

    /**
     * Specifies if an AJAX request should redirect the user to some specified route.
     * This also needs to be handled at the client side
     *
     * @var boolean
     */
    protected $ajaxShouldRedirect = true;

    /**
     * Specifies if an AJAX request should return the results from an action as JSON
     * This also needs to be handled at the client side
     *
     * @var boolean
     */
    protected $returnDataAsJson = false;


    /**
     * Specifies if a user should be redirected to their previous url
     *
     * @var boolean
     */
    protected $redirectToUrlInSession = false;

    /**
     * @param bool $json
     * @return mixed
     */
    public function getData($json = true)
    {
        return $json ? $this->data->toJson() : $this->data;
    }

    /**
     * @param $request
     * @param array $params For an AJAX request only. This are any extra parameters, that will be sent with the JSON response
     * @param null $successRoute The route the user should be redirected to, if an action is successful. If left null, the page would simply reload
     * @param null $errorRoute The route a user should be redirected to, if an error occurs. If not specified, the page simply reloads
     * @return mixed
     */
    public function handleRedirect($request, $successRoute = null, $errorRoute = null, $params = [])
    {

        if (in_array($this->data, $this->errorConditions, true)) {

            return $this->executeErrorHandler($request, $errorRoute, $params);
        }

        return $this->executeSuccessHandler($request, $params, $successRoute);
    }

    /**
     * Get the previous url the user had visited.
     *
     * @return string
     */
    public function getPreviousUrl()
    {
        return \URL::previous();
    }
}