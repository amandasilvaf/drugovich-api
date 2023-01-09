<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    { 
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|int',
            // 'profile' => 'string'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role_id' => $request->input('role_id')
            // 'profile' => $request->input('profile')
        ]);

        return response()->json($user, Response::HTTP_CREATED);
    }

    /**
     * Handle the login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();

            $role = Role::find($user->role_id);

            $permissions = $role->permissions;

            $permissionsName = [];

            foreach($permissions as $permission){
                array_push($permissionsName,$permission->name );
            }

            
            $token = $user->createToken('authToken', $permissionsName, Carbon::now()->addDays(2))->plainTextToken;
            
         

            // if($user->profile == 'gerente_nivel_1'){
            //     $token = $user->createToken('authToken', 
            //     ['client-list','client-read','client-store','client-update','client-delete','client-search', 
            //     'group-list','group-read','group-search',
            //     'group-client-list','group-client-add','group-client-remove'
            //     ], Carbon::now()->addDays(2))->plainTextToken;
            // }

            // if($user->profile == 'gerente_nivel_2'){
            //     $token = $user->createToken('authToken', 
            //     ['client-list','client-read','client-store','client-update','client-delete','client-search', 
            //     'group-list','group-read','group-search','group-store','group-update','group-delete',
            //     'group-client-list','group-client-add','group-client-remove'
            //     ], Carbon::now()->addDays(2))->plainTextToken;
            // }

            // $token = $user->createToken('authToken', ['*'], Carbon::now()->addDays(1))->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        } else {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 422);
        }
    }

   
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout efetuado. Access token removido.'
        ]);
    }
}
