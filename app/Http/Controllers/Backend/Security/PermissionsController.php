<?php

namespace App\Http\Controllers\Backend\Security;

use App\Antony\DomainLogic\Modules\Security\PermissionsRepo;
use App\Http\Controllers\Controller;
use App\Http\Requests\Security\ModifyAcl;
use App\Http\Requests\Security\PermissionsRequest;
use Response;

class PermissionsController extends Controller
{
    /**
     * The permissions repository
     *
     * @var \app\Antony\DomainLogic\Modules\Security\PermissionsRepo
     */
    protected $permission;

    public function __construct(PermissionsRepo $permissionsRepo)
    {

        $this->permission = $permissionsRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $permissions = $this->permission->paginate(['roles']);

        return view('backend.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionsRequest $request
     *
     * @return Response
     */
    public function store(PermissionsRequest $request)
    {
        // create the permission
        $result = $this->permission->add($request->except('roles'));

        // attach a role to it
        $this->permission->assign($result->id, $request->get('roles'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ModifyAcl $request
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(ModifyAcl $request, $id)
    {
        if ($this->permission->delete([$id])) {

            flash('The permission has been removed');

            return redirect()->action('Backend\PermissionsController@index');
        }

        flash()->error('Delete failed');

        return redirect()->back();
    }

}
