<script type="text/javascript" src="{{ asset('assets/admin/lib/jquery/jquery-3.7.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/jquery-validator/jquery.validate.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/swal/sweetalert2-11.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/moment/min/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/ionicons/ionicons.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/plupload/v3/plupload.full.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/fancybox/jquery.fancybox.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/js/datedropper.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/pgs/js/admin.js?15') }}"></script>
<script type="text/javascript" src="{{ asset('assets/admin/lib/inputmask/js/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript">
    $('.datepicker').datepicker({
        autoclose: true,
        changeMonth: true,
        changeYear: true,

    });
    $(".landphonemaskUAE").inputmask("99 999 9999");
    $(".mobileUAE").inputmask("00\\971 999 999 999");
    $('#add-form').validate({
        ignore: [],
    });

    $.validator.addMethod("passCheck", function(value, element) {
        var pattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/;
        //var pattern = /^(?=.[A-Za-z])(?=.\d).{8,}$/;
        return this.optional(element) || pattern.test(value)
    }, "{{ trans('messages.password_contain') }}");


    function sendAjax(url, type, dataToSend, callback, async) {
        // if ($('#commonAjaxLoader').length) {
        //     $('#commonAjaxLoader').show();
        // }

        $.ajax({
            url: url,
            type: type,
            async: async !==undefined ? async :false,
            data: dataToSend,
            dataType: 'json',
            statusCode: {
                302: function() {
                    alert('Forbidden. Access Restricted');
                },
                403: function() {
                    alert('Forbidden. Access Restricted', '403');
                },
                404: function() {
                    alert('Page not found', '404');
                },
                500: function() {
                    alert('Internal Server Error', '500');
                }
            }
        }).done(function(responseData) {
            callback(responseData);
            // $('#commonAjaxLoader').hide();

        }).fail(function(jqXHR, textStatus) {
            // $('#commonAjaxLoader').hide();
            callback(jqXHR);

        });
    }
</script>

<script>
    $('.submenu ').find('.nav-link').each(function(i, el) {
        if ($(el).hasClass('active')) {
            $(el).closest('.submenu').addClass('show');
            $(el).closest('.nav-item').addClass('show');
            $(el).closest('.sub-nav-item').addClass('show');
            $(el).closest('.sp-nav-item').addClass('show');
            //var $a = $(el).closest('div').closest('li').find('a').first();
            //$a.addClass('active');
        }
    });
    /* $("a[class='nav-link with-sub active']").parent().addClass("show");
    $('a[href="' + window.location.href.split('?')[0] + '"]').closest('li.nav-item').addClass('show');
    $('a[href="' + window.location.href.split('?')[0] + '"]').addClass("active").closest('li.nav-item > .nav-link.with-sub').addClass('active'); */
</script>

<script>
    $(document).on('select2:open', function() {
        document.querySelector('.select2-search__field').focus();
    });

    $('select').select2({});

    function displayPopup(obj) {
        Swal.fire({
            // type: obj.type,
            icon: obj.type,
            html: obj.message,
            showCloseButton: true,
            confirmButtonText: "{{ lang('ok') }}",
        });
    }
</script>

<script type="text/javascript">
    function decodeHtmlEntities(encodedString) {
        var translate_re = /&(nbsp|amp|quot|lt|gt);/g;
        var translate = {
            "nbsp": " ",
            "amp": "&",
            "quot": "\"",
            "lt": "<",
            "gt": ">"
        };
        return encodedString.replace(translate_re, function(match, entity) {
            return translate[entity];
        }).replace(/&#(\d+);/gi, function(match, numStr) {
            var num = parseInt(numStr, 10);
            return String.fromCharCode(num);
        });
    }

    $(function() {
        // $('body').on('click', function(){
        //     console.log('yes');
        //     $("#azSidebarToggle").focus();
        // })
    })

    $('body').on('click', '.deleteRecord', function(e) {
        var _this = $(this);
        var _dataMsg = $(this).attr('data-message');

        var _message = (_dataMsg) ? _dataMsg :
            '{{ empty($postType) ? 'Delete this entry ?' : 'Delete this ' . $postType . ' ?' }}'
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure ?',
            text: _message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes !'
        }).then((result) => {
            if (result.value) {
                window.location.href = _this.attr('href');
            }
        });

    });
    $('.change-status.az-toggle').on('click', function() {
        window.location.href = $(this).attr('data-status-url');
    });

    $(document).ready(function() {
        $.validator.messages.required = "{{ lang('field_required') }}";
    });

    function grecaptchaExecute(capclass) {


        grecaptcha.execute('{{ Config::get('recaptchav3.sitekey') }}', {
            action: capclass
        }).
        then(function(token) {

            document.querySelector('.' + capclass).value = token;
        })

    }
</script>
