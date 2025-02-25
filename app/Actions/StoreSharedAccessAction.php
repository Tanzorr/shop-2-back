<?php

namespace App\Actions;

use App\Contracts\MutationActionInterface;
use App\Models\Models\User;
use App\Models\SharedAccess;

class StoreSharedAccessAction implements MutationActionInterface
{
    public function handle(array $data): mixed
    {
        $data['accessible_type'] = SharedAccess::ACCESS_TYPE_MAP[$data['accessible_type']];
        $sharedAccess = SharedAccess::create($data);

        return User::find($sharedAccess->user_id);
    }
}
