<?php

namespace App\Repositories\Join;

use Illuminate\Database\Eloquent\Collection;

Interface JoinRepository
{
    /**
     * すでにJoinされている投稿を全て取得
     * @return array
     */
    public function getAllJoinedPost() :array;

    /**
     * セッションを取得
     * @param int
     * @return Collection
     */
    public function getJoined(int $id) :Collection;

    /**
     * ログインユーザーに紐づくセッションを全て取得
     * @return Collection
     */
    public function getAllSessionByUser() :Collection;
}
