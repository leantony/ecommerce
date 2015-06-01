<?php namespace app\Http\Controllers\Base\Redirectors;

use Illuminate\Http\Request;

trait SuccessAction
{

    /**
     * Specifies if the success message should really be displayed
     *
     * @var boolean
     */
    protected $displaySuccessMessage = true;

    /**
     * Specifies if overlays should be used for success messages
     *
     * @var boolean
     */
    protected $useOverlay = false;

    /**
     * A success message
     *
     * @var string
     */
    protected $successMessage = 'The operation completed successfully.';

    /**
     * @param Request $request
     * @param $params
     * @param null $route
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function executeSuccessHandler(Request $request, $params, $route = null)
    {

        if ($request->ajax()) {

            if (!array_has($params, 'target')) {

                $params = array_add($params, 'target', $route);
            }
            return $this->getJsonSuccessResponse($params);
        }

        return $this->handleSuccessWithFlashMessage($route);
    }

    /**
     * @param array $params
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getJsonSuccessResponse($params = [])
    {

        $target = is_null(array_get($params, 'target')) ? $this->getPreviousUrl() : array_pull($params, 'target');
        return response()->json([
            'message' => $this->getSuccessMessage(),
            'responseData' => $this->returnDataAsJson ? $this->getData() : null,
            'target' => $target,
            $params
        ], 200);
    }

    /**
     * @return string
     */
    public function getSuccessMessage()
    {
        return $this->successMessage;
    }

    /**
     * @param string $successMessage
     */
    public function setSuccessMessage($successMessage)
    {
        $this->successMessage = $successMessage;
    }

    /**
     * @param null $route
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleSuccessWithFlashMessage($route = null)
    {
        if ($this->displaySuccessMessage) {

            $this->useOverlay ? flash()->overlay($this->getSuccessMessage()) : flash($this->getSuccessMessage());

        }

        if (is_null($route)) {

            return redirect()->back();
        }
        return $this->useRoutes ? redirect()->route($route) : redirect()->to($route);
    }
}