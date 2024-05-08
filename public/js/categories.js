(function() {
    $(function () {
        categories.init();
    });

    var categories = function () {
        var deferred = $.Deferred();
        var datatable;

        var initTable = function(){
            datatable = $('#categories').DataTable({
                ajax: {
                    url: '/api/categories',
                    dataSrc: ''
                },
                columns: [
                    {
                        data: 'title', render: function (data, type, row) { 
                            return '<span class="badge badge-success">' + data + '</span>&nbsp;';;
                        }
                    },
                    {
                        data: 'subcategories', render: function (data, type, row) {
                            var subcategories = '';
                            for(var key in data){
                                subcategories+= '<span class="badge badge-primary">' + data[key]['title'] + '</span>&nbsp;';
                            }
                            return subcategories;
                        }
                    },
                    {
                        data: 'subcategories', 
                        render: function (data, type, row) {
                            var subcategories = '';
                            for (var key in data) {
                                if (data[key].hasOwnProperty('sub_subcategories')) {
                                    for (var subKey in data[key].sub_subcategories) {
                                        subcategories += '<span class="badge badge-warning">' + data[key].sub_subcategories[subKey] + '</span>&nbsp;';
                                    }
                                }
                            }
                            return subcategories;
                        }
                    }
                ]
            });
        };

        var initSubmit = function(){
            $('#addCategory button[data-toggle="save-form"]').on('click', function (e) {
                $('#addCategory form').trigger('submit');
            });
        };

        var initValidation = function(){
            $('#addCategory form').validate({
                rules: {
                    title: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var formData = new FormData($('#addCategory form')[0]);
    
                    $.ajax({
                        url: '/api/categories',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.status === 'success') {
                                alertResponse('Success', res.message, 'success');
                                $('#addCategory .close').click();
                                $('#addCategory form')[0].reset();
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

        var initCategories = function(){
            $.ajax({
                url: "/api/categories/getCategories",
                type: "GET",
                success: function (data) {
                    $('#category_id').empty();
                    $('#category_id').append('<option value="" disabled selected>Please select a category or leave empty</option>');
                    $.each(data, function (index, category) {
                        $('#category_id').append('<option value="' + category.id + '">' + category.title + '</option>');
                    });
                }
            });
        };

        var handleElements = function(){
            $('#addCategory').on('show.bs.modal', function (e) {
                initCategories();
            });

            $('#addCategory').on('hide.bs.modal', function (e) {
                $('#subcategory_id').empty();
                $('#subcategoryContainer').hide();
            });

            $('#category_id').on('change', function () {
                var category_id = $(this).val();
                $('#subcategory_id').empty();
                $('#subcategoryContainer').show();

                $.ajax({
                    url: "/api/categories/getSubcategories/" + category_id,
                    type: "GET",
                    success: function (data) {
                        $('#subcategory_id').append('<option disabled value="" selected>Please select a subcategory or leave empty</option>');
                        $.each(data, function (index, category) {
                            $('#subcategory_id').append('<option value="' + category.id + '">' + category.title + '</option>');
                        });
                    }
                });
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
                handleElements();
            }
        }
    }();
})();
