<?php

namespace App\Http\Controllers\Backend\Security;

use App\Antony\DomainLogic\Modules\Security\RolesRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Security\RolesRequest;
use Illuminate\Http\Request;
use Response;


class RolesController extends Controller
{
    /**
     * The roles repository
     *
     * @var \app\Antony\DomainLogic\Modules\Security\RolesRepository
     */
    protected $role;

    /**
     * @param RolesRepository $rolesRepository
     */
    public function __construct(RolesRepository $rolesRepository)
    {
        $this->role = $rolesRepository;
    }

    /**
     * Display a listing of the resource.
     * GET /roles
     *
     * @return Response
     */
    public function index()
    {
        $roles = $this->role->paginate();

        return view('backend.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     * GET /roles/create
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     * POST /roles
     *
     * @return Response
     */
    public function store(RolesRequest $request)
    {
        $role = $this->role->add($request->except('permissions'));

        $this->role->givePermissions($role->id, $request->get('permissions'));

        flash('Role was created successfully');

        return redirect(action('Backend\RolesController@index'));
    }

    /**
     * Display the specified resource.
     * GET /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->role->find($id);

        return view('backend.roles.edit', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     * GET /roles/{id}/edit
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->role->find($id);

        return view('backend.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /roles/{id}
     *
     * @param Request $request
     * @param  int $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|alpha_dash|between:2,30|unique:roles,id,' . $request->user()->roles->implode('id'),
            ]
        );

        $role = $this->role->find($id)->update($request->all());

        flash('The role was successfully updated');

        return redirect(action('Backend\RolesController@index'));
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /roles/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        if ($this->role->delete([$id])) {
            flash()->success('The role was successfully deleted');

            return redirect(action('Backend\RolesController@index'));
        }

        flash()->error('Delete failed. Please try again later');

        return redirect()->back();

    }

}