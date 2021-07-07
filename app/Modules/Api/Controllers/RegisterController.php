<?php
namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Enums\StatusCode;
use App\Models\User;
use App\Http\Requests\RegisterUser;
use Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function store(RegisterUser $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->sex = $request->sex;
        if ($user->save()) {
            return response()->json(['status' => StatusCode::OK], StatusCode::OK);
        }
        return response()->json(['status' => StatusCode::INTERNAL_ERR], StatusCode::INTERNAL_ERR);
    }
}
