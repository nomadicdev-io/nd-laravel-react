<script>
    $(document).ready(function() {
        switchSection($('#post_lang').val());
    });
    $('#post_lang').on('change', function() {
        switchSection($(this).val());
    });

    function switchSection(postLang) {

        var chlang = (postLang == 'en') ? 'ar' : 'en';
        if (postLang) {


            $('.changelang_' + postLang).show();
            $('.changelang_' + chlang).hide();

            if (postLang == 'en') {
                $('#post_title_arabic').prop('required', false);
            } else {
                $('#post_title').prop('required', false);
            }



            /*  if (postLang == 'ar') {
                  $('#post_title').prop('dir', 'rtl');
              } else {
                  $('#post_title').prop('dir', 'ltr');
              }*/
        } else {



            $('.changelang_' + postLang).hide();
            $('.changelang_' + chlang).show();
            $('#post_title').prop('dir', 'ltr');
            $('#news_link_arabic').prop('required', true);
        }
    }

    $('#post_category').on('change', function() {
        var catID = $(this).val();
        if (catID) {
            $.ajax({
                url: "{{ apa('category/get-subcategory') }}/" + catID,
                dataType: "json",
                type: "get",
                data: {},
                success: function(data) {
                    $('#post_sub_category').html(data.options);
                }
            });
        } else {
            $('#post_sub_category').html('<option >Select</option>');
        }

    });
</script>
