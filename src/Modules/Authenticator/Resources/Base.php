<?php

namespace Src\Modules\Authenticator\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
