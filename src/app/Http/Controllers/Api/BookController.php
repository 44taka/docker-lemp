<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookCollection;
use App\Http\Resources\Api\BookResource;
use App\Http\Requests\Api\BookRequest;
use App\Services\Api\BookService;

class BookController extends Controller
{
    private BookService $book_service;

    public function __construct(BookService $book_service)
    {
        $this->book_service = $book_service;
    }

    /**
     * 一覧取得
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $book = $this->book_service->find($request->query('title'));
        return new BookCollection($book);
    }

    /**
     * 詳細取得
     *
     * @param integer $id
     * @return Response
     */
    public function show(int $id)
    {
        $book = $this->book_service->find_by_id($id);
        if (is_null($book)) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }
        return new BookResource($book);
    }

    /**
     * 新規登録
     *
     * @param BookRequest $request
     * @return Response
     */
    public function create(BookRequest $request)
    {
        $is_result = $this->book_service->create($request);
        if (!$is_result) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }
        return response()->json(null, Response::HTTP_CREATED);
    }

    /**
     * 更新
     *
     * @param BookRequest $request
     * @param integer $id
     * @return Response
     */
    public function update(BookRequest $request, int $id)
    {
        $is_result = $this->book_service->update($request, $id);
        if (!$is_result) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 削除
     *
     * @param integer $id
     * @return Response
     */
    public function delete(int $id)
    {
        $is_result = $this->book_service->delete($id);
        if (!$is_result) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
