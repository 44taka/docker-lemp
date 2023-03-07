<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorController extends Controller
{
    /**
     * 一覧取得
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Author::get());
    }

    /**
     * 詳細取得
     *
     * @param integer $id
     * @return Response
     */
    public function show($id)
    {
        $author = Author::find($id);
        if (is_null($author)) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }
        return response()->json($author);
    }
}
