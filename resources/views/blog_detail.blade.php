@extends('layouts.app')

@section('content')
<div class="container">
    @foreach($blogsss as $blog)
        <h1>{{ $blog->title }}</h1><br>
        <p>Author: {{ $blog->name }}, {{ $blog->publish_date }}</p>
        <div class="py-4">{!!html_entity_decode($blog->content) !!}</div>
        <input type="hidden" name="blogid" id="blogid" value="{{ $blog->id }}">
    @endforeach

    <div class="py-4">
        <h3>Comments:</h3>
        <?php 
            for($i = 0; $i < sizeof($comments); $i++)
            {
                ?>
                    <div id="comment" class="d-flex justify-content-between py-2">
                        <div><b>{{ $comments[$i]['name'] }}</b> : "{{ $comments[$i]['comment'] }}", &nbsp; &nbsp;  {{ $comments[$i]['date'] }}</div>
                        @if(Auth::user())
                            @if(Auth::user()->id == $comments[$i]['userid'])
                                <button class="btn btn-danger" onclick="del(`{{ $comments[$i]['id'] }}`,`{{ $comments[$i]['comment'] }}`)">
                                    <img src="{{ asset('img/trash.png') }}" alt="del" class="minicon">
                                </button>
                            @endif
                        @endif
                    </div>
                <?php
            }
        ?>
        @foreach($blogsss as $item)
            @if(Auth::user())
                <div class="py-3">
                    <form action="{{ url('add_comment') }}" method="post">
                        @csrf
                        <div class="input-group gap-3">
                            <input type="hidden" name="blogid" value="{{ $item->id }}">
                            <input type="text" name="commentar" id="commentar" class="form-control" placeholder="Add comment">
                            <input type="submit" value="Add Comment" class="btn btn-primary">
                        </div>
                    </form>
                </div>
            @else
                <div class="py-3">
                    <div class="input-group gap-3">
                        <input type="text" class="form-control" placeholder="Add comment">
                        <a href="/home" class="btn btn-primary">Add Comment</a>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection


<script>
    function del(id,title)
    {
        Swal.fire({
        title: `Do you want delete \n"${title}"?`,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        }).then((result) => {
            if (result.isConfirmed) {
                var data = {
                    id: id
                };
                var xhr = new XMLHttpRequest();
                xhr.open("GET", `/delete_comment?id=${id}`, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify(data));
                
                Swal.fire('Deleted!', '', 'success');
                window.location.href = `/blog?id=${document.getElementById('blogid').value}`;
            } 
        })
    }
</script>

