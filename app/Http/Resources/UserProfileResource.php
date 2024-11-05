<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  mixed $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'email' => $this->email,
            'status' => $this->status,
            'employee_code' => $this->profile->employee_code ?? null,
            'first_name' => $this->profile->first_name ?? null,
            'last_name' => $this->profile->last_name ?? null,
            'phone_number' => $this->profile->phone_number ?? null,
            'date_of_birth' => $this->profile->date_of_birth ?? null,
            'gender' => $this->profile->gender ?? null,
            'avatar_url' => $this->profile->avatar_url ?? null,
            'language' => $this->profile->language ?? null,
            'address' => $this->profile->address ?? null,
            'departments' => $this->departments->map(function ($department) {
                return [
                    'id' => $department->id,
                    'name' => $department->name,
                ];
            }),
        ];
    }
}
