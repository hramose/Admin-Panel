<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 22.06.2015
 * Time: 18:22
 */

namespace Cinject\AdminPanel\Controllers;

use Cinject\AdminPanel\Requests\RoleRequest;
use Illuminate\Http\Request;
use Nayjest\Grids\FilterConfig;

class RoleController extends BaseController{

    protected $roleModel;

    function __construct()
    {
        $this->roleModel = app(config('entrust.role'));
    }

    public function index()
    {
        $cfg = [
            'src'=>$this->roleModel->query(),
            'columns'=>[
                [
                    'name' => 'name',
                    'label' => 'Имя',
                    'sortable'=>true,
                    'filter' => [
                        'name' => 'name',
                        'operator' => FilterConfig::OPERATOR_LIKE,
                    ],
                    'callback'=>function($val) {return $val;}
                ],
                [
                    'name'=>'display_name',
                    'label'=>'Отображаемое имя',
                    'sortable'=>true,
                    'filter'=>['name'=>'display_name','operator'=>FilterConfig::OPERATOR_LIKE],
                ],
                'description',
                [
                    'name'=>'actions',
                    'label'=>'',
                    'callback'=>function($val, $row) {
                        return '
                            <a data-method="delete" href="'.route('admin.role.destroy', ['role'=>$row->getSrc()]).'">
                                <span class="glyphicon glyphicon-trash"></span>
                            </a>
                            <a href="'.route('admin.role.edit',['role'=>$row->getSrc()]).'">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </a>';
                    }
                ],
            ],
        ];
        $grid = \Grids::make($cfg);
        return view('adminPanel::role.index',compact('grid'));
    }

    public function create()
    {
        return view('adminPanel::role.create');
    }

    public function store(Request $request)
    {
        $this->roleModel->create($request->all());

        return redirect()->route('admin.role.index');
    }

    public function destroy($role)
    {
        $role->delete();

        return redirect()->back();
    }

    public function edit($role)
    {
        return view('adminPanel::role.edit', compact('role'));
    }

    public function update(RoleRequest $request, $role)
    {
        $role->update($request->all());

        return redirect()->route('admin.role.index');
    }
}