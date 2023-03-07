<?php

namespace App\Services\Api;

use Illuminate\Support\Collection;

use App\Models\Author;
use App\Models\Book;
use App\Http\Requests\Api\BookRequest;

class BookService
{
    private Book $book_model;
    private Author $author_model;

    public function __construct(Book $book_model, Author $author_model)
    {
        $this->book_model = $book_model;
        $this->author_model = $author_model;
    }

    /**
     * 検索
     *
     * @param string|null $title
     * @return Collection
     */
    public function find($title): Collection
    {
        $query = $this->book_model->with('author');
        if (!is_null($query)) {
            $query = $query->where('title', 'LIKE', '%' . $title . '%');
        }
        return $query->get();
    }

    /**
     * タイトル部分一致検索
     *
     * @param string $title
     * @return Collection
     */
    public function find_by_title($title): Collection
    {
        return $this->book_model
                    ->with('author')
                    ->where('title', 'LIKE', '%' . $title . '%')
                    ->get();
    }

    /**
     * ID検索
     *
     * @param integer $id
     * @return Book|null
     */
    public function find_by_id($id): Book|null
    {
        return $this->book_model->with('author')->find($id);
    }

    /**
     * 新規登録
     *
     * @param BookRequest $request
     * @return boolean
     */
    public function create(BookRequest $request): bool
    {
        // authorの存在チェック
        $author = $this->author_model
            ->where('id', $request->author_id)
            ->first();
        if (is_null($author)) {
            return false;
        }
        $this->book_model->create([
            'title' => $request->title,
            'author_id' => $request->author_id,
        ]);
        return true;
    }

    /**
     * 更新
     *
     * @param BookRequest $request
     * @param integer $id
     * @return boolean
     */
    public function update(BookRequest $request, int $id): bool
    {
        // book, authorの存在チェック
        $book = $this->book_model->find($id);
        $author = $this->author_model
            ->where('id', $request->author_id)
            ->first();
        if (is_null($book) && is_null($author)) {
            return false;
        }
        return $book->update([
                'title' => $request->title,
                'author_id' => $request->author_id,
            ]);
    }

    /**
     * 削除
     *
     * @param integer $id
     * @return boolean
     */
    public function delete(int $id): bool
    {
        $book = $this->book_model->find($id);
        if (!is_null($book)) {
            return $book->delete();
        }
        return true;
    }
}
