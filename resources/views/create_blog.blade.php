@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Blog</h1>
    <form action="{{ url('create_blog') }}" method="post">
        @csrf
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control">

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" name="content"
                id="tinymce">{{ old('content') }}</textarea>

            @if ($errors->has('content'))
                <span class="text-danger text-left">{{ $errors->first('content') }}</span>
            @endif
        </div>
        <div class="d-flex gap-3">
            <label for="status">Status</label>
            <select name="status" id="status" class="nav-link dropdown-toggle">
                <option value="draft">Draft</option>
                <option value="publish">Publish</option>
            </select>
        </div>
        <div class="mb-3 py-4">
            <input type="submit" value="Save" class="btn btn-primary">
        </div>
    </form>
</div>
@endsection