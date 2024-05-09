<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libs\Response;
use App\Models\Comment;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'comment' => 'required|string'
        ]);

        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->product_id = $_GET['product_id'];

        if($comment->save()){
            return Response::response('success', 'Comment has been saved successfully.', $comment, 200);
        }else{
            return Response::response('error', 'Failed to save comment.', $comment, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Comment::where('product_id', $id)->get();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::find($id);

        $param = [
            'comment' => $request->input('comment')
        ];

        if($comment->update($param)){
            return Response::response('success', 'Comment has been updated.', $comment, 200);
        }else{
            return Response::response('error', 'Failed to update comment.', $comment, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if($comment->delete()){
            return Response::response('success', 'Comment has been deleted.', $comment, 200);
        }else{
            return Response::response('error', 'Failed to delete comment.', $comment, 500);
        }
    }
}
