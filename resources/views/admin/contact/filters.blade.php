<div id="filterOptions" style="{{empty(app('request')->input('filterNow')) ? '' : ''}}" class="card">
     <div class="card-body ">
        {{ Form::open(array('name'=>'filter-farms','url'=>apa('contact'),'method'=>'get' )) }}
        <div class="row">
          <div class="col-md-4 form-group">
                <select name="department" class="border form-control {{ !empty(app('request')->input('department')) ? 'border-green' : '' }}"> 
                    <option value="">Select Department</option>  
                     <option value="customer-support" {!! (app('request')->input('department') =="customer-support" ) ? 'selected="selected"' : '' !!}>Customer Support</option>
                     <option value="marketing-department" {!! (app('request')->input('department') =="marketing-department" ) ? 'selected="selected"' : '' !!}>Marketing Department</option>
                     <option value="brokerage-department" {!! (app('request')->input('department') =="brokerage-department" ) ? 'selected="selected"' : '' !!}>Brokerage Department</option>
                </select>
            </div>
            <div class="col-md-4 form-group">
                <input type="text" name="name" class="dirChange form-control border {{ !empty(app('request')->input('name')) ? 'border-green' : '' }}" value="{{app('request')->input('name')}}" placeholder="Search by Name" />
            </div>
            <div class="col-md-4 form-group">
                <input type="text" name="email" class="dirChange form-control border {{ !empty(app('request')->input('email')) ? 'border-green' : '' }}" value="{{app('request')->input('email')}}" placeholder="Search by Email" />
            </div>
            
    		<div class="col-md-4 form-group">
                <input type="text" name="from_date" class="datepicker form-control border {{ !empty(app('request')->input('from_date')) ? 'border-green' : '' }}" value="{{app('request')->input('from_date')}}" placeholder="Search by from Date" />
            </div>
            <div class="col-md-4 form-group">
                <input type="text" name="to_date" class="datepicker form-control border {{ !empty(app('request')->input('to_date')) ? 'border-green' : '' }}" value="{{app('request')->input('to_date')}}" placeholder="Search by to Date" />
            </div>
            <input type="hidden" name="sortCol" id="sortCol" value ="" />
            <input type="hidden" name="sortOrd" id="sortOrd" value ="" />

            <div class="col-md-4 form-group">
                <div class="">
                    <input type="submit" name="filterNow" id="filterNow" class="btn btn-outline-success" value="Search" />
                    <a href="{{ apa('contact') }}" class=" btn btn-outline-primary">Reset</a>
                </div>

            </div>
        </div>
        {{ Form::close() }}

    </div>
</div>