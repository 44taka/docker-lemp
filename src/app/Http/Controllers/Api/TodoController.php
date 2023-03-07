<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TodoController extends Controller
{
    /**
     * 一覧取得
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(Todo::get());
    }

    /**
     * 詳細取得
     *
     * @param integer $id
     * @return Response
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if (is_null($todo)) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }

        return response()->json($todo);
    }

    /**
     * 新規登録
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'task' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        $todo = Todo::create(['task' => $request->input('task')]);

        return response()->json($todo, Response::HTTP_CREATED);
    }

    /**
     * 更新
     *
     * @param Request $request
     * @param integer $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'task' => 'required|max:200',
        ]);
        if ($validator->fails()) {
            throw new HttpException(Response::HTTP_BAD_REQUEST);
        }

        // 微妙だけど、更新処理を書く
        $todo = Todo::find($id);
        if (is_null($todo)) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }
        $todo->update(['task' => $request->input('task')]);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * 削除
     *
     * @param integer $id
     * @return Response
     */
    public function delete($id)
    {
        $task = Todo::find($id);
        if (!is_null($task)) {
            $task->delete();
        }

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
