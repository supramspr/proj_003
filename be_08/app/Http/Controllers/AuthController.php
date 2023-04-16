<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'loginx', 'register']]);
    }

    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:4|confirmed',
        ]);
        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if ($request->type == 'google') {
            $ch = curl_init();
            $url = "https://oauth2.googleapis.com/tokeninfo?" . "id_token=" . $request->input('id_token');
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_outputs = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $server_output = json_decode($server_outputs, true);
            if (count($server_output) < 5) {
                return $this->apiResponse(false, 'Token Not Match', null, 401);
            } else {
                $user = User::where('email', $server_output["email"])->first();
                if (!$user) {
                    // return response()->json(['error' => 'Unauthorized'], 401);
                    return $this->apiResponse(true, 'Akun anda belum terdaftar, silahkan hubungi administrator.', null, 401);
                }
                $token = JWTAuth::fromUser($user);
                $email = $server_output["email"];
            }
        } else {

            if (env('APP_ENV') == 'local'){

                $user = User::where('email', $request->email)->first();
                if (!$user) {
                    // return response()->json(['error' => 'Unauthorized'], 401);
                    return $this->apiResponse(true, 'Akun anda belum terdaftar, silahkan hubungi administrator.', null, 401);
                }
                $token = JWTAuth::fromUser($user);
            } else {
                $credentials = request(['email', 'password']);

                if (!$token = auth()->attempt($credentials)) {
                    return $this->apiResponse(true, 'Username dan password anda tidak sesuai', null, 401);
                    // return response()->json(['error' => 'Unauthorized'], 401);
                }
            }
            
            $email = $request->email;
        }


        return $this->respondWithToken($token, $email);
    }

    public function loginx(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            // return response()->json(['error' => 'Unauthorized'], 401);
            return $this->apiResponse(true, 'Akun anda belum terdaftar, silahkan hubungi administrator.', null, 401);
        }
        $token = JWTAuth::fromUser($user);
        $email = $request->email;
        return $this->respondWithToken($token, $email);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $id =auth()->id();
        $data = User::find($id);
        $data->token = null;
        $data->save();
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $email)
    {
        $user = User::select('menuroles as roles')->where('email', '=', $email)->first();
        $user1 = User::where('email', '=', $email)->first();
        $user1->token = $token;
        $user1->save();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'roles' => $user->roles,
            'data' => $user1,
        ]);
    }
}
