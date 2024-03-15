<?php
/*
Close the tags if possible
Else render only the opening tags. php tidy will handle the closing tags;
*/
?>
@if(empty($dom))
<select name="post[parent_id]" class="form-control" id="menu_parent_id">
<option value="">Select</option>
@endif
@if(!empty($menu))
<option value="{{ $menu->post_id }}" {{ @$active_id == $menu->post_id ? 'selected' : '' }}> {{ (($menu->post_parent_id) ? str_pad('',$elementsTotal,'-') : '' ).$menu->post_title }}</option>
@endif