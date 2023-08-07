<div class="container">
    <div class="d-flex justify-content-between">
        <h3>Blog List</h3>
        <div>
            <input name="search" id="search" class="form-control" placeholder="Search..." wire:model="search" type="search">
        </div>
    </div>
    <hr>
    @foreach($blogs as $blog)
        <div class="list-group-item">
            <div class="d-flex justify-content-between">
                <a href="{{ url('/blog?id='.$blog->id) }}" class="nav-link text-primary"><h4>{{ $blog->title }}</h4></a>
                <div class="d-flex gap-3">
                    @if(Auth::user())
                        @if($blog->userid == Auth::user()->id)
                        <a href="{{ url('/edit_blog?id=') }}{{ $blog->id }}" class="btn btn-success">Edit</a>
                        <button class="btn btn-danger" onclick="del(`{{ $blog->id }}`,`{{ $blog->title }}`)">Delete</button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="d-flex">
                <small><b>{{ $blog->name }}</b>, &nbsp;</small>
                <small>{{ $blog->publish_date }}</small>
            </div>
        </div>
        <hr>
    @endforeach
    <div class="py-4">
        {!! $blogs->links('pagination::bootstrap-4') !!}
    </div>
</div>
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
                window.location.href = '/';
            } 
        })
    }
</script>
