@extends('layouts.admin')

@section('title')
    News
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p class="text-right">
                @if(Auth::user()->hasPermission('articles_post'))
                    <a class="btn btn-primary" href="{{ route('admin.articles.create') }}">Post News</a>
                @endif
            </p>

            <table id="articles-list" class="table table-hover table-bordered sortable">
                <thead>
                <tr>
                    <th>Title</th>
                    <th class="hidden-xs">Author</th>
                    <th class="hidden-xs">Last Editor</th>
                    <th class="hidden-xs">Post Date</th>
                    <th class="hidden-xs">Edit Date</th>
                    <th data-sorter="false">Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($articles as $article)
                    <tr
                            class="articles-item"
                            data-delete="{{ route('admin.articles.destroy', $article) }}"
                            data-id="{{ $article->id }}"
                            data-title="{{{ $article->title }}}"
                    >
                        <td>
                            @if(Auth::user()->hasPermission('articles_edit'))
                                <a href="{{ route('admin.articles.edit', $article) }}">{{{ $article->title }}}</a>
                            @else
                                {{{ $article->title }}}
                            @endif
                        </td>
                        <td class="hidden-xs">{{ ($article->author) ? $article->author->username : 'None' }}</td>
                        <td class="hidden-xs">{{ ($article->editor) ? $article->editor->username : 'None' }}</td>
                        <td class="hidden-xs">{{ $article->created_at->toDateString() }}</td>
                        <td class="hidden-xs">{{ $article->updated_at->toDateString() }}</td>
                        <td>
                            @if(Auth::user()->hasPermission('articles_edit'))
                                <a class="btn btn-primary hidden-xs"
                                   href="{{ route('admin.articles.edit', $article) }}">Edit</a>
                            @endif

                            @if(Auth::user()->hasPermission('articles_delete'))
                                <button class="btn btn-danger delete">Delete</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <p class="text-right">
                <a class="btn btn-primary" href="{{ route('admin.articles.create') }}">Post News</a>
            </p>
        </div>
    </div>
@stop