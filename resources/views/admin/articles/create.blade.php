@extends('layouts.admin')

@section('title')
    News - New Post
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if (isset($messages))
                @include('admin._partials.messages')
            @endif

            @if (isset($errors))
                @include('admin._partials.errors')
            @endif

            <form action="{{ route('admin.articles.store') }}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="article-title">Title</label>
                    <input type="text" id="article-title" class="form-control" name="title" value="{{ Request::old('title') }}">
                </div>

                <div class="form-group">
                    <label for="article-content">Content</label>
                    <textarea id="article-content" class="form-control editor" name="content">{{ Request::old('content') }}</textarea>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a class="btn btn-secondary" href="{{ route('admin.home') }}">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@stop