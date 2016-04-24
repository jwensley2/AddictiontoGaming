@extends('layouts.admin')

@section('title')
404 Error
@stop

@section('content')
	<div class="row">
		<div class="col-md-12">
			<p>We could not find the page you were looking for.</p>
			<p><a onclick="history.go(-1);" href="{{ route('admin') }}">&laquo; Back</a></p>
		</div>
	</div>
@stop