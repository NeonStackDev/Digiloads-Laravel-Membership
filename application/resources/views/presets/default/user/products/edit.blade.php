@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="col-xl-9 col-lg-12">
        <div class="dashboard-body account-form">
            <div class="dashboard-body__bar">
                <span class="dashboard-body__bar-icon"><i class="las la-bars"></i></span>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-12">
                    <div class="user-profile">
                        <form id="productCreateForm" action="{{ route('user.product.update') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <div class="row gy-3">
                                <h4 class="mb-1">@lang('Update Product')</h4>

                                <div class="col-lg-6">
                                    <label for="lastname" class="form--label required">@lang('Category')<span
                                            class="text-danger">*</span></label>
                                    <select class="form--control" name="category_id" id="category_id" required>
                                        <option selected disabled>@lang('Select Category')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                {{ __($category->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name" class="form--label required">@lang('Title')<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form--control"
                                            value="{{ $product->name }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="price" class="form--label required">@lang('Price')<span
                                                class="text-danger">*</span></label>
                                        <input type="number" name="price" id="price" value="{{ $product->price }}"
                                            class="form--control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="discount" class="form--label required">@lang('Discount')%</label>
                                        <input type="number" name="discount" id="discount"
                                            value="{{ $product->discount }}" class="form--control">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="demo_link" class="form--label required">@lang('Demo Link')<span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="demo_link" id="demo_link"
                                            value="{{ $product->demo_link }}" class="form--control" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="demo_link" class="form--label required">@lang('Thumbnail')
                                            (500x370)<span class="text-danger">*</span></label>
                                        <div class="file-upload-wrapper" data-text="Select your image!">
                                            <input type="file" name="thumbnail" id="thumbnail"
                                                class="file-upload-field form--control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="external_link" class="form--label required">@lang('External Link')</label>
                                        <input type="text" name="external_link" id="external_link"
                                            value="{{ $product->external_link }}" class="form--control"
                                            placeholder="@lang('External Link')">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="demo_link" class="form--label required">@lang('File-Compressed')</label>
                                        <div class="file-upload-wrapper" data-text="Select your file!">
                                            <input type="file" name="file" id="file"
                                                class="file-upload-field form--control">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="row form-group">
                                        <div class="col-12">
                                            <label for="iamges" class="font-weight-bold form--label">@lang('Image')
                                                (894x661)</label>
                                        </div>
                                        <div class="col-9 mb-3">
                                            <div class="file-upload-wrapper" data-text="Select your image!">
                                                <input type="file" name="images[]" id="images"
                                                    class="file-upload-field">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <button type="button" class="btn btn--base  addProductImage ms-0"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="col-12">
                                            <div id="productImage"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="description" class="form--label">@lang('Description')</label>
                                        <textarea class="form--control trumEdit" name="description">@php echo $product->description @endphp</textarea>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="switch m-0">
                                            <span class="slider round"></span>
                                            <input type="checkbox" class="toggle-switch" name="is_free">
                                        </label>
                                        <label for="price" class="font-weight-bold">@lang('Provide it for free')?</label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row mt-2 mb-2">
                                        <h5 class="thumb-img-text">@lang('Product Images')</h5>
                                        @foreach ($productImage as $image)
                                            <div class="product-image-wrap">
                                                <div class="thumb">
                                                    <img src="{{ getImage(getFilePath('productImage') . '/' . $image->url . '/' . @$image->image) }}"
                                                        alt="" style="">
                                                    <a class="crose-icon imageRemove" href="javascript:void(0)"
                                                        data-id="{{ $image->id }}">X</a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="thumbnail-wrap mb-3">
                                        <h5 class="thumb-img-text">@lang('Thumbnail Image')</h5>
                                        <img class="thumb-img"
                                            src="{{ getImage(getFilePath('productThumbnail') . '/' . @$product->thumbnail) }}"
                                            alt="thumbnail">
                                    </div>
                                </div>

                                <div class="col-lg-12 text-end">
                                    <button type="submit" class="btn btn--base">@lang('Update')</button>
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


    {{-- remove modal --}}
    <div class="modal fade" id="imageRemoveBy" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="" lass="modal-title" id="exampleModalLabel">@lang('Image Delete Confirmation')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{ route('user.product.image.delete') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>@lang('Are you sure to remove this image?')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary"
                            data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success">@lang('Confirm')</button>
                    </div>
                </form>
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
    <script src="{{ asset('assets/common/js/ckeditor.js') }}"></script>
    <script>
        (function($) {
            "use strict";

            if ($(".trumEdit")[0]) {
                ClassicEditor
                    .create(document.querySelector('.trumEdit'))
                    .then(editor => {
                        window.editor = editor;
                    });
            }

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
                        <div class="col-9 mb-3">
                            <div class="file-upload-wrapper" data-text="@lang('Select your image!')"><input type="file" name="images[]" id="inputAttachments" class="file-upload-field"/></div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn  btn--danger removeProductImage"><i class="la la-times ms-0"></i></button>
                        </div>
                    </div>
                `)
            });

            $(document).on('click', '.removeProductImage', function() {
                fileAdded--;
                $(this).closest('.row').remove();
            });


            // image remove modal open
            $('.imageRemove').on('click', function() {
                var modal = $('#imageRemoveBy');
                modal.find('input[name=id]').val($(this).data('id'))
                modal.modal('show');
            });




            // prodduct update
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

                xhr.open("POST", "{{ route('user.product.update') }}");

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

                        loadingSpinnerWrapper.fadeOut();

                        // redirect checkout page
                        window.location.href = '{{ route('user.product.index') }}';

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
                            errorMessage = 'Product could not be update. Please try again later.';

                            Toast.fire({
                                icon: 'error',
                                title: errorMessage
                            });
                        } else {
                            loadingSpinnerWrapper.fadeOut();
                            spinnerPercentage.text('0%').fadeOut();
                            var errorMessage = 'product could not be update. Please try again later.';
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
