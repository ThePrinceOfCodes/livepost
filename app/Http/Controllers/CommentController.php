<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Repositories\CommentRepository;

/*
*@group Comment Management
*API's to manage Comment resourses
*/ 

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        $comments = Comment::query()->paginate(50);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request,CommentRepository $commentRepository)
    {
        $created = $commentRepository->create($request->only([
            'post',
            'body',
            'user_id'
       ]));
        
       return new CommentResource($created);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCommentRequest $request, Comment $comment, CommentRepository $commentRepository)
    {
        $updated = $commentRepository->update($comment, $request->only([
            'post_id',
            'body',
            'user_id'
       ]));

      return new CommentResource($updated);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment, CommentRepository $commentRepository)
    {
        $commentRepository->forceDelete($comment);

        return response()->json([
            'success' => 'record deleted successfully',
        ]);
    }
}

