define(['jquery', 'core/ajax', 'core/url'], function (jQuery, ajax, url) {
    return {
        init: function ($params) {
            $(document).ready(function(){

                /**
                 * functionality to avoid space in the site name
                 */
                $('input[name^="wp_name"]').on({
                    keydown: function(e) {
                        if (e.which === 32)
                            return false;
                    },
                    change: function() {
                        this.value = this.value.replace(/\s/g, "");
                    }
                });


                /**
                 * functionality to test connection
                 */
                $("[id$=_eb_test_connection]").click(function(event){
                    event.preventDefault();
                    var id = $(this).prop("id");
                    id = id.replace("eb_test_connection", '');
                    id = id.replace("id_eb_buttons", '');
                    index = id.replace(/\_/g, '');
                    var url = $("#id_wp_url_" + index).val();
                    var token = $("#id_wp_token_" + index).val();
                    var parent = $(this).parent().parent();
                    parent = parent.parent();

                    var promises = ajax.call([
                        {methodname: 'eb_test_connection', args: {wp_url: url, wp_token: token}}
                    ]);

                    promises[0].done(function(response) {



                        // parent.find("#id_error_").html(response.msg);
                        // parent.find("#id_error_").css("display", "block");

                        parent.find("#eb_test_conne_response").html(response.msg);
                        parent.find("#eb_test_conne_response").css("display", "block");



                        if (response.status == 1) {
                            parent.find("#eb_test_conne_response").addClass("eb-success-msg");
                            parent.find("#eb_test_conne_response").removeClass("eb-error-msg");
                        } else {
                            parent.find("#eb_test_conne_response").removeClass("eb-success-msg");
                            parent.find("#eb_test_conne_response").addClass("eb-error-msg");
                        }
                    }).fail(function(ex) {
                       // do something with the exception
                    });
                });



                /**
                 * functionality to remove site from the sites list
                 */
                $("[id$=_eb_remove_site]").click(function(event){
                    event.preventDefault();
                    var id = $(this).prop("id");
                    id = id.replace("eb_remove_site", '');
                    id = id.replace("id_eb_buttons", '');
                    index = id.replace(/\_/g, '');

                    $("#id_wp_url_" + index).val("");
                    $("#id_wp_token_" + index).val("");
                    $("#id_wp_name_" + index).val("");


                    $("#id_wp_url_" + index).parent().parent().css("display", "none");
                    $("#id_wp_token_" + index).parent().parent().css("display", "none");
                    $("#id_wp_name_" + index).parent().parent().css("display", "none");
                    parent = $(this).parent().parent();
                    parent = parent.parent().parent();
                    parent.css("display", "none");
                });

                /**
                 * functionlaity to get site synch values on the site change
                 */
                $("#id_wp_site_list").on("change", function(){
                    var promises = ajax.call([
                        {methodname: 'eb_get_site_data', args: {site_index: $(this).val()}}
                    ]);

                    promises[0].done(function(response) {
                        $('#id_course_enrollment').prop('checked', response.course_enrollment);
                        $('#id_course_un_enrollment').prop('checked', response.course_un_enrollment);
                        $('#id_user_creation').prop('checked', response.user_creation);
                        $('#id_user_deletion').prop('checked', response.user_deletion);
                    }).fail(function(ex) {
                    });
                });
            });
        }
    };

});