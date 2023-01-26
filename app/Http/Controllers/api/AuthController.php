<?php

namespace App\Http\Controllers\api;

use App\Helpers\FlashMessage\FlashMessageParameters;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

use Laravel\Passport\PersonalAccessTokenResult;
use Throwable;


class AuthController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = collect($request->validated());

        if (!auth()->attempt($credentials->toArray())) {
            return FlashMessageParameters::error([
                'message' => 'Şifre hatalı.'
            ], 401)->toJson();
        }

        /** @var User $user */
        $user = auth()->user();

        $tokenResult = $this->getToken($user);

        return FlashMessageParameters::success([
            'message' => 'Giriş işlemi başarılı .',
            'user_id' => $user->id,
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ])->toJson(['Authorization' => $tokenResult->accessToken]);
    }

    /**
     * @param  RegisterRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $attributes = collect($request->validated());

        $password = $attributes->get('password');
        $attributes->put('password', bcrypt($password));

        throw_unless(User::query()->create($attributes->toArray()), \Exception::class, 'Bir Sorun Oluştu!');

        return FlashMessageParameters::success([
            'message' => 'Başarılı bir şekilde kayıt işlemi tamamlanmıştır .'
        ])->toJson();
    }

    /**
     * @param  LogoutRequest  $request
     * @return JsonResponse
     */
    public function logout(LogoutRequest $request): JsonResponse
    {
        $request->validated();

        /** @var User $user */
        $user = auth()->user();

        $user->token()->revoke();

        return FlashMessageParameters::success([
            'message' => 'Çıkış Başarılı.'
        ])->toJson();
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->token()->revoke();

        $tokenResult = $this->getToken($user);

        return FlashMessageParameters::success([
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ])->toJson(['Authorization' => $tokenResult->accessToken]);
    }

    /**
     * @return JsonResponse
     */
    public function user(): JsonResponse
    {
        $user = auth()->user();

        return FlashMessageParameters::success(UserResource::make($user))->toJson();
    }

    /**
     * @param  User|null  $user
     * @return PersonalAccessTokenResult
     */
    public function getToken(?User $user): PersonalAccessTokenResult
    {
        $tokenResult = $user->createToken('Personal Access Token');

        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addYears(10);
        $token->save();

        return $tokenResult;
    }
}
