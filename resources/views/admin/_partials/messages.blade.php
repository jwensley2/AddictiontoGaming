@foreach ($messages as $message)
	<div class="alert alert-success">
		{{ $message }}
		<button data-dismiss="alert" class="close" type="button">×</button>
	</div>
@endforeach