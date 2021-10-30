<?php

namespace App\Join\Repositories;

use App\EloquentModel\Join;
use App\Join\Repositories\JoinRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Auth;


class EloquentJoinRepository implements JoinRepository
{
    /**
     * すでにJoinされている投稿を全て取得
     * @return array
     */
    public function getAllJoinedPost(): array
    {
        return Join::all()->pluck('post_id')->toArray();
    }

    /**
     * セッションを取得
     * @param int
     * @return Collection
     */
    public function getJoined(int $id) :Collection
    {
        return Join::find($id);
    }



    /**
     * ログインユーザーに紐づくセッションを全て取得
     * @return Collection
     */
    public function getAllSessionByUser() :Collection
    {
        return Join::orderBy('post_start', 'asc')
            ->where('from_user_id', \Auth::user()->id)
            ->orWhere('to_user_id', \Auth::user()->id)
            ->get();
    }
}
