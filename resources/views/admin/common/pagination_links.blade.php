@if($post_items instanceof \Illuminate\Pagination\LengthAwarePaginator )
	<div class="row">
		<div class="col-sm-12">
			{!! $post_items->links() !!}
		</div>
	</div>
@endif