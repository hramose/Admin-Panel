<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 08.02.15
 * Time: 16:23
 */

namespace Cinject\AdminPanel\Controllers;

use App\User;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Http\Request;
use Nayjest\Grids\EloquentDataProvider;
use Nayjest\Grids\FieldConfig;
use Nayjest\Grids\FilterConfig;
use Nayjest\Grids\Grid;
use Nayjest\Grids\GridConfig;

class UserController extends BaseController
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $userModel;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $roleModel;

    /**
     * @var \Illuminate\Contracts\Auth\Registrar $registrar
     */
    private $registrar;


    /**
     * @param \Illuminate\Contracts\Auth\Registrar $registrar
     */
    function __construct(Registrar $registrar)
    {
        $this->userModel = app(config('auth.model'));
        $this->roleModel = app(config('entrust.role'));
        $this->registrar = $registrar;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $grid = new Grid(
            (new GridConfig())
                ->setDataProvider(
                    new EloquentDataProvider(
                        $this->userModel->newQuery()
                    )
                )
                ->setColumns([
                    (new FieldConfig('name', 'Название'))
                        ->setCallback(function ($value, $vl) {
                            return link_to_route('admin.user.edit', $value, $vl->getSrc());
                        })
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)
                        ),
                    (new FieldConfig('email'))
                        ->setSortable(true)
                        ->addFilter(
                            (new FilterConfig)->setOperator(FilterConfig::OPERATOR_EQ)
                        ),
                    (new FieldConfig('created_at', 'Дата создания'))
                        ->setSortable(true)
                        ->setCallback(function (\Carbon\Carbon $value) {
                            return $value->toDateString();
                        })
                        ->addFilter(
                            (new FilterConfig)->setOperator(FilterConfig::OPERATOR_LIKE)
                        ),
                    (new FieldConfig('roles', 'Роли'))
                        ->setCallback(function ($value) {
                            return implode(', ', $value->lists('display_name'));
                        })
                    ,
                ])
        );

        return view('adminPanel::user.index', compact('grid'));
    }

    public function edit($id)
    {
        $user = $this->userModel->findOrFail($id);

        $rolesList = $this->roleModel->lists('name', 'id');

        return view('adminPanel::user.edit', compact('user', 'rolesList'));
    }

    public function update(Request $request, $id)
    {
        $user = $this->userModel->findOrFail($id);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if($request->has('password'))
            $data['password'] = bcrypt($request->get('password'));

        $user->update($data);
        $user->roles()->sync($request->get('roles', []));

        return redirect()->back();
    }

}