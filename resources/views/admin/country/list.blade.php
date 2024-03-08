@extends('admin.layouts.master')
@section('content')
  @section('bodyClass')
    @parent
        hold-transition skin-blue sidebar-mini
  @stop
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Manage Countries
					
					@if($buttons['add'] )
						<a class="float-sm-right" href="{{ route('admin_country_create') }}">
							<button class="btn btn-success btn-flat">Create New</button>
						</a>
					@endif</h2>
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
                            <div class="col-sm-6"><h5 class="">{{ $countryList->count() }} results found.</h5></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive-md">
						<?php  if(count($countryList)>0){ ?>												
							<table id="members1" class="table table-bordered table-hover">
							 <thead>
								<tr>
									<th>#</th>
									<th>Name</th>								
									<th>Name Arabic</th>								
														
                                    <th>Status</th>					
									<th>Manage</th>											
								</tr>
							</thead>								
								<tbody>	
								<?php 
									$inc=1;
									foreach ($countryList as $country){
                                       
									$activeUrl= asset( Config::get('app.admin_prefix').'/country/changestatus/'.$country->country_id.'/'.$country->country_status);
									$DeactiveUrl= asset(Config::get('app.admin_prefix').'/country/changestatus/'.$country->country_id.'/'.$country->country_status);
								
								?>
										<tr>
											<td>{{ $inc++ }}</td>
											<td>{!! $country->country_name !!}</td>
											<td><div style="text-align:right;direction:rtl"><strong>{!! $country->country_name_arabic !!}</strong></div></td>
											
                                            <td class="status">
                                                <?php echo ($country->country_status == 1)?"<a href='".$activeUrl."' class=''><i class='fa fa-check-circle'></i></a>":"<a href='".$DeactiveUrl."' class=''><i class='fa fa-times-circle'></i></a>"; ?>
                                            </td>
											
											<td class="manage">
												<ul>
                                                    <li>
                                                        <a href="<?php echo asset(Config::get('app.admin_prefix').'/country/edit/'.$country->country_id); ?>" class="" title="edit"><i class="far fa-edit"></i></a> <br/>
                                                        Edit
                                                    </li>
												</ul>
											</td>
												
												
										</tr>
										<?php } ?>
										
								   </tbody>                            
							</table>							
							<?php }else{ ?>
							<div class="row col-sm-12">
								<div class="alert alert-danger alert-dismissable">
									<i class="fa fa-ban"></i>
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
									<b>Alert!</b> No Records Found!.  
								</div> 
							</div>  
							<?php } ?>
							
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end striped table -->
            <!-- ============================================================== -->
        </div>
        
            
                
     </div>
@stop