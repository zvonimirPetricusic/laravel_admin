(function() {
    $(function () {
        users.init();
    });

    var users = function () {
        var deferred = $.Deferred();
        var datatable;

        var initTable = function(){
            datatable = $('#users').DataTable({
                ajax: {
                    url: '/api/users',
                    dataSrc: ''
                },
                columns: [
                    {data: 'name' },
                    {data: 'email' },
                    {data: 'role.title'}
                ]
            });
        };

        var initSubmit = function(){
            $('#addUser button[data-toggle="save-form"]').on('click', function (e) {
                $('#addUser form').trigger('submit');
            });
        };

        var initValidation = function(){
            $('#addUser form').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true
                    },
                    password: {
                        required: true
                    },
                    role_id: {
                        required: true
                    },
                },
                submitHandler: function (form) {
                    var formData = new FormData($('#addUser form')[0]);
    
                    $.ajax({
                        url: '/api/users',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.status === 'success') {
                                alertResponse('Success', res.message, 'success');
                                $('#addUser .close').click();
                                $('#addUser form')[0].reset();
                                datatable.ajax.reload();
                            }else{
                                alertResponse('Error', 'Error while submitting form!', 'error');
                            }
                        },
                        error: function (res) {
                            alertResponse('Error', res.responseJSON.message, 'error');
                        }
                    });
                }
            });
        };

        var alertResponse = function (title, text, icon){
            swal.fire({
                title: title,
                text: text,
                icon: icon
            });
            return deferred.resolve();
        };
    
        return {
            init: function () {
                initTable();
                initSubmit();
                initValidation();
            }
        }
    }();
})();
