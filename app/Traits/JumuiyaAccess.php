<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

trait JumuiyaAccess
{
    protected function getChairpersonJumuiya()
    {
        $userId = Auth::id();
        $cacheKey = "jumuiya_for_chairperson_{$userId}";
        
        return Cache::remember($cacheKey, now()->addMinutes(60), function () {
            return Auth::user()->jumuiyas()->first();
        });
    }

    protected function verifyJumuiyaAccess($jumuiyaId)
    {
        $jumuiya = $this->getChairpersonJumuiya();
        
        if (!$jumuiya || $jumuiya->id !== $jumuiyaId) {
            return false;
        }

        return true;
    }

    protected function verifyMemberBelongsToJumuiya($memberId)
    {
        $jumuiya = $this->getChairpersonJumuiya();
        
        if (!$jumuiya) {
            return false;
        }

        return $jumuiya->members()->where('id', $memberId)->exists();
    }
}
