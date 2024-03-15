<div class="col-sm-6 form-group">
    <label for="{{$id}}" class="col-form-label"> {{ $title }} {{($required=="required")?"<em>*</em>":""}}</label>
    <textarea id="{{$id}}" name="{{$name}}" class="form-control ckeditorAr" {{$required}}>  </textarea>
</div>