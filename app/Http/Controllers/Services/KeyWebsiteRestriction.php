<?php

namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;
use App\Http\Requests\Services\Key\Restrictions\Website\Delete;
use App\Http\Requests\Services\Key\Restrictions\Website\Listing;
use App\Http\Requests\Services\Key\Restrictions\Website\Store;
use App\Http\Requests\Services\Key\Restrictions\Website\Update;
use App\Models\Services\KeyWebsiteRestriction as KeyWebsiteRestrictionModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KeyWebsiteRestriction extends Controller
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
                'results' => KeyWebsiteRestrictionModel::create([
                    'key_id' => $request->key_id,
                    'website' => $request->website,
                    'redirect_link' => $request->name,
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
                    'data' => KeyWebsiteRestrictionModel::with(['key'])
                        ->search($request->search)
                        ->whereWebsite($request->website)
                        ->whereRedirectLink($request->redirect_link)
                        ->whereKeyOwnerID(auth()->user()->id)
                        ->whenLimit($request->limit)
                        ->whenOffset($request->offset)
                        ->whenOrderBy($request->orderBy)
                        ->get()
                        ->toArray(),
                    'total' => KeyWebsiteRestrictionModel::count(),
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
                'results' => KeyWebsiteRestrictionModel::with(['key'])
                    ->search($request->search)
                    ->whereWebsite($request->website)
                    ->whereRedirectLink($request->redirect_link)
                    ->whereKeyOwnerID(auth()->user()->id)
                    ->whenOrderBy($request->orderBy)
                    ->paginate($request->limit ?? KeyWebsiteRestrictionModel::count())
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
                'results' => tap(KeyWebsiteRestrictionModel::whereWebsiteID($request->id)->with(['key']))->update([
                    'website' => $request->website,
                    'redirect_link' => $request->name,
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
                'results' => KeyWebsiteRestrictionModel::whereWebsiteID($request->id)->delete(),
                'prompt' => 'success',
            ], 200
        );
    }
}
