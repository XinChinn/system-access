<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\Key\Restrictions\IpAddress\Delete;
use App\Http\Requests\Services\Key\Restrictions\IpAddress\Listing;
use App\Http\Requests\Services\Key\Restrictions\IpAddress\Store;
use App\Http\Requests\Services\Key\Restrictions\IpAddress\Update;
use App\Models\Services\KeyIpAddressRestriction as KeyIpAddressRestrictionModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeyIpAddressRestriction extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Store $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => KeyIpAddressRestrictionModel::create([
                    'key_id' => $request->key_id,
                    'ip_address' => $request->ip_address,
                ]),
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
                    'data' => KeyIpAddressRestrictionModel::with(['key'])
                        ->search($request->search)
                        ->whereIpAddress($request->ip_address)
                        ->whereKeyOwnerID(auth()->user()->id)
                        ->whenLimit($request->limit)
                        ->whenOffset($request->offset)
                        ->whenOrderBy($request->orderBy)
                        ->get()
                        ->toArray(),
                    'total' => KeyIpAddressRestrictionModel::count(),
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
                'results' => KeyIpAddressRestrictionModel::with(['key'])
                    ->search($request->search)
                    ->whereIpAddress($request->ip_address)
                    ->whereKeyOwnerID(auth()->user()->id)
                    ->whenOrderBy($request->orderBy)
                    ->paginate($request->limit ?? KeyIpAddressRestrictionModel::count())
                    ->toArray(),
                'prompt' => 'success',
            ], 200
        );
    }

    public function update(Update $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => tap(KeyIpAddressRestrictionModel::whereIpAddressID($request->id)->with(['key']))->update([
                    'ip_address' => $request->ip_address,
                ]),
                'prompt' => 'success',
            ], 200
        );
    }

    public function delete(Delete $request): JsonResponse
    {
        return response()->json(
            [
                'status' => 'success',
                'results' => KeyIpAddressRestrictionModel::whereIpAddressID($request->id)->delete(),
                'prompt' => 'success',
            ], 200
        );
    }
}
