@extends($activeTemplate.'layouts.master')
@section('content')
<div class="col-xl-9 col-lg-12">
    <div class="dashboard-body account-form">
        <div class="dashboard-body__bar">
            <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
        </div>
        <div class="row gy-4 justify-content-center">
            <div class="col-lg-12">
                <div class="user-profile">
                    <form id="productCreateForm" action="{{route('user.product.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gy-3">
                            <h4 class="mb-1">@lang('Add Product')</h4>

                            <div class="col-lg-6">
                                <label for="lastname" class="form--label required">@lang('Category')<span class="text-danger">*</span></label>
                                <select class="form--control" name="category_id" id="category_id" required>
                                    <option selected disabled>@lang('Select Category')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}">{{ __($category->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name" class="form--label required">@lang('Title')<span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" value="{{old('name')}}"
                                        class="form--control" placeholder="@lang('Title')">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price" class="form--label required">@lang('Price')<span class="text-danger">*</span></label>
                                    <input type="number" name="price" id="price" value="{{old('price')}}"
                                    class="form--control" placeholder="@lang('Price')"
                                    required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="discount" class="form--label required">@lang('Discount')%</label>
                                    <input type="number" name="discount" id="discount" value="{{old('discount')}}"
                                    class="form--control" placeholder="@lang('Discount')">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="demo_link" class="form--label required">@lang('Demo Link')<span class="text-danger">*</span></label>
                                    <input type="text" name="demo_link" id="demo_link" value="{{old('demo_link')}}"
                                    class="form--control" placeholder="@lang('Demo Link')"
                                    required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="demo_link" class="form--label required">@lang('Thumbnail') (500x370)<span class="text-danger">*</span></label>
                                    <div class="file-upload-wrapper" data-text="Select your image!">
                                        <input type="file" name="thumbnail" id="thumbnail"
                                            class="file-upload-field form--control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="external_link" class="form--label required">@lang('External Link')</label>
                                    <input type="text" name="external_link" id="external_link" value="{{old('external_link')}}"
                                    class="form--control" placeholder="@lang('External Link')">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="demo_link" class="form--label required">@lang('File-Compressed')</label>
                                    <div class="file-upload-wrapper" data-text="Select your file!">
                                        <input type="file" name="file" id="file" class="file-upload-field form--control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row form-group">
                                    <div class="col-12">
                                        <label for="iamges" class="font-weight-bold form--label">@lang('Image') (894x661)<span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-9 mb-3">
                                        <div class="file-upload-wrapper" data-text="Select your image!">
                                            <input type="file" name="images[]" id="images" class="file-upload-field" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn--base  addProductImage ms-0"><i class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div id="productImage"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group ck-editor-wrapper">
                                    <label for="description" class="form--label">@lang('Description')</label>
                                    <textarea class="form--control trumEdit" name="description" placeholder="@lang('Product Description')"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="switch m-0">
                                        <span class="slider round"></span>
                                        <input type="checkbox" class="toggle-switch" name="is_free">
                                    </label>
                                    <label for="price" class="font-weight-bold">@lang('Provide it for free')?</label>
                                </div>
                            </div>

                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn--base">@lang('Create')</button>
                            </div>
                        </div>
                    </form>

                    <div id="loadingSpinnerWrapper">
                        <div id="loadingSpinner"></div>
                        <div id="spinnerPercentage">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
    .ck.ck-editor__main>.ck-editor__editable {
    min-height: 131px;
    }

    #loadingSpinnerWrapper {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
    justify-content: center;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 9999;
    width: 100%;
    height: 100vh;
}


#loadingSpinner {
    position: relative;
    width: 60px;
    height: 60px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    animation: spin 2s linear infinite;
    z-index: 999999;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}


    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

   #spinnerPercentage {
    position: absolute;
    top: 52%;
    left: 51%;
    font-size: 14px;
    color: white;
}
</style>
@endpush



@push('script')
<script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>

<script>
    (function ($) {
        "use strict";

        if ($(".trumEdit")[0]) {
            ClassicEditor
                .create(document.querySelector('.trumEdit'))
                .then(editor => {
                    window.editor = editor;
                });
        }


        var fileAdded = 0;
        $('.addProductImage').on('click', function () {
            if (fileAdded >= 2) {
                Toast.fire({
                        icon: 'warning',
                        title: 'You\'ve added maximum number of image'
                    });
                    return false;
            }
            fileAdded++;
            $("#productImage").append(`
                    <div class="row">
                        <div class="col-9 mb-3">
                            <div class="file-upload-wrapper" data-text="@lang('Select your image!')"><input type="file" name="images[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn--danger removeProductImage"><i class="la la-times ms-0"></i></button>
                        </div>
                    </div>
                `)
        });

        $(document).on('click', '.removeProductImage', function () {
            fileAdded--;
            $(this).closest('.row').remove();
        });



        // prodduct create
        $('#productCreateForm').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            var loadingSpinnerWrapper = $('#loadingSpinnerWrapper');
            var loadingSpinner = $('#loadingSpinner');
            var spinnerPercentage = $('#spinnerPercentage');

            loadingSpinnerWrapper.fadeIn();
            loadingSpinner.css('opacity', '1');

            var xhr = new XMLHttpRequest();

              xhr.upload.addEventListener("progress", function(event) {
                if (event.lengthComputable) {
                    var progress = Math.round((event.loaded / event.total) * 100);
                    spinnerPercentage.text(progress + '%');
                }
            });

            xhr.open("POST", "{{route('user.product.store')}}");

            // Success
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.hasOwnProperty('message')) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                    }
                    $('#productCreateForm')[0].reset();
                    $(".file-upload-field").val('').parent(".file-upload-wrapper").attr("data-text", "Select your file!");
                     // Reset CKEditor field
                    if (window.editor) {
                        window.editor.setData('');
                    }

                   loadingSpinnerWrapper.fadeOut();

                }else if (xhr.status === 422) {

                    loadingSpinnerWrapper.fadeOut();
                    spinnerPercentage.text('0%').fadeOut();

                    var response = JSON.parse(xhr.responseText);
                    if (response.hasOwnProperty('errors')) {
                        var errors = response.errors;
                        var errorMessage = '';

                        Object.keys(errors).forEach(function (key) {
                            errorMessage = errors[key][0];
                        });

                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                    }
                }
                 else {

                    if (xhr.status === 500) {

                        loadingSpinnerWrapper.fadeOut();
                        spinnerPercentage.text('0%').fadeOut();

                            errorMessage = 'Product could not be created. Please try again later.';
                            Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                        spinnerPercentage.fadeOut();

                    }else{
                        loadingSpinnerWrapper.fadeOut();
                        spinnerPercentage.text('0%').fadeOut();
                        var errorMessage = 'product could not be created. Please try again later.';
                        Toast.fire({
                            icon: 'error',
                            title: errorMessage
                        });
                        spinnerPercentage.fadeOut();

                    }
                }
            };

            // Error
            xhr.onerror = function() {

                loadingSpinnerWrapper.fadeOut();
                spinnerPercentage.text('0%').fadeOut();

                var errorMessage = 'An error occurred during the request. Please try again later.';
                Toast.fire({
                    icon: 'error',
                    title: errorMessage
                });
            };

            xhr.send(formData);
        });

    })(jQuery);

</script>
@endpush

