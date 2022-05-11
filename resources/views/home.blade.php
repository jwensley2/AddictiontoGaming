@extends('layouts.master')

@section('content')
    <section id="content" class="content news-articles">
        <header>
            <h1>News and Announcements</h1>
        </header>

        @foreach($articles AS $article)
            @include('news.partials.article', array('article' => $article))
        @endforeach
    </section>

    {{ $articles->links() }}
@stop
