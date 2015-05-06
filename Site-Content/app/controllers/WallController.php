<?php

use NextSemester\Wall\WallPost;
use NextSemester\Wall\UserWallPost;
use NextSemester\Wall\WallPostComment;
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

        $wallComments = WallPostComment::where('wallPostId', '=', $postId)->get()->all();

        return Response::json($wallComments);
    }
}


