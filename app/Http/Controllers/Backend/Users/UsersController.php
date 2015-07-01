<?php

namespace App\Http\Controllers\Backend\Users;

use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserAccountRequest;
use App\Http\Requests\User\DeleteUsrRequest;
use App\Models\User;
use yajra\Datatables\Datatables;

class UsersController extends Controller
{

    /**
     * The user entity
     *
     * @var UserRepository
     */
    private $users;

    /**
     * @param UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.users.index');
    }

    /**
     * @return mixed
     */
    public function getDataTable()
    {

        $usrs = $this->users->with(['county'])->select('*');

        $data = Datatables::of($usrs)->addColumn('edit', function ($user) {
            return link_to(route('backend.users.edit', ['user' => $user->id]), 'Edit', ['data-target-model' => $user->id, 'class' => 'btn btn-xs btn-primary']);
        })->editColumn('updated_at', function ($user) {
            return $user->updated_at->diffForHumans();
        })->editColumn('created_at', function ($user) {
            return $user->created_at->diffForHumans();
        })->editColumn('first_name', function ($user) {
            return beautify($user->first_name);
        })->editColumn('last_name', function ($user) {
            return beautify($user->last_name);
        });

        return $data->make(true);
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
        $this->data = $this->users->createAccount($accountRequest->except('accept'), false);

        return $this->handleRedirect($accountRequest, route('backend.users.index'));
    }

    /**
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('backend.users.edit', compact('user'));
    }

    /**
     * @param CreateUserAccountRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function update(CreateUserAccountRequest $request, User $user)
    {
        $this->data = $user->update($request->all());

        return $this->handleRedirect($request);

    }

    /**
     * @param DeleteUsrRequest $request
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(DeleteUsrRequest $request, User $user)
    {
        $this->data = $user->delete();

        return $this->handleRedirect($request, route('backend.users.index'));
    }

}