<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22.06.2015
 * Time: 18:22
 */

namespace Cinject\AdminPanel\Controllers;

use App\User;
use Cinject\AdminPanel\Requests\RoleRequest;
use Illuminate\Http\Request;
use Nayjest\Grids\Components\THead;
use Nayjest\Grids\FilterConfig;

class RoleController extends BaseController
{

    protected $roleModel;
    protected $userModel;

    function __construct()
    {
        $this->roleModel = app(config('entrust.role'));
        $this->userModel = app(config('auth.model'));
    }

    public function index()
    {
        $cfg = [
            'src' => $this->roleModel->query(),
            'columns' => [
                [
                    'name' => 'name',
                    'label' => 'Имя',
                    'sortable' => true,
                    'filter' => [
                        'name' => 'name',
                        'operator' => FilterConfig::OPERATOR_LIKE,
                    ],
                ],
                [
                    'name' => 'display_name',
                    'label' => 'Отображаемое имя',
                    'sortable' => true,
                    'filter' => ['name' => 'display_name', 'operator' => FilterConfig::OPERATOR_LIKE],
                ],
                [
                    'name' => 'users',
                    'label' => 'Пользователи',
                    'callback' => function ($val) {
                        $names = $val->lists('name');

                        return implode(', ', $names);
                    }
                ],
                [
                    'name' => 'actions',
                    'label' => '',
                    'callback' => function ($val, $row) {
                        return '
                            <a href="' . route('admin.role.edit', ['role' => $row->getSrc()]) . '">
                                <span class="glyphicon glyphicon-pencil"></span></a>
                            <a data-method="delete" href="' . route('admin.role.destroy', ['role' => $row->getSrc()]) . '">
                                <span class="glyphicon glyphicon-trash"></span></a>';
                    }
                ],
            ],
            'footer' => ['component' => ['total_rows']]
        ];
        $grid = \Grids::make($cfg);

        return view('adminPanel::role.index', compact('grid'));
    }

    public function create()
    {
        $users = $this->userModel->lists('name', 'id');

        return view('adminPanel::role.create', compact('users'));
    }

    public function store(RoleRequest $request)
    {
        $role = $this->roleModel->create($request->all());
        $role->users()->attach($request->input('users'));

        return redirect()->route('admin.role.index')->withMessage('Роль "' . $role->name . '" успешно создана');
    }

    public function edit($role)
    {
        $users = User::lists('name', 'id');
        $user_list = $role->users->lists('id');

        return view('adminPanel::role.edit', compact('role', 'users', 'user_list'));
    }

    public function update(RoleRequest $request, $role)
    {
        $role->update($request->all());
        $role->users()->sync($request->input('users', []));

        return redirect()->route('admin.role.index')->withMessage('Роль "' . $role->name . '" успешно обновлена');
    }

    public function destroy($role)
    {
        $role->delete();

        return redirect()->back();
    }
}