@extends('admin.layouts.app')
@section('panel')
    <div class="row mb-none-30">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body">
                    <form id="productCreateForm" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">@lang('Category')</label>
                                    <select class="form-control" name="category_id" required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold">@lang('Title')</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="form-control" placeholder="@lang('Name')" required>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">@lang('Price')</label>
                                    <input type="number" name="price" id="price" value="{{ old('price') }}"
                                        class="form-control " placeholder="@lang('Price')" required>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="discount" class="font-weight-bold">@lang('Discount') %</label>
                                    <input type="number" name="discount" id="discount" value="{{ old('discount') }}"
                                        class="form-control " placeholder="@lang('Discount')">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="demo_link" class="font-weight-bold">@lang('Demo Link')</label>
                                    <input type="text" name="demo_link" id="demo_link" value="{{ old('demo_link') }}"
                                        class="form-control " placeholder="@lang('Demo Link')" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="thumbnail" class="font-weight-bold">@lang('Thumbnail') (500x370)</label>
                                    <div class="file-upload-wrapper" data-text="Select your image!">
                                        <input type="file" name="thumbnail" id="thumbnail" class="file-upload-field"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="external_link" class="font-weight-bold">@lang('External Link')</label>
                                    <input type="text" name="external_link" id="external_link"
                                        value="{{ old('external_link') }}" class="form-control "
                                        placeholder="@lang('External Link')">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="file" class="font-weight-bold">@lang('File-Compressed')</label>
                                    <div class="file-upload-wrapper" data-text="Select your file!">
                                        <input type="file" name="file" id="file" class="file-upload-field">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row form-group">
                                    <div class="col-12">
                                        <label for="iamges" class="font-weight-bold">@lang('Image') (894x661)</label>
                                    </div>
                                    <div class="col-10 mb-3">
                                        <div class="file-upload-wrapper" data-text="Select your image!">
                                            <input type="file" name="images[]" id="images" class="file-upload-field" required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="btn btn--primary addProductImage ms-0"><i
                                                class="fa fa-plus"></i></button>
                                    </div>
                                    <div class="col-12">
                                        <div id="productImage"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description" class="font-weight-bold">@lang('Description')</label>
                                    <textarea class="form-control trumEdit " name="description" id="descripton" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="price" class="font-weight-bold">@lang('Free')?</label>
                                    <label class="switch m-0">
                                        <input type="checkbox" class="toggle-switch" name="is_free">
                                        <span class="slider round"></span>
                                    </label>
                                </div>
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn--primary btn-global">@lang('create')</button>
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
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.product.index') }}" class="btn btn-sm btn--primary ">@lang('Back')</a>
@endpush

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
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
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
    <script>
        (function($) {
            "use strict";

            var fileAdded = 0;
            $('.addProductImage').on('click', function() {
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
                        <div class="col-10 mb-3">
                            <div class="file-upload-wrapper" data-text="@lang('Select your image!')"><input type="file" name="images[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn btn--danger removeProductImage"><i class="la la-times ms-0"></i></button>
                        </div>
                    </div>
                `)
            });

            $(document).on('click', '.removeProductImage', function() {
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

                xhr.open("POST", "{{ route('admin.product.store') }}");

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
                        $(".file-upload-field").val('').parent(".file-upload-wrapper").attr("data-text",
                            "Select your file!");
                        // Reset CKEditor field
                        if (window.editor) {
                            window.editor.setData('');
                        }

                        loadingSpinnerWrapper.fadeOut();

                    } else if (xhr.status === 422) {

                        loadingSpinnerWrapper.fadeOut();
                        spinnerPercentage.text('0%').fadeOut();

                        var response = JSON.parse(xhr.responseText);
                        if (response.hasOwnProperty('errors')) {
                            var errors = response.errors;
                            var errorMessage = '';

                            Object.keys(errors).forEach(function(key) {
                                errorMessage = errors[key][0];
                            });

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        }
                    } else {

                        if (xhr.status === 500) {
                            loadingSpinnerWrapper.fadeOut();
                            spinnerPercentage.text('0%').fadeOut();
                            errorMessage = 'Product could not be created. Please try again later.';

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        } else {
                            loadingSpinnerWrapper.fadeOut();
                            spinnerPercentage.text('0%').fadeOut();
                            var errorMessage = 'product could not be created. Please try again later.';
                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
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
