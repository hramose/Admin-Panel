<?php

namespace Cinject\AdminPanel\Controllers;

use Cinject\AdminPanel\Requests\PermissionRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Nayjest\Grids\FilterConfig;

class PermissionController extends Controller
{
    protected $permissionModel;
    protected $roleModel;
    protected $userModel;

    function __construct()
    {
        $this->permissionModel = app(config('entrust.permission'));
        $this->roleModel = app(config('entrust.role'));
        $this->userModel = app(config('auth.model'));
    }

    public function index()
    {
        $cfg = [
            'src' => $this->permissionModel->query(),
            'columns' => [
                [
                    'name' => 'name',
                    'label' => 'Имя',
                    'sortable' => true,
                    'filter' => [
                        'name' => 'name',
                        'operator' => FilterConfig::OPERATOR_LIKE,
                    ],
                    'callback' => function ($val) {
                        return $val;
                    }
                ],
                [
                    'name' => 'display_name',
                    'label' => 'Отображаемое имя',
                    'sortable' => true,
                    'filter' => [
                        'name' => 'display_name',
                        'operator' => FilterConfig::OPERATOR_LIKE
                    ],
                ],
                [
                    'name' => 'roles',
                    'label' => 'Роли',
                    'callback' => function ($val) {
                        $list = $val->lists('display_name');

                        return implode(', ', $list);
                    }
                ],
                [
                    'name' => 'actions',
                    'label' => '',
                    'callback' => function ($val, $row) {
                        return '
                            <a href="' . route('admin.permission.edit', ['permission' => $row->getSrc()]) . '">
                                <span class="glyphicon glyphicon-pencil"></span></a>
                            <a data-method="delete" href="' . route('admin.permission.destroy',
                            ['permission' => $row->getSrc()]) . '">
                                <span class="glyphicon glyphicon-trash"></span></a>';
                    }
                ],
            ],
        ];
        $grid = \Grids::make($cfg);

        return view('adminPanel::permission.index', compact('grid'));
    }

    public function create()
    {
        $roles = $this->roleModel->lists('name', 'id');

        return view('adminPanel::permission.create', compact('roles'));
    }

    public function store(PermissionRequest $request)
    {
        $permission = $this->permissionModel->create($request->all());
        $permission->roles()->attach($request->input('roles'));

        return redirect()->route('admin.permission.index')->withMessage('Права успешно созданы');
    }

    public function edit($permission)
    {
        $roles = $this->roleModel->lists('name', 'id');
        $role_list = $permission->roles->lists('id');

        return view('adminPanel::permission.edit', compact('permission', 'roles', 'role_list'));
    }

    public function update(PermissionRequest $request, $permission)
    {
        $permission->update($request->all());
        $permission->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.permission.index')->withMessage('Права обновлены');
    }

    public function destroy($permission)
    {
        $permission->delete();

        return redirect()->back();
    }
}
