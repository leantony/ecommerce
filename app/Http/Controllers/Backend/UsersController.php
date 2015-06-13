<?php namespace App\Http\Controllers\Backend;

use app\Antony\DomainLogic\Modules\User\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserAccountRequest;
use App\Http\Requests\User\DeleteUsrRequest;
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
            return link_to(route('backend.users.edit', ['id' => $user->id]), 'Edit', ['data-target-model' => $user->id, 'class' => 'btn btn-xs btn-primary']);
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
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = $this->users->get($id);

        return view('backend.users.edit', compact('user'));
    }


    /**
     * @param $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = $this->users->get($id);

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
        $this->data = $this->users->edit($id, $request->all());

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
        $this->data = $this->users->delete($id);

        return $this->handleRedirect($request, route('backend.users.index'));
    }

}