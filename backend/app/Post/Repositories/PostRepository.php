<?php

namespace App\Post\Repositories;

use App\EloquentModel\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

Interface PostRepository
{
    /**
     * 投稿を取得
     * @param int $id
     * @return Post
     */
    public function getPostId(int $id): Post;

    /**
     * ユーザーに紐づく投稿を一つ取得
     * @param int $post_id
     * @return Post
     */
    public function getPostIdByUser($post_id): Post;

    /**
     * ユーザーに紐づく投稿を取得
     * @return Collection
     */
    public function getPostByUser(): Collection;

    /**
     * 選択している投稿を取得
     * @param int
     * @return Collection
     */
    public function getRequestPostId($postId): Collection;

    /**
     * ジョインされていない投稿を全て取得
     * @param array $joinedPostIds
     * @return LengthAwarePaginator
     */
    public function getPostIdsExclusionJoinedPost(array $joinedPostIds): LengthAwarePaginator;

    /**
     * 投稿検索
     * @param string $work
     * @param string $start
     * @param array $joinedPostIds
     * @return LengthAwarePaginator
     */
    public function searchPost(string $work, string $start, array $joinedPostIds): LengthAwarePaginator;
}
