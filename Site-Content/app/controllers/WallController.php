<?php

use NextSemester\Wall\WallPost;
use NextSemester\Wall\UserWallPost;
use NextSemester\Wall\WallPostComment;
use NextSemester\Wall\WallComment;
use NextSemester\Users\User;

class WallController extends \BaseController {

    public function savePost($userId, $courseId, $contentInfo){

        $wallpst = new WallPost;

        $wallpst->userId = $userId;
        $wallpst->courseId = $courseId;
        $wallpst->body = $contentInfo;

        $wallpst->save();

        return $wallpst->id;
    }

    public function getUserName($userId){

        $user = User::find($userId);
        return $user->username;

    }

    public function index(){

        if(!Session::has('user_id')){
            return Response::json(array("Invalid"));
        }

        $userId = Session::get('user_id');
        $courseId = Input::get('cid');
        $contentInfo = Input::get('contentInfo');

        $postId = $this->savePost($userId, $courseId, $contentInfo);
        $username = $this->getUserName($userId);

        return Response::json(array("postId" => $postId, "username" => $username, "content" => $contentInfo));
    }

    public function allPosts(){

        if(!Session::has('user_id')){
            return Response::json(array("Invalid"));
        }

        $courseId = Input::get('cid');
        $coursePosts = UserWallPost::where('courseId', '=', $courseId)->get()->all();

        return Response::json($coursePosts);
    }

    public function getComments(){

        if(!Session::has('user_id')){
            return Response::json("Invalid");
        }

        $postId = Input::get('postId');

        $wallComments = WallComment::where('id', '=', $postId)->get()->all();

        return Response::json($wallComments);
    }

    public function postComments(){

        if(!Session::has('user_id')){
            return Response::json("Invalid");
        }

        $postId = Input::get('pid');
        $userId = Session::get('user_id');
        $commentInfo = Input::get('commentInfo');

        $wallComment = new WallPostComment;

        $wallComment->wallPostId = $postId;
        $wallComment->userId = $userId;
        $username = $this->getUserName($userId);
        $wallComment->info = $commentInfo;

        $wallComment->save();

        return Response::json(array('username' => $username, 'commentInfo' => $commentInfo));
    }
}


