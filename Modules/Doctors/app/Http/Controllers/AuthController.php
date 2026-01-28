<?php

namespace Modules\Doctors\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JoinRequest;
use App\Models\TermCondition;
use App\Models\TermsAcceptance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Clients\app\Http\Requests\LoginRequest;
use Modules\Clients\app\Http\Requests\RegisterRequest;
use Modules\Clients\app\Transformers\LoginResource;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $doctor = JoinRequest::create([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'password'   => Hash::make($request->password),
                'type'       => 'doctor',
            ]);

            $termCondition = TermCondition::where('uuid', $request->terms_condition_uuid)->first();

            TermsAcceptance::create([
                'user_id' => $doctor->id,
                'terms_condition_id' => $termCondition->id,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'accepted_at' => now(),
            ]);

            $token = $doctor->createToken('api-token')->plainTextToken;

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء الحساب بنجاح',
                'data' => [
                    'token' => $token,
                    'doctor' => $doctor,
                ]
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء إنشاء الحساب',
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $login = $request->input('login');

            // Check if login is email or phone
            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

            // Find user by email or phone
            $user = User::where($fieldType, $login)->first();

            // Check if user exists
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'المستخدم غير موجود',
                ], 404);
            }


            if ($user->type !== 'client') {
                return response()->json([
                    'success' => false,
                    'message' => 'عذراً، هذا الحساب ليس حساب عميل',
                ], 403);
            }

            if ($user->is_active == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'حسابك غير مفعل. يرجى التواصل مع الدعم.',
                ], 403);
            }

            // Check password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'كلمة المرور غير صحيحة',
                ], 401);
            }

            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الدخول بنجاح',
                'data' => [
                    'user' => new LoginResource($user),
                    'token' => $token,
                ],
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء تسجيل الدخول',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json([
            'success' => true,
            'data' => [
                'user' => new LoginResource($user),
            ],
        ], 200);
    }



    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200);
    }
}
