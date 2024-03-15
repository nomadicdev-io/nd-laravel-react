@extends('admin.layouts.master')
@section('content')
@section('bodyClass')
@parent 
hold-transition skin-blue sidebar-mini
@stop

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">Category Manager
                    <a class="float-sm-right" href="{{ apa('category-manager') }}"><button class="btn btn-outline-dark btn-flat">Back</button></a></h2>
            </div>
        </div>
    </div> 

    <div class="row">
        <div class="col-sm-12">
            @include('admin.common.user_message')
        </div>
        <!-- ============================================================== -->
        <!-- striped table -->
        <!-- ============================================================== -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="col-sm-12 card-header my-table-header">
                    <div class="row align-items-center">
                        <div class="col-sm-6"><h5 class="">Add category</h5></div>
                        <?php /* <div class="col-sm-6"><h5 class="text-right">Showing {{ $hubList->currentPage() }} of {{  $hubList->total() }} pages</h5></div> */ ?>
                    </div>
                </div>
                <div class="card-body">
                    {{ Form::open(array('url' => apa('category-manager/create'),'files' => true,'role'=>'form','name'=>'CategoryCreate')) }}

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="category_parent_id" class="col-form-label">Parent Category</label>
                                <select name="category_parent_id" id="category_parent_id" class="form-control select2">
                                    @if(!empty($categoryList))
										<option value="">Select</option>
										@foreach($categoryList as $category)
									        <option {{(old('category_parent_id') ?? ""==$category->category_id)?'selected':''}} value="{{$category->category_id}}">{{$category->category_title}}</option>
									    @endforeach
								    @endif		
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <label>Category Title</label>
                            <input type="text" name="category_title"  value= "{{ old('category_title') ?? "" }}" class="form-control" placeholder=""   required />
                        </div>
                        <div class="col-sm-6">
                            <label>Category Title[Arabic]</label>
                            <input type="text" dir="rtl" name="category_title_arabic"  value= "{{ old('category_title_arabic') ?? "" }}" class="form-control" placeholder=""   required />
                        </div>
                    </div>
                 

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="category_priority" class="col-form-label">Category Priority<em>*</em></label>
                                <input id="category_priority" name="category_priority" type="number" value="{{ old('category_priority') ?? "" }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="category_status" class="col-form-label">Category Status<em>*</em></label>
                                <select name="category_status" id="category_status" class="form-control">
                                    <option value="1">Activate</option>
                                    <option value="2">Deactivate</option>
                                    <option value="3">Disable but show</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-6">

                            <div class="form-group">
                                <input type="submit" name="createbtnsubmit" value="Submit"  class="btn btn-outline-success  btn-flat">
                                <a href="<?php echo apa('category-manager'); ?>" class="btn btn-outline-danger  btn-flat">Close</a>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@stop