<?php

namespace App\Post\Repositories;

use App\EloquentModel\Post;
use App\Post\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentPostRepository implements PostRepository
{
    /**
     * 投稿を取得
     * @param int $id
     * @return Post
     */
    public function getPostId(int $id): Post
    {
        return Post::find($id);
    }

    /**
     * ユーザーに紐づく投稿を一つ取得
     * @param int $post_id
     * @return Post
     */
    public function getPostIdByUser($post_id): Post
    {
        return Post::where('user_id', Auth::user()->id)->find($post_id);
    }

    /**
     * ユーザーに紐づく投稿を取得
     * @return Collection
     */
    public function getPostByUser(): Collection
    {
        return Post::where('user_id', Auth::user()->id)->get();
    }

    /**
     * 選択している投稿を取得
     * @param int
     * @return Collection
     */
    public function getRequestPostId($postId): Collection
    {
        return Post::where('id', '=', $postId)->first();
    }

    /**
     * ジョインされていない投稿を全て取得
     * @param array $joinedPostIds
     * @return LengthAwarePaginator
     */
    public function getPostIdsExclusionJoinedPost(array $joinedPostIds): LengthAwarePaginator
    {
        $posts = Post::orderBy('start', 'asc')
            ->whereNotIn('id',$joinedPostIds)
            ->paginate(12);
        return $posts;
    }

    /**
     * 投稿検索
     * @param string $work
     * @param string $start
     * @param array $joinedPostIds
     * @return LengthAwarePaginator
     */
    public function searchPost(string $work = null, string $start = null, array $joinedPostIds): LengthAwarePaginator
    {
        return Post::where('work_type', 'like', "%{$work}%")
            ->where('start', 'like', "%{$start}%")
            ->whereNotIn('id',$joinedPostIds)
            ->orderBy('created_at', 'desc')
            ->paginate(12);
    }
}
