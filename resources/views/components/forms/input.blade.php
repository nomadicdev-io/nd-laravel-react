<div class="col-sm-6 form-group">
    <label for="{{$id}}" class="col-form-label">  {{ $title }} {{($required=="required")?"<em>*</em>":""}}</label>
    <input type="text" name="{{ $name }}" id="{{ $id }}" class="form-control" placeholder=""  value="" {{$required}} />
</div>