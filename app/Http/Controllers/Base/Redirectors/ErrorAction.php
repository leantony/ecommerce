<?php namespace app\Http\Controllers\Base\Redirectors;

use Illuminate\Http\Request;

trait ErrorAction
{

    /**
     * An error message
     *
     * @var string
     */
    protected $errorMessage = 'The operation failed. Please check your data input, and try again.';

    /**
     * Conditions that should merit an error
     *
     * @var array
     */
    protected $errorConditions = [false, -1, null];

    /**
     * This is a wrapper behind the AJAX and normal request handlers
     *
     * @param Request $request
     * @param $route
     * @param array $params
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function executeErrorHandler(Request $request, $route, $params = [])
    {
        return $request->ajax() ? $this->getJsonErrorResponse(422, $params) : $this->handleErrorWithFlashMessage($request->all(), $route);
    }

    /**
     * Returns a JSON response back to the client
     *
     * @param int $code
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJsonErrorResponse($code = 422, $params = [])
    {
        $target = is_null(array_get($params, 'target')) ? $this->getPreviousUrl() : array_pull($params, 'target');

        return response()
            ->json([
                'message' => [$this->getErrorMessage()],
                'responseData' => $this->returnDataAsJson ? $this->getData() : null,
                'target' => $target,
                $params

            ], $code);
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;
    }

    /**
     * Handles an error by displaying a flash message, and redirecting a user to a specified route/url
     *
     * @param null $route
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleErrorWithFlashMessage($data, $route = null)
    {

        flash()->error($this->getErrorMessage());

        // default to a page reload
        if (is_null($route)) {

            return redirect()->back()->withInput($data);
        }
        // use routes for a redirect, or simple urls. don't let the param name confuse you
        return $this->useRoutes ? redirect()->route($route) : redirect()->to($route);

    }
}