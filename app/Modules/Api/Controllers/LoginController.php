<?php
namespace App\Modules\Api\Controllers;

use App\Http\Controllers\Controller;
use App\Enums\StatusCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function login(Request $request) {

        $credentials = $request->only('email', 'password');

        try {
            $token = JWTAuth::attempt($credentials);
            if (!$token) {
                $data = [
                    'eMsg' => 'User name or mail address is not registered.',
                ];
                return response()->json($data, StatusCode::SERVER_ERROR);
            }
            $userInfo = JWTAuth::user();
            $data = [
                'accountInfo' => [
                    'accountId' => $userInfo->id,
                    'accountName' => $userInfo->name,
                ],
                'meta' => [
                    'token' => $token,
                    'period' => env('JWT_TTL', 60) / (60 * 24),
                    'latestUpdate' => Carbon::now()->format('Y-m-d H:i:s'),
                ],
                'sendTo' => "chat",
            ];
            return response()->json($data, StatusCode::OK);
        } catch (JWTAuthException $e) {
            $data = [
                'eMsg' => 'failed_to_create_token',
            ];
            return response()->json($data, StatusCode::SERVER_ERROR);
        }
    }
}
