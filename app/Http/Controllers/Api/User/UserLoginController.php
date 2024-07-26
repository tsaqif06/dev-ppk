<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Helpers\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserLoginController extends Controller
{
    /**
     * @OA\Post(
     *     path="/user/login",
     *     tags={"Authentication User"},
     *     summary="Login user",
     *     description="Endpoint untuk login user with endpoint '/api/v2'",
     *     operationId="loginUser",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="username",
     *                      type="string",
     *                      description="Username for login",
     *                      default="induk",
     *                  ),
     *                  @OA\Property(
     *                      property="password",
     *                      type="string",
     *                      format="password",
     *                      description="Password for login",
     *                      default="12345678"
     *                  )
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     )
     * )
     */
    public function loginUser(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'username' => ['required','exists:users,username'],
                'password' => ['required'],
            ]);

            if ($validate->fails()) {
                $error = $validate->errors();
                return ApiResponse::errorResponse('Validation failed', 422, $error->all());
            }


            $user = User::where('username', $request->username)->first();

            $attempt = [
              'username' => $request->username,
              'password' => $request->password
            ];
            if ($token = $this->guard()->attempt($attempt)) {
                return ApiResponse::successResponse(
                    'Login Successfully',
                    collect($user)->except( 'created_at', 'updated_at'),
                    false,
                    ['token' => $this->respondWithToken($token)]
                );
            }

            return ApiResponse::errorResponse('Unauthorized', 401, 'Account not found');
        } catch (\Throwable $e) {
            return ApiResponse::errorResponse('Failed to login account', 500, $e->getMessage());
        }
    }
    protected function respondWithToken($token) :array
    {
        $ttlInSeconds = $this->guard()->factory()->getTTL() * env('JWT_TTL',60);
        $expiryDateTime = Carbon::now()->addSeconds($ttlInSeconds);
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' =>$expiryDateTime->format('Y-m-d H:i:s')
        ];
    }
    public function guard()
    {
        return Auth::guard("api-v2");
    }

    /**
     * @OA\Get(
     *     path="/user/logout",
     *     tags={"Authentication User"},
     *     summary="Logout user",
     *     description="Logout the authenticated user",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     * )
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * @OA\Get(
     *     path="/user/refresh",
     *     tags={"Authentication User"},
     *     summary="Refresh JWT token",
     *     description="Refresh the JWT token",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
}
