<div id="filterOptions" style="{{empty(app('request')->input('filterNow')) ? '' : ''}}">
     <div class="card-body ">
        {{ Form::open(array('name'=>'filter-farms','url'=>Config::get('app.admin_prefix').'/category_manager','method'=>'get' )) }}
        <div class="row">                                            
            <div class="col-md-4 form-group">
                <input type="text" name="name" class="dirChange form-control border {{ !empty(app('request')->input('name')) ? 'border-green' : '' }}" value="{{app('request')->input('name')}}" placeholder="Search by Name" /> 
            </div>
             	
            <div class="col-md-4 form-group">
                <select name="status" class="border form-control {{ !empty(app('request')->input('listing-completed')) ? 'border-green' : '' }}">
                    <option value="">Status</option>
                    <option value="1" {!! (app('request')->input('status') ==1 ) ? 'selected="selected"' : '' !!}>Active</option>
                    <option value="2" {!! (app('request')->input('status') ==2 ) ? 'selected="selected"' : '' !!}>Inactive</option>
                    <option value="3" {!! (app('request')->input('status') ==3 ) ? 'selected="selected"' : '' !!}>Disabled but show</option>
                </select>
            </div>		
           
            <div class="col-md-4 form-group">
                <div class="btn-group btn-group-toggle">
                    <input type="submit" name="filterNow" id="filterNow" class="btn btn-outline-success" value="Search" /> 
                    <a href="{{ asset(Config::get('app.admin_prefix').'/category_manager') }}" class=" btn btn-outline-primary">Reset</a>
                </div>
                               
            </div>
        </div>
        {{ Form::close() }}

    </div>
</div>