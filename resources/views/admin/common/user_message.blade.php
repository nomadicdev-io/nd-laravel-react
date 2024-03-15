@if(!empty($userMessage))
	     {!! $userMessage !!}
	
@endif
@if(!empty($errorMessage))
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	{!! $errorMessage !!}
	</div>
@endif
@if(!empty($errors) && count($errors) > 0)
	@foreach($errors as $item)
	<div class="alert alert-danger mg-t-30 mg-b-10" role="alert">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">×</span>
		</button>
		<strong><i style="font-size: 18px;" class="typcn typcn-warning"></i> {{ $item }}</strong>
	</div>
	@endforeach
@endif