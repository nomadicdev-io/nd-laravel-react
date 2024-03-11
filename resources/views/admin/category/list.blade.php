@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent 
hold-transition skin-blue sidebar-mini
@stop

    <div class="row">

        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-header-title">Category Manager</h3>
                    <a href="{{ apa('category-manager/create') }}" class="btn btn-outline-success ml-auto">Create New</a>
                </div>
                @include('admin.category.list_filters')
                <div class="card-body border-bottom" style="{{(empty($userMessage)) ? 'display: none' : ''}}">						
                    @include('admin.common.user_message')			
                </div>
                <div class="card-body ">
                    <h4>{{ $categoryList->count() }} results found.</h4>
                    <div class="table-responsive ">
                        <table class="table table-bordered ">
                            <thead>
                                <tr>
                                    <th scope="col" width="50px"  class="text-center">#</th>																		
                                    <th scope="col">Category Title [English]</th>
                                    <th scope="col">Category Title [Arabic]</th>
                                    <th scope="col" class="text-center">Parent Category</th>									
                                    <th scope="col" class="text-center">Status</th>									
                                    <th scope="col" class="text-center">Action</th>									
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($categoryList) && $categoryList->count() > 0)
                                <?php $inc = getPaginationSerial($categoryList); ?>
                                @foreach ($categoryList as $category)
                                <tr>
                                    <td class="text-center">{{ $inc++ }}</td>
                                    <td>
                                        {{ $category->category_title }}
                                    </td>
                                    <td>
                                        {{ $category->category_title_arabic }}
                                    </td>
                                    <td>
                                        {{ (!empty($category->parentCategory))?$category->parentCategory->category_title:'' }}
                                    </td>

                                    <td class="status">
                                        <?php
                                        echo ($category->category_status == 1) ? "<a href='" . apa('category-manager/changestatus/' . $category->category_id) . "' ><i class='fa fa-check-circle'></i></a>" : "<a href='" . apa('category-manager/changestatus/' . $category->category_id) . "' ><i class='fa fa-times-circle'></i></a>";
                                        ?>
                                    </td>

                                    <td  class="text-center">
                                        <a href="{{ apa('category-manager/update/'.$category->category_id) }}" title="edit" class="btn btn-outline-success btn-sm">Edit</a>												
                                    </td>


                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">No records found!</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="6">{{$categoryList->links()}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop