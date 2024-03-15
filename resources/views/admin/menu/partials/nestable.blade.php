<?php
/*
Close the tags if possible
Else render only the opening tags. php tidy will handle the closing tags;
*/
?>
@if(empty($dom))
<div class="dd" id="nestable">
    <ol class="dd-list">
@endif
@if(!empty($menu))
		@if(!empty($menu->post_parent_id) && !1)
			<ol class="dd-list">
		@endif
		
        <li class="dd-item" data-id="{{ $menu->post_id }}" >
            <div class="dd-handle">
				{{ $menu->post_title}}
				
			</div>
			<small class="dd-action text-default">
				<a class="fa fa-edit text-success" href="{{ apa('post/menu/edit/'.$menu->post_id) }}"> </a> | 
				<a class="fa fa-trash deleteRecord text-danger" href="{{ apa('post/menu/delete/'.$menu->post_id) }}"> </a>
			</small>
@endif