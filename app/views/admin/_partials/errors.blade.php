@foreach ($errors->all() as $error)
	<div class="alert alert-danger">
		{{ $error }}
		<button data-dismiss="alert" class="close" type="button">×</button>
	</div>
@endforeach