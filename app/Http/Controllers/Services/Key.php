<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\Key\Delete;
use App\Http\Requests\Services\Key\Listing;
use App\Http\Requests\Services\Key\Store;
use App\Http\Requests\Services\Key\Update;
use App\Models\Services\Key as KeyModel;
use App\Models\UserKey as UserKeyModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Src\Modules\Authenticator\Interfaces\Base as Authenticator;

class Key extends Controller
{
    public function __construct(
        protected Authenticator $auth,
    ) {
    }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Store $request): JsonResponse
    {
        do {
            $key = Str::random(60);
        } while (KeyModel::whereKeyKey($key)->exists());

        $key = KeyModel::create([
            'name' => $request->name,
            'key' => $key,
            'state' => 1,
        ]);
        $response = $this->auth->tokenInfo($request->bearerToken());
        
        UserKeyModel::create([
            'key_id' => $key->id,
            'user_id' => $response->json('id'),
        ]);

        return response()->json(
            [
                'status' => 'success',
                'results' => KeyModel::with(['user'])->whereKey($key)->first(),
                'prompt' => 'success',
            ], 200
        );
    }

    public function list(Listing $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => [
                    'data' => KeyModel::with(['user', 'websites', 'ip_addresses'])
                        ->search($request->search)
                        ->whereWebsite($request->website)
                        ->whereRedirectLink($request->redirect_link)
                        ->whereIpAddress($request->ip_address)
                        ->whereKeyOwnerID(auth()->user()->id)
                        ->whenLimit($request->limit)
                        ->whenOffset($request->offset)
                        ->whenOrderBy($request->orderBy)
                        ->get()
                        ->toArray(),
                    'total' => KeyModel::count(),
                ],
                'prompt' => 'success',
            ], 200
        );
    }

    public function paginateList(Listing $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => KeyModel::with(['websites', 'ip_addresses'])
                    ->search($request->search)
                    ->whereWebsite($request->website)
                    ->whereRedirectLink($request->redirect_link)
                    ->whereIpAddress($request->ip_address)
                    ->whereKeyOwnerID(auth()->user()->id)
                    ->whenOrderBy($request->orderBy)
                    ->paginate($request->limit ?? KeyModel::count())
                    ->toArray(),
                'prompt' => 'success',
            ], 200
        );
    }

    public function update(Update $request): JsonResponse
    {
        $data = [
            'name' => $request->name,
        ];

        if ($request->generate_key) {
            do {
                $key = Str::random(60);
            } while (KeyModel::whereKeyKey($key)->exists());
            $data['key'] = $key;
        }

        return response()->json(
            [
                'status' => 'success',
                'results' => tap(KeyModel::whereKeyID($request->id))->update($data)->first()->toArray(),
                'prompt' => 'success',
            ], 200
        );
    }

    public function delete(Delete $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => KeyModel::whereKeyID($request->id)->delete(),
                'prompt' => 'success',
            ], 200
        );
    }
}
