@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
    @parent
    hold-transition skin-blue sidebar-mini
@stop

<div class="az-content-breadcrumb">
    <span>{{ lang('master_records') }}</span>
    <span>{{ ucwords(str_replace('-', ' ', $postType)) }}</span>
</div>
<div class="row row-xs mg-b-20">
    <div class="col">
        <div class="az-content-label mg-b-5">Manage {{ ucwords(str_replace('-', ' ', $postType)) }}</div>
        <p class="mg-b-20">Total {{ $post_items->count() }} records</p>
    </div>

</div>

@include('admin.common.user_message')
<div class="table-responsive">
    <table class="table table-hover mg-t-50 mg-b-0">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>

                <th scope="col">Restore</th>
            </tr>
        </thead>

        <tbody>

            @if (!empty($post_items) && $post_items->count() > 0)
                @php $inc = getPaginationSerial($post_items); 	@endphp
                @foreach ($post_items as $item)
                    <tr>
                        <th scope="row">{{ $inc++ }}</th>
                        <td>{!! $item->post_title !!}</td>


                        <td>
                            <a class=" btn btn-danger btn-icon"
                                href="{{ RT('archive_list_restore', [$postType, $item->post_id]) }}" title="archived">
                                <button class="btn btn-danger btn-block">Restore</button></a>

                        </td>
                        {{--  <td>
                            <div class="btn-icon-list"><a
                                    href="{{ apa('post/' . $postType . '/edit/' . $item->post_id) }}" title="edit"
                                    class="btn btn-primary btn-icon"><i class="typcn typcn-edit"></i></a>

                            </div>
                        </td> --}}

                    </tr>
                @endforeach
            @else
                <tr class="no-records">
                    <td colspan="7" class="text-center text-danger">No records found!</td>
                </tr>
            @endif

        </tbody>
    </table>
    {!! $post_items->links('pagination::bootstrap-4') !!}
</div><!-- table-responsive -->
@stop
