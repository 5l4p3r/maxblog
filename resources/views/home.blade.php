@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Blog</h1>
    <div class="py-4">
        <div class="list-group">
            @foreach($blogs as $blog)
            <div class="d-flex justify-content-between">
                <a href="{{ url('/blog?id='.$blog->id) }}" class="nav-link text-primary"><h4>{{ $blog->title }}</h4></a>
                <div class="d-flex gap-3">
                    @if($blog->userid == Auth::user()->id)
                    <a href="{{ url('/edit_blog?id=') }}{{ $blog->id }}" class="btn btn-success">Edit</a>
                    <button class="btn btn-danger" onclick="del(`{{ $blog->id }}`,`{{ $blog->title }}`)">Delete</button>
                    @endif
                </div>
            </div>
            <div class="d-flex">
                <small>{{ $blog->name }}</small>
                <small>{{ $blog->publish_date }}</small>
            </div>
            @endforeach
        </div>
    </div>
    <div class="py-4">
        {!! $blogs->links('pagination::bootstrap-4') !!}
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
                xhr.open("GET", `/delete_blog?id=${id}`, true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify(data));
                
                Swal.fire('Deleted!', '', 'success');
                window.location.href = '/home';
            } 
        })
    }
</script>


