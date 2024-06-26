(function() {
    $(function () {
        categories.init();
    });

    var categories = function () {
        var images = '';
        var comments = '';
        const urlParams = new URLSearchParams(window.location.search);
        const id = urlParams.get('id');
        var siteUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port: '') + '/';


        var init = function(){
            
            $.ajax({
                url: "/api/images/" + id,
                type: "GET",
                success: function (data) {
                    var first = 0;
                    $.each(data, function (index, image) {
                        if(first === 0){
                            images+='<div class="carousel-item active">' +
                                        '<img class="carousel-image d-block w-100" src="' + siteUrl + 'storage/img/' + image.path + '">' +
                                    '</div>';
                        }else{
                            images+='<div class="carousel-item active">' +
                                        '<img class="carousel-image d-block w-100" src="' + siteUrl + 'storage/img/' + image.path + '">' +
                                    '</div>';
                        }

                    });

                    $('#carouselImages').html(images);
                }
            });

            $.getJSON('/api/products/get/' + id, function (res) {
                //console.log(res["description"]);
                $('#product_description').html(res['description']);
                $('#product_price').html(res['price']);
                $('#product_category').html(res['category']['title']);
            });
    
        };

        var initComments = function(){
            $.getJSON("/api/comments/get/" + id, function (res) {
                for(var key in res){
                    comments+='<div class="card mb-3">' +
                                '<div class="card-body">' +
                                    '<p class="card-text">' + res[key]['comment'] + '</p>' + 
                                '</div>' +
                            '</div>';
                }

                $('#commentsContainer').html(comments);
            });

        };

        var initSubmit = function(){
            $('button[data-toggle="comment"]').on('click', function (e) {
                $('#commentForm').trigger('submit');
            });
        };

        var initValidation = function(){
            $('#commentForm').validate({
                rules: {
                    comment: {
                        required: true
                    }
                },
                submitHandler: function (form) {
                    var formData = new FormData($('#commentForm')[0]);
    
                    $.ajax({
                        url: '/api/comments?product_id=' + id,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            if (res.status === 'success') {
                                $('#commentForm')[0].reset();
                                comments = '';
                                initComments();
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

        var handleElements = function(){
            $('#dropzone').on('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });
        
            $('#dropzone').on('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });
        
            $('#dropzone').on('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
                handleDrop(e);
            });

            $('#addProduct').on('show.bs.modal', function (e) {
                initCategories();
            });

            $('#addProduct').on('hide.bs.modal', function (e) {
                $('#subcategory_id').empty();
                $('#subcategoryContainer').hide();
                $('#sub_subcategory_id').empty();
                $('#sub_subcategoryContainer').hide();
            });

            $('#category_id, #filter_category_id').on('change', function () {
                var category_id = $(this).val();
                var subcategoryDropdown = $(this).attr('id') === 'category_id' ? '#subcategory_id' : '#filter_subcategory_id';
                var subcategoryContainer = $(this).attr('id') === 'category_id' ? '#subcategoryContainer' : '#filter_subcategoryContainer';
                
                populateCategories(category_id, subcategoryDropdown, subcategoryContainer);
            });

            $('#subcategory_id, #filter_subcategory_id').on('change', function () {
                var category_id = $(this).val();
                var subcategoryDropdown = $(this).attr('id') === 'subcategory_id' ? '#sub_subcategory_id' : '#filter_sub_subcategory_id';
                var subcategoryContainer = $(this).attr('id') === 'subcategory_id' ? '#sub_subcategoryContainer' : '#filter_sub_subcategoryContainer';
                
                populateCategories(category_id, subcategoryDropdown, subcategoryContainer);
            });
    
        };

        function populateCategories(categoryId, subcategoryDropdown, subcategoryContainer) {
            $(subcategoryDropdown).empty();
            $(subcategoryContainer).show();

            $.ajax({
                url: "/api/categories/getSubcategories/" + categoryId,
                type: "GET",
                success: function (data) {
                    $(subcategoryDropdown).append('<option disabled value="" selected>Please select a subcategory or leave empty</option>');
                    $.each(data, function (index, category) {
                        $(subcategoryDropdown).append('<option value="' + category.id + '">' + category.title + '</option>');
                    });
                }
            });
        }

        var initCategories = function(){
            $.ajax({
                url: "/api/categories/getCategories",
                type: "GET",
                success: function (data) {
                    $('#category_id').empty();
                    $('#filter_category_id').empty();
                    $('#category_id').append('<option value="" disabled selected>Please select a category or leave empty</option>');
                    $('#filter_category_id').append('<option value="" disabled selected>Please select a category or leave empty</option>');
                    $.each(data, function (index, category) {
                        $('#category_id').append('<option value="' + category.id + '">' + category.title + '</option>');
                        $('#filter_category_id').append('<option value="' + category.id + '">' + category.title + '</option>');
                    });
                }
            });
        };

        function handleDrop(e) {
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                if (file.type.match('image.*')) {
                    imageList.push(file);
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var image = $('<img>').attr('src', e.target.result);
                        $('#image-list').append(image);
                        markAsMain(image);
                        image.click(function() {
                            markAsMain(image);
                        });
                    }
                    reader.readAsDataURL(file);
                }
            }
        }

        function markAsMain(selectedImage) {
            $('#image-list img').removeClass('main-image');
            selectedImage.addClass('main-image');
            mainImageIndex = $('#image-list img').index(selectedImage);
        }
    

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
                initComments();
                init();
                initSubmit();
                initValidation();
                //handleElements();
                //initCategories();
            }
        }
    }();
})();
