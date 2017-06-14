<?php

namespace App\Http\Controllers\Api\V2;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;

class UserController extends BaseController
{
    /**
     * 获取用户详情
     * @param $id
     * @return \Dingo\Api\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * 获取用户列表
     * @return \Dingo\Api\Http\Response
     */
    public function index()
    {
        $users = User::paginate(25);
        return $this->response->paginator($users,new UserTransformer());
    }
}