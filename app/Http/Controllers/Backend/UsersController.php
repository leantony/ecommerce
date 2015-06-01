<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\User\Base\UserEntity;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserAccountRequest;
use App\Http\Requests\User\DeleteUsrRequest;

class UsersController extends Controller
{

    /**
     * The user entity
     *
     * @var UserEntity
     */
    private $user;

    /**
     * @param UserEntity $users
     */
    public function __construct(UserEntity $users)
    {
        $this->user = $users;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = $this->user->get();

        return view('backend.users.index', compact('users'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * @param CreateUserAccountRequest $accountRequest
     * @return $this|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function store(CreateUserAccountRequest $accountRequest)
    {
        $this->data = $this->user->create($accountRequest->except('accept'));

        return $this->handleRedirect($accountRequest, route('backend.users.index'));
    }

    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->user->retrieve($id);

        return view('backend.users.edit', compact('user'));
    }


    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->user->retrieve($id);

        return view('backend.users.edit', compact('user'));
    }

    /**
     * @param CreateUserAccountRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(CreateUserAccountRequest $request, $id)
    {
        $this->data = $this->user->edit($id, $request->all());

        return $this->handleRedirect($request, route('backend.users.index'));

    }

    /**
     * @param DeleteUsrRequest $request
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function destroy(DeleteUsrRequest $request, $id)
    {
        $this->data = $this->user->delete($id);

        return $this->handleRedirect($request, route('backend.users.index'));
    }

}