<?php
/**
 * Created by PhpStorm.
 * User: cinject
 * Date: 09.02.15
 * Time: 3:39
 */

namespace Cinject\AdminPanel\Controllers;


use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class BaseController extends Controller {
    use DispatchesCommands, ValidatesRequests;
}