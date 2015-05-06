@extends('layouts.course_default')

@section('headScripts')
<script>
$(document).ready(function(){

    function urlify(text) {
        var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function(url) {
            return '<a href="' + url + '">' + url + '</a>';
        })
    }

    var courseId = $('input:hidden').val();

    // Make a request to get all the wall posts
    $.ajax({
        url: '/wall',
        type: 'get',
        data: { cid: courseId },
        success: function(data){
            $.each(data, function(key, val){

                var respAuthor = '<div class="author">' + val["username"] + '</div>';
                var respInfo = urlify(val["body"]);
                var respContent = '<div class="info">' + respInfo + '</div>';
                var pId = val["id"];
                var response = '<div class="postInfo" id="post' + val["id"] + '">' + respAuthor + respContent + '</div>';

                $.ajax({
                    url: '/comments',
                    type: 'get',
                    data: { postId: pId },
                    success: function(resp){
                        var comments = '<textarea class="' + pId + '"></textarea>';
                        $.each(resp, function(k, v){
                            $('#post' + pId).append('<div class="comment">' + v['info'] +'</div>');
                        });
                        $('#post' + pId).append(comments);
                    }
                });


                $('#oldContent').prepend(response);
            })
        }
    });

    // Once a user submits a request post it and then prepend it to the wall
    $('a#submit').click(function(){
        var info = $('.userContent > textarea').val();
        $.ajax({
            url: '/wall',
            type: 'post',
            data: { contentInfo: info, cid: courseId},
            success: function(data){
                $('textarea').val('');
                var respAuthor = '<div class="author">' + data["username"] + '</div>';
                var respInfo = urlify(data["content"]);
                var respContent = '<div class="info">' + respInfo + '</div>';
                var response = '<div class="postInfo" id="post' + data["postId"] + '">' + respAuthor + respContent + '</div>';
                $('#oldContent').prepend(response);
            }
        });
    });
});
</script>
@stop

@section('content')
<div id="row">
	<div class="large-12 columns">
		<div id="contentHeader">
			<h2 class="subheader">{{ $courseInfo->cname }} </h2>
			{{ Form::hidden('val', $courseInfo->id) }}
			<p>{{ $courseInfo->cdesc }}</p>
		</div>
		<div id="contentInfo">
			<p> {{ $courseInfo->cinfo }} </p>
		</div>
		<div class="contentForm">
            <div class="userContent">
                <textarea></textarea>
			</div>
			<a id="submit" class="button postfix">Submit</a>
		</div>
        <div id="oldContent">
        </div>
	</div>
</div>
@stop

@section('tailScripts')
<script>

</script>
@stop
