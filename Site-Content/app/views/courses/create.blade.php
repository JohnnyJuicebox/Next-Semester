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

                var respAuthor = '<div class="row"><div class="author large-10 columns">' + val["username"] + ' says: ' + '</div><div class="author large-2 columns"><a id="showReply" href="#">Reply</a></div></div>';
                var respInfo = urlify(val["body"]);
                var respContent = '<div class="row"><div class="info large-12 columns">' + respInfo + '</div></div>';
                var pId = val["id"];
                var response = '<div class="postInfo" id="post' + val["id"] + '">' + '<div class="main-comment">' + respAuthor + respContent + '</div>' + '</div>';

                var comments = '<div class="large-10 columns"><label><textarea placeholder="Add Reply" class="t' + pId + '"></textarea></label></div>';
                var commentSubmit  = '<div class="large-2 columns"><a id="commentSubmit' + pId + '" class="commentButton button small radius">Comment</a></div>';
                
                response = response + '<div class="userComment"><div class="row">' + comments + commentSubmit + '</div></div>';

                $.ajax({
                    url: '/comments',
                    type: 'get',
                    data: { postId: pId },
                    success: function(resp){

                        $.each(resp, function(k, v){
                            
                            var commentAuthor = '<div class="commentAuthor">' + v['username'] + ' replies:' + '</div>';
                            var commentInfo = '<div class="commentInfo">' + v['info'] + '</div>';

                            $('#post' + pId).append('<div class="comment">' + commentAuthor + commentInfo +'</div>');

                        });

                       // $('#post' + pId).append(comments + commentSubmit);
                        
                        $('#commentSubmit' + pId).click(function(){
                            var tid = this.id.replace('commentSubmit', '');
                            var cinfo = $('.t' + tid).val();
                            cinfo = urlify(cinfo);
                            //alert(cinfo);
                            $.ajax({
                                url: '/comments',
                                type: 'post',
                                data: { pid: tid, commentInfo: cinfo},
                                success: function(res){
                                    
                                   // alert('success');
                                    
                                    var commentAuthor = '<div class="commentAuthor">' + res['username'] + ' replies:' + '</div>';
                                    var commentInfo = '<div class="commentInfo">' + res['commentInfo'] + '</div>';
                                    var comment = '<div class="comment">' + commentAuthor + commentInfo + '</div>';

                                    //alert(commentAuthor);

                                    $('#post' + tid).append(comment);
                                    $('textarea').val('');
                                }
                            });
                        });
                    }
                });

                $('#oldContent').prepend(response);
                $( ".userComment" ).hide();
                var display = false;
                $( "#showReply").click(function(){
                    $( ".userComment" ).toggle( display );

                    if ( display === true ) {
                  $( ".userComment" ).hide();
                  display = false;
                } else if ( display === false ) {
                  $( ".userComment" ).show();
                  display = true;
                }
                });
                

            });
        }
    });

    

    // Once a user submits a request post it and then prepend it to the wall
    $('a#submit').click(function(){
        var info = $('.userContent > div:nth-child(1) > div:nth-child(1) > label:nth-child(1) > textarea:nth-child(1)').val();
        $.ajax({
            url: '/wall',
            type: 'post',
            data: { contentInfo: info, cid: courseId},
            success: function(data){
                $('textarea').val('');
                var respAuthor = '<div class="author">' + data["username"] + ' says:' +'</div>';
                var respInfo = urlify(data["content"]);
                var respContent = '<div class="info">' + respInfo + '</div>';
                var postComment = '<div class="userComment"><textarea class="t' + data["postId"] + '" ></textarea>' + '<a id="commentSubmit' + data["postId"] + '" class="commentButton postfix">Comment</a>'+'</div>';
                var response = '<div class="postInfo" id="post' + data["postId"] + '">' + respAuthor + respContent +'</div>' + postComment;
                $('#oldContent').prepend(response);

                $('#commentSubmit' + data["postId"]).click(function(){
                    var tid = this.id.replace('commentSubmit', '');
                    var cinfo = $('.t' + tid).val();
                    cinfo = urlify(cinfo);
                    //alert(cinfo);
                    $.ajax({
                        url: '/comments',
                        type: 'post',
                        data: { pid: tid, commentInfo: cinfo},
                        success: function(res){
                            
                           // alert('success');
                            
                            var commentAuthor = '<div class="commentAuthor">' + res['username'] + '</div>';
                            var commentInfo = '<div class="commentInfo">' + res['commentInfo'] + '</div>';
                            var comment = '<div class="comment">' + commentAuthor + commentInfo + '</div>';

                            //alert(commentAuthor);

                            $('#post' + tid).append(comment);
                            $('textarea').val('');
                        }
                    });
                });
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
            <br>
            <h3>Comments</h3>
            <div class="userContent">
                <div class="row">
                    <div class="large-12 columns">
                    <label>
                        <textarea style="height: 130px;" placeholder="Add Comment"></textarea>
                    </label>
                    </div>
                    <div class="large-3 columns">
                        <a id="submit" class="button postfix">Comment</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="oldContent" class="panel radius border-comment"></div>
    </div>
</div>
@stop

@section('tailScripts')
<script>


</script>
@stop
