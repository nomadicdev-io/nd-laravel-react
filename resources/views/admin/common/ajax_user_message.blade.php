@if(!empty($userMessage))
<div class="ajax-alert alert alert-success" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  <span aria-hidden="true">×</span>
	</button>
	{!! $userMessage !!}
</div>
@endif
@if(!empty($errors) && count($errors) > 0)
	@foreach($errors as $item)
	<div class="ajax-alert alert alert-danger mg-b-10" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		{{ $item }}
	</div>
	@endforeach
@endif