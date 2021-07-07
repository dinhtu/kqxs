<?php
namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Enums\StatusCode;
use App\Models\User;
use Request;
use JWTAuth;
class UsersController extends Controller
{
    public function getCurrentUser()
    {
        $userInfo = JWTAuth::user();
        return response()->json($userInfo, StatusCode::OK);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate($request->token);
            return response()->json(['User logged out successfully'], StatusCode::OK);
        } catch (JWTException $exception) {
            return response()->json(['Sorry, the user cannot be logged out'], StatusCode::SERVER_ERROR);
        }
    }

    public function index() {
        return response()->json([], StatusCode::OK);
    }
}
