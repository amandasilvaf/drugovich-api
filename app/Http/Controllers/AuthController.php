<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    /**
     * Handle the register request.
     *
     * @param  AuthRegisterRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRegisterRequest $request)
    { 
        $request->validated();

        $role = Role::find($request->input('role_id'));

        if (!$role) {
            return response()->json(['error' => 'Perfil não existe na base de dados'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $request->input('role_id')
            ]);
            return response()->json($user, Response::HTTP_CREATED);
        }catch(Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Handle the login request.
     *
     * @param  AuthLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthLoginRequest $request)
    {
        $request->validated();

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $role = Role::find($user->role_id);

            $permissions = $role->permissions;

            $permissionsName = [];

            foreach($permissions as $permission){
                array_push($permissionsName,$permission->name );
            }
            
            $token = $user->createToken('authToken', $permissionsName, Carbon::now()->addDays(1))->plainTextToken;
         
            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'message' => 'Credenciais inválidas',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

   
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout efetuado com sucesso.'
        ]);
    }
}
