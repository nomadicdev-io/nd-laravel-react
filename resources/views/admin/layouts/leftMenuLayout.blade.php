@include('admin.layouts.partials.left_menu_only')	
<div class="az-content az-content-dashboard-two">
    @include('admin.layouts.partials.left_menu_header')
    <div class="az-content-body mg-t-20">
        @yield('content')  
    </div>
    @include('admin.layouts.footer')
</div>

@section('scripts')
@parent
  <script>
    $(document).ready(function(){
        $('#azSidebarToggle').on('click',function(e){
            e.preventDefault();
            $('body').toggleClass('az-sidebar-hide');
        });
        $('.with-sub').on('click', function(e) {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).parent().siblings().removeClass('show');
        });
    });
  </script>
@stop