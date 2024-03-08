{{-- <div class="az-footer ht-40">
      <div class="container ht-100p pd-t-0-f">
        <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">{!! date('l d\<\s\u\p\>S\<\/\s\u\p\> F, Y') !!}</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Powered by <a class="no-margin" target="_blank" href="https://www.pgsuae.com">PGSUAE</a>. <b>Version</b> 3.8 </span>
      </div><!-- container -->
    </div><!-- az-footer --> --}}
<a href="#" id="toTop" style="display:none"> <span id="toTopHover" style="opacity: 1;"> </span></a>
@section('scripts')
@parent
<script>
$('#post-form').submit(function() {
	if ( typeof( tinyMCE) != "undefined" ) {
        tinyMCE.triggerSave();
    }
}).validate({
	ignore: ''
});
</script>
@stop