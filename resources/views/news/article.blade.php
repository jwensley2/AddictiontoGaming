@extends('layouts.master')

@section('content')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $("#content").on("click", ".delete-news", function () {
                title = $(this).parents('article').children('h2:first-child').text();
                return confirm('Are you sure you want to delete "' + title + '"');
            })
        })
    </script>

    <section id="content" class="content news-articles">
        @foreach($articles AS $article)
            @include('news.partials.article', ['article' => $article])
        @endforeach
    </section>
@stop