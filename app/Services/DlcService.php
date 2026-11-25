<?php

namespace App\Services;

use App\Models\User;
use App\Models\Dlc;
use App\Models\UserDlc;

class DlcService
{
    public function claim(User $user, Dlc $dlc): bool
    {
        $record = UserDlc::firstOrCreate([
            'user_id' => $user->id,
            'dlc_id' => $dlc->id,
        ]);

        return $record->wasRecentlyCreated;
    }

    public function getLibrary(User $user)
    {
        return $user->dlcs()
            ->with(['game', 'category'])
            ->orderByPivot('granted_at', 'desc')
            ->get();
    }
}