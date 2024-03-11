<!DOCTYPE html>
<html lang="{{ App::getLocale() }}" dir="{{ (App::getLocale() == 'ar')?'rtl':'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="index, follow">
        <meta name="baseurl" content="{{ asset('/') }}" />
        <meta name="device" content="{{ (Agent::isMobile() === true) ? 'true' : 'false' }}" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        
        <meta name="title" content="{{ lang('welcome') }}" />
        <title>{{ lang('welcome') }}</title>
        
        <link rel="shortcut icon" href="">
        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
            window.baseURL = "{{ asset('/') }}";
        </script>
		
		<style>
        .passcheck_list_box ul {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 14px;
	    font-weight: 400;
	        line-height: 1.3;
}
.passcheck_list_box ul li {
	margin-bottom: 5px;
	
	position: relative;
	color: #c7c7c7;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	    -ms-flex-align: center;
	        align-items: center;

}
.passcheck_list_box ul li .name_{
	-webkit-box-flex: 1;
	    -ms-flex: 1;
	        flex: 1;
}
.passcheck_list_box ul li .icon_box {
	width: 20px;
	height: 20px;
	border: 1px solid #c7c7c7;
	margin-left: 10px;
	color: #c7c7c7;
	
	position: relative;
	    border-radius: 50%;
}
.passcheck_list_box ul li .icon_box:before {
    content: "\46";
	position: absolute;
	right: 0;
	top: 0;
	display: -webkit-box;
	display: -ms-flexbox;
	display: flex;
	-webkit-box-align: center;
	    -ms-flex-align: center;
	        align-items: center;
	-webkit-box-pack: center;
	    -ms-flex-pack: center;
	        justify-content: center;
	font-size: 10px;
	width: 100%;
	height: 100%;
	    font-family: "uae-legislation" !important;
    font-style: normal !important;
    font-weight: normal !important;
    font-variant: normal !important;
    text-transform: none !important;
    speak: none;
    line-height: 1;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.passcheck_list_box ul li.passed {
	color: #4caf50
}
.passcheck_list_box ul li.passed .icon_box {
    color: #FFF;
    border-color: transparent;
    background: #4caf50;

}
.passcheck_list_box ul li.error {
	color: #ea7b7b;
}
.passcheck_list_box ul li.error .icon_box {
    color: #FFF;
    border-color: transparent;
    background: #ea7b7b;

}

.passcheck_list_box ul li.passed .icon_box:before {
    content: "\47";
}

.passcheck_list_box ul li:last-child {
	margin-bottom: 0
}

		.is-loaded .loader {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
loader {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 99999999;
    background: #000;
    margin: auto;
    -webkit-transition: width .5s ease-in-out, height .5s ease-in-out, opacity .3s .5s ease-in-out, visibility .3s .5s ease-in-out;
    -o-transition: width .5s ease-in-out, height .5s ease-in-out, opacity .3s .5s ease-in-out, visibility .3s .5s ease-in-out;
    transition: width .5s ease-in-out, height .5s ease-in-out, opacity .3s .5s ease-in-out, visibility .3s .5s ease-in-out;
}

		.loader.show{
			position: fixed;
			top: 0;
			width: 100%;
			height: 100vh;
			background: rgba(0,0,0,.5);
			z-index: 9;
			display: flex;
			align-items: center;
			justify-content: center;
		}
        .wizard > .content > .body 
 .passcheck_list_box ul {
    position: relative;
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
    list-style: none !important;
    margin-top: 1em;
}

.passcheck_list_box ul li {
    margin: 0.5em 0;
    display: flex !important;
    align-items: center;
    justify-content: flex-start;
}

.passcheck_list_box ul li .icon_box {
    display: block;
    margin-inline-end: 1em;
}

.passcheck_list_box ul li .icon_box:before {
    content: '';
    position: absolute;
    width: 10px;
    height: 2px;
    background: #dadada;
    top: 50%;
    transform-origin: center;
    transform: translate(-50%, -50%) rotate(45deg);
    left: 50%;
}

.passcheck_list_box ul li .icon_box:after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 10px;
    height: 2px;
    background: #dadada;
    transform-origin: center;
    transform: translate(-50%, -50%) rotate(-45deg);
}

.passcheck_list_box ul li.passed .icon_box:before {
    content: '';
    color: #fff;
    width: 10px;
    height: 6px;
    border: 2px solid #ffffff;
    transform: translate(-50%, -70%) rotate(-45deg);
    background:none;
    border-top:none;
    border-right:none;
}

.passcheck_list_box ul li.passed .icon_box:after{
    display:none;
}
.installer_main .master .form_wrapper .full_ {grid-column:1/-1}
		</style>
		
        {{ Html::style('assets/admin/lib/jquery-steps/jquery.steps.css') }}

        {{ Html::style('assets/installer/css/installer.css') }} 

    </head>
	<div class="loader show" >
        <div class="loader-block">
            <div class="loader-img">
                <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
					<path opacity="0.2" fill="#EFAB37" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
					s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
					c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
					<path fill="#EFAB37" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
					C22.32,8.481,24.301,9.057,26.013,10.047z">
					<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"></animateTransform>
					</path>
					</svg>
            </div>
            <div class="linePreloader"></div>
        </div>
	</div>
    <body>

        <main class="installer_main" style="background-image: url('{{ asset('assets/installer/img/installer_bg.jpg') }}')">
            <div class="master">
                <div class="box">
                    {{ Form::open(array('url' => array(route('web-installer')),'files'=>false,'id'=>'web-installer')) }}
                        <div id="installer-wizard">
                            @include('installer.partials.welcome_message')
                            @include('installer.partials.readiness_check')
                            @include('installer.partials.database_setup')
                            @include('installer.partials.mail_settings')
                            @include('installer.partials.admin_account_creation')
                            @include('installer.partials.app_settings')
                            @include('installer.partials.final_installation')
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </main>

       	
			<div class="form-loader" id="alnloader">
				<div class="l_" title="0">
					<svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
					<path opacity="0.2" fill="#EFAB37" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
					s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
					c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"></path>
					<path fill="#EFAB37" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
					C22.32,8.481,24.301,9.057,26.013,10.047z">
					<animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 20 20" to="360 20 20" dur="0.5s" repeatCount="indefinite"></animateTransform>
					</path>
					</svg>
				</div>
			</div>
		
        <script src="{{  asset('assets/admin/lib/jquery/jquery-3.6.0.min.js') }}" type="text/javascript"></script>
        <script src="{{  asset('assets/admin/lib/jquery-steps/jquery.steps.min.js') }}" type="text/javascript"></script>
        <script src="{{  asset('assets/admin/lib/jquery-validator/jquery.validate.js?1223') }}" type="text/javascript"></script>
        <script src="{{  asset('assets/frontend/mask/jquery.mask.min.js') }}" type="text/javascript"></script>
        

        

        <script>

        function sendPost(url,method,data,messageSelector,callback){

             $.ajax({
                    method:method,
                    url: url,//CREATE ENV
                    async:true,
                    data: data
                }).done(function(response) {
                    $(messageSelector).html(response.message); 
                    if(response.bufferLog){
                        $(messageSelector).append(response.bufferLog);     
                    }

                    if(response.csrfToken){
                        $('[name="_token"]').val(response.csrfToken);
                    }
                    
                    if(!response.status){
                        $(messageSelector).addClass('operation-failed');
                        return;
                    }

                    if(response.redirectURL){
                        setTimeout(function(){
                            window.location.href = response.redirectURL
                        },4000);
                    }   
                    callback(response);
                });
        }
        $(document).ready(function() {

            var moveNext = false; 

  

            $('#web-installer').validate({
                    ignore:{},
                    rules :{
                        'mysql_host':{
                            required:true
                        },
                        'mysql_port':{
                            required:true
                        },
                        'db_name':{
                            required:true
                        },
                        'db_username':{
                            required:true
                        },
                        'db_password':{
                            required:true
                        },
                        'mail_driver':{
                            required:true
                        },
                        'mail_from_address':{
                            required:true,
                            email:true
                        },
                        'mail_from_name':{
                            required:true
                        },
                        'admin_fullname':{
                            required:true
                        }, 
                        'admin_email':{
                            required:true
                        },
                        'admin_phone':{
                            required:true
                        },
                        'admin_username':{
                            required:true
                        },
                        'password':{
                            required:true,
							minlength : 5,
                        },
						'password_confirmation':{
                            required:true,
							minlength : 5,
							equalTo : "#password"
                        },						
                        'app_name':{
                            required:true
                        }, 
                        'app_url':{
                            required:true
                        },
                        'admin_prefix':{
                            required:true
                        },
                        'recaptcha_sitekey':{
                            required:true
                        },
                        'recaptcha_secret':{
                            required:true
                        },
                    },
                    messages:{
                        
                    }
            });

            $('#installer-wizard').steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "fade",
                enableFinishButton: true,
                enablePagination: true,
                enableAllSteps: false,
                autoFocus: true,
                onStepChanging: function (event, currentIndex, newIndex)
                {
                   $('#admin_phone').mask("000000000000000");    
					$('#alnloader').addClass('show');
					if (currentIndex > newIndex)
					{
						
						return true;
					}
                    switch(currentIndex){
                        case 0: 
                            moveNext = true;
                        break;
                        case 2:
                            if(!$('#mysql_host').valid() || !$('#mysql_port').valid() || !$('#db_name').valid() || !$('#db_username').valid() || !$('#db_password').valid()){
                                moveNext = false;
                            }else{
                                var data = $('#web-installer').serializeArray();
								$('#alnloader').addClass('show');	
                                 $.ajax({
                                    method:"POST",
                                    url: "{{ route('check-database') }}",
                                    async:false,
                                    data: data
                                }).done(function(response) {
                                    moveNext = response.status;
                                    if(!response.status){
                                        $('#database-message-wrapper').html('<span>' + response.message + '</span>');
                                    }

                                })
                            }
							
                        break;

                        case 3:
                            if($('#mail_driver').val() == 'smtp'){
                                if(!$('#mail_host').valid() || !$('#mail_port').valid() || !$('#mail_from_address').valid() || !$('#mail_from_name').valid()){
                                    moveNext = false;
                                }else{
									
									
									$('#alnloader').addClass('show');
                                    var data = $('#web-installer').serializeArray();
									
                                     $.ajax({
                                        method:"POST",
                                        url: "{{ route('check-mail') }}",
                                        async:false,
                                        data: data
                                    }).done(function(response) {
                                        moveNext = response.status;
                                        if(!response.status){
                                            $('#mail-message-wrapper').html('<span>' + response.message + '</span>');
                                        }

                                    })
                                }
                            }else{
                                if(!$('#mail_from_address').valid() || !$('#mail_from_name').valid()){
                                    moveNext = false;
                                }else{
									$('#alnloader').addClass('show');
                                    var data = $('#web-installer').serializeArray();
									
                                     $.ajax({
                                        method:"POST",
                                        url: "{{ route('check-mail') }}",
                                        async:false,
                                        data: data
                                    }).done(function(response) {
                                        moveNext = response.status;
                                        if(!response.status){
                                            $('#mail-message-wrapper').html('<span>' + response.message + '</span>');
                                        }										

                                    });
                                }
                            }

                        break;
                        case 4:
                                if(!$('#admin_fullname').valid() || !$('#admin_email').valid() || !$('#admin_phone').valid() || !$('#admin_username').valid()|| !$('#password').valid()|| !$('#password_confirmation').valid()){
                                    moveNext = false;
                                }else{
                                    // moveNext = true;
                                    $('#alnloader').addClass('show');
                                    var data = $('#web-installer').serializeArray();
									
                                     $.ajax({
                                        method:"POST",
                                        url: "{{ route('check-admin') }}",
                                        async:false,
                                        data: data
                                    }).done(function(response) {
                                        moveNext = response.status;
                                        if(!response.status){
                                            $('#admin-message-wrapper').html('<span>' + response.message + '</span>');
                                        }										

                                    });
                                }
                        break;
                         case 5:
                                if(!$('#app_name').valid() || !$('#app_url').valid() || !$('#admin_prefix').valid() || !$('#recaptcha_sitekey').valid()|| !$('#recaptcha_secret').valid()){
                                    moveNext = false;
                                }else{
                                    moveNext = true;
                                }
                        break;
                    }
					
					
					if(moveNext==false){
						$('#alnloader').removeClass('show');
					}
                    return moveNext;
                },
                 onStepChanged: function (event, currentIndex, previousIndex)
                {
                     
                    switch(currentIndex){
                        case 1:
                            $.ajax({
                                url: "{{ route('check-prerequisites') }}",
                                async:false,

                            }).done(function(response) {

                                $('#alnloader').removeClass('show');
                                moveNext = response.status;
                                if(moveNext == false){
                                    $("#installer-wizard li.current").addClass('error');
                                    if(!response.php.version.status){
                                        $('.version').each(function(i,v){                                              
                                           $(this).addClass('error');
                                           $('#prerequisite-message-wrapper').html("{{ lang('current_php_version_is') }} "+ response.php.version.currentPhpVersion)
                                        });
                                    }else{
                                        $('#prerequisite-message-wrapper').html("{{ lang('current_php_version_is') }} "+ response.php.version.currentPhpVersion);
                                    }

                                    if(!response.php.extensions.status){
                                        $('.extensions').each(function(i,v){
                                            $(response.php.extensions.missingExtensions).each(function(ii,vv){ 
                                                if( $(v).hasClass(vv) ){
                                                    $(v).addClass('error');  
                                                }
                                            });
                                            $(response.php.extensions.availableExtensions).each(function(ii,vv){ 
                                                if( $(v).hasClass(vv) ){
                                                    $(v).addClass('ext-installed');  
                                                }
                                            });                                            
                                        });
                                    }

                                    if(!response.apache.status){
                                        $('.apache').each(function(i,v){
                                            $(response.apache.missingModules).each(function(ii,vv){
                                                
                                                if( $(v).hasClass(vv) ){
                                                    $(v).addClass('error');  
                                                }
                                            });  

                                            $(response.apache.availableModules).each(function(ii,vv){
                                                
                                                if( $(v).hasClass(vv) ){
                                                    $(v).addClass('mods-installed');  
                                                }
                                            });
                                        });
                                    }

                                }else{

                                    $("#installer-wizard li.current").addClass('error');
                                    if(response.php.version.status){
                                        $('.version').each(function(i,v){                                              
                                           $(this).addClass('php-installed');
                                           $('#prerequisite-message-wrapper').html("{{ lang('current_php_version_is') }} "+ response.php.version.currentPhpVersion);
                                        });
                                    }

                                    if(response.php.extensions.status){
                                        $('.extensions').each(function(i,v){
                                            $(v).addClass('ext-installed');                                                
                                        });
                                    }

                                    if(response.apache.status){
                                        $('.apache').each(function(i,v){
                                            $(v).addClass('mods-installed');  
                                        });
                                    }

                                    $("#installer-wizard li.current").removeClass('error');
                                }
                            });
                        break;
                        case 2:
                            $('#alnloader').removeClass('show');
                            $('#mysql_host').focus();
                        break;
                        case 3:
                        case 4:
                        case 5:
                            $('#alnloader').removeClass('show');
                        break;
                        case 6:
                                    $('#alnloader').addClass('show');
                                    var data = $('#web-installer').serializeArray();
                                    sendPost("{{ route('create-env') }}",'POST',data,'#env-wrapper',function(response){
                                        var data = $('#web-installer').serializeArray();
                                        sendPost("{{ route('get-csrf') }}",'GET',{},'#migration-wrapper',function(response){
                                            var data = $('#web-installer').serializeArray();                                            
                                            sendPost("{{ route('run-migrations') }}",'POST',data,'#migration-wrapper',function(response){
                                                var data = $('#web-installer').serializeArray();                                            
                                                sendPost("{{ route('create-admin') }}",'POST',data,'#admin-create-wrapper',function(response){
                                                    var data = $('#web-installer').serializeArray();                                            
                                                    sendPost("{{ route('link-storage') }}",'POST',data,'#storage-wrapper',function(response){
                                                        var data = $('#web-installer').serializeArray();                                            
                                                        sendPost("{{ route('finalize-installation') }}",'POST',data,'#final-wrapper',function(response){    
                                                                                                            
                                                                $('#alnloader').removeClass('show');
                                                        }); 
                                                
                                                    });                                        
                                                });                                        
                                            });
                                            
                                        });
                                    });


                                   
                        break;

                    }
                    stepProgress();
                    return moveNext;
                },
                onFinishing: function (event, currentIndex)
                {
                    // form.validate().settings.ignore = ":disabled";
                    // return form.valid();
                   // console.log(event,currentIndex)
                    return true;  
                },
                onFinished: function (event, currentIndex)
                {
                    alert("Submitted!");
                }
            });


             $('#mail_driver').on('change',function(){

                
                if($(this).val() == 'smtp'){
					
					//$(".smtpClass").prop('required',true);
                    $('#mail_host').prop('disabled',false);
                    $('#mail_port').prop('disabled',false);
                    $('#mail_encryption').prop('disabled',false);
                    $('#mail_username').prop('disabled',false);
                    $('#mail_password').prop('disabled',false);

                    $('#mail_host').rules('add',function(){
                        required:true
                    });

                    $('#mail_port').rules('add',function(){
                        required:true
                    });



                }else if($(this).val() == 'sendmail'){
					//$(".smtpClass").prop('required',false);
                    $('#mail_host').prop('disabled',true);
                    $('#mail_port').prop('disabled',true);
                    $('#mail_encryption').prop('disabled',true);
                    $('#mail_username').prop('disabled',true);
                    $('#mail_password').prop('disabled',true);

                    $('#mail_host').rules('remove','required');
                    $('#mail_port').rules('remove','required');
                }

            });
        });
        </script>

        <script>

            
            function stepProgressDom(){
            
                var div_ = document.createElement('div');
                div_.classList.add('progress_');
                
                var span_ = document.createElement('span');
                var target_ = document.querySelector('.steps');
               
                div_.append(span_)
                target_.append(div_)
            
            };

            function stepProgress() {
                var ul_ = document.querySelectorAll('[role="tablist"] li');
                var target_ = document.querySelector('.progress_ span');

                ul_.forEach(function(e,i,a){

                    var calc_ = 115/a.length
                    if(e.classList.contains('done')){
                        target_.style.width = `${calc_ * (i+1)}%`;
                    }
                });
            };

            function customStepper() {
                var t_ = document.querySelectorAll('[role="tablist"] li a');
                var arr_ = new Array();
                var temp_ = function(m,n){
                    return `
                        <div class="no_">${m}</div>
                        <label>${n}</label>
                    `
                }

                t_.forEach(function(e,i,a){
                    e.querySelectorAll('span').forEach(function(el){
                        el.remove();
                    })

                    arr_.push(e.innerText)
                    e.innerHTML = '';
                    e.innerHTML += temp_((i+1), arr_[i]);
                    
                });

            }

            window.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    customStepper();
                    stepProgressDom();
                },100)
            });
			
			setTimeout(function () {
      $("body").addClass("is-loaded");
    }, 500);

        </script>
        <script>
            var passwordRules = {};
            var passwordRequirements = [
                {
                    // Must be greater than 8 characters
                    'rule': 'isMinLength',
                    'message': "Minimum length of 8 characters",
                },
                {
                    // Must contain a lowercase letter
                    'rule': 'isContainLowerCase',
                    'message': "Contains at least one lowercase alphabet (a to z)",
                },
                {
                    // Must contain an uppercase letter
                    'rule': 'isContainUpperCase',
                    'message': "Contains at least one uppercase alphabet (A to Z)",
                },
                {
                    // Must contain an integer
                    'rule': 'isContainInteger',
                    'message': "Contains at least one number (0 to 9)",
                },
                {
                    // Must contain a special character
                    'rule': 'isContainSpecialCharacter',
                    'message': "Contains at least one special character (~!@#$%-*_^)",
                }
            ];

            function generatePasswordMessages() {
                var liElement = [
                    '<li id="{%index%}" class="{%index%}">',
                    '<span class="icon_box"></span>',
                    '<span class="name_"><span>{%message%}</span></span>',
                    '</li>',
                ];

                for(var i=0; i<passwordRequirements.length; i++) {
                    str = liElement.join('');
                    str = str.replace('{%message%}', passwordRequirements[i].message);
                    str = str.replaceAll('{%index%}', "pwdrule" + (i+1));
                    $(".passcheck_list_box ul").append(str);
                }
            }

            function validatePasswordStrength(str) {
                for(var i=0; i<passwordRequirements.length; i++) {
                    var rule = passwordRequirements[i].rule;
                    var condition = false;
                    switch(rule) {
                        case 'isMinLength':
                            condition = str.length >= 8;
                            break;
                        case 'isContainLowerCase':
                            condition = str.toUpperCase() != str;
                            break;
                        case 'isContainUpperCase':
                            condition = str.toLowerCase() != str;
                            break;
                        case 'isContainInteger':
                            condition = /\d/.test(str);
                            break;
                        case 'isContainSpecialCharacter':
                            condition = /[`\'!^£$%&*()}{@#~?><>,|=_+¬-]/.test(str);
                            break;
                       
                    }
                    passwordRules[rule] = condition;
                }
            }

         

            $(document).ready(function(){
                $.validator.addMethod('validatePassword', function(value, element){
                    var response = true;
                    for(var rule in passwordRules){
                        if(!passwordRules[rule]){
                            response = false;
                        }
                    }
                    return response;
                }, "Password must meet complexity requirements.");
                
                $('input[name="password"]').on('keyup', function(e){
                    e.preventDefault();
                    //console.log($(this).val());
                    validatePasswordStrength($(this).val());
                    for(var rule in passwordRules) {
                        var index = Object.keys(passwordRules).indexOf(rule);
                        if(passwordRules[rule]){
                            $(".pwdrule" + (index+1)).addClass('passed');
                        } else {
                            $(".pwdrule" + (index+1)).removeClass('passed');
                        }
                    }
                });
            });

            generatePasswordMessages();
        </script>
    </body>
</html>