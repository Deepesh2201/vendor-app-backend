@extends('layouts.admin.app')

@section('title', 'Update vacancy info')
@push('css_or_js')
<link rel="stylesheet" href="{{ asset('/public/assets/admin/css/intlTelInput.css') }}" />
<link rel="stylesheet"
    href="{{ url('https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css') }}">
@endpush

<style>
.ti-trash {
    font-size: 20px;
    color: red;
    margin-left: 5px;
}
</style>

@section('content')
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-header-title">
            <span class="page-header-icon">
                <img src="{{ asset('public/assets/admin/img/edit.png') }}" class="w--26" alt="">
            </span>
            <span>Update Job Details</span>
        </h1>
    </div>

    <!-- End Page Header -->
    <form method="post" action="{{ url('admin/jobs/update') }}/{{ $post->id }}" class="js-validate"
        enctype="multipart/form-data" id="vendor_form">
        @csrf
        <div class="row g-2">
            <div class="col-lg-6">
                <div class="card shadow--card-2">
                    <div class="card-body">




                        <div class="lang_form" id="default-form">
                            <div class="form-group">
                                <label class="input-label" for="">Company Name
                                </label>
                                <input type="text" name="company_name" id="" value="{{ $post->company_name ?? '' }}"
                                    class="form-control" placeholder="Company Name">
                            </div>

                            <div class="form-group">
                                <label class="input-label" for=""> Job Title
                                </label>
                                <input type="text" name="job_title" id="" class="form-control" placeholder=" Job Tilte"
                                    value="{{ $post->job_title ?? '' }}">
                            </div>

                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ translate('messages.Description') }}</label>
                                <textarea type="text" name="job_description"
                                    placeholder="{{ translate('messages.Description') }}"
                                    class="form-control min-h-90px ckeditor">{{ $post->job_description ?? '' }}</textarea>
                            </div>


                            <div class="form-group">
                                <label class="input-label" for="">Designation
                                </label>
                                <input type="text" name="designation" id="" class="form-control"
                                    placeholder="Designation" value="{{ $post->designation ?? '' }}">
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-6 col-md-sm-6">

                                    <label class="input-label" for="">Min Salary
                                    </label>
                                    <input type="text" name="salary_min" id="" class="form-control"
                                        placeholder="Min Salary"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        value="{{ intval($post->salary_min) ?? '' }}">


                                </div>
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <label class="input-label" for="">Max Salary
                                    </label>
                                    <input type="text" name="salary_max" id="" class="form-control"
                                        placeholder="Max Salary"
                                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                        value="{{ intval($post->salary_max) ?? '' }}">

                                </div>
                            </div>



                            <div class="form-group">
                                <label class="input-label" for="">Location
                                </label>
                                <input type="text" name="location" id="" class="form-control" placeholder="Location"
                                    value="{{ $post->location ?? '' }}">
                            </div>


                            <div class="row">
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Min Education
                                        </label>
                                        <input type="text" name="min_education" id="" class="form-control"
                                            placeholder="Min Education" value="{{ $post->min_education ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Experience
                                        </label>
                                        <input type="text" name="experience" id="" class="form-control"
                                            placeholder="Experience" value="{{ $post->experience ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Contact Personal Name
                                        </label>
                                        <input type="text" name="contact_person_name" id="" class="form-control"
                                            placeholder="name" value="{{ $post->contact_person_name ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Contact No.
                                        </label>
                                        <input type="text" name="contact_no" id="" class="form-control"
                                            placeholder="contact number" value="{{ $post->contact_no ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Contact Email Id
                                        </label>
                                        <input type="text" name="contact_email_id" id="" class="form-control"
                                            placeholder="contact email" value="{{ $post->contact_email ?? '' }}">
                                    </div>
                                </div>
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Website
                                        </label>
                                        <input type="text" name="website" id="" class="form-control"
                                            placeholder="website" value="{{ $post->website ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Index
                                        </label>
                                        <input type="text" name="" id="" class="form-control" placeholder="Index"
                                            value="">
                                    </div>

                                </div>
                                <div class="col-6 col-md-6 col-md-sm-6">
                                    <div class="form-group">
                                        <label class="input-label" for="">Status
                                        </label>
                                        <select type="date" name="" id="" class="form-control" value="">
                                            <option value="0">In Review</option>
                                            <option value="1">Approved</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group">
                                <label class="input-label" for="">Job Type
                                </label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <input type="radio" name="job_type" id="" class="" value="1"
                                            {{ $post->job_type == 1 ? 'checked' : '' }}><span class="ml-2">Full
                                            time</span>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <input type="radio" name="job_type" id="" class=""
                                            {{ $post->job_type == 2 ? 'checked' : '' }} value="2"><span
                                            class="ml-2">Part Time</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Shift
                                </label>
                                <div class="row">
                                    @php
                                    $shiftId = explode(',', $post->shift);
                                    @endphp
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" value="1" @if (in_array(1,
                                            $shiftId)) checked @endif><span class="ml-2">Day Shift</span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" placeholder="dd/mm/yyyy"
                                            value="2" @if (in_array(2, $shiftId)) checked @endif><span
                                            class="ml-2">Night
                                            Shift</span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" value="3" @if (in_array(3,
                                            $shiftId)) checked @endif><span class="ml-2">Rotational shift</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow--card-2">
                    <div class="card-header">
                        <h5 class="card-title">
                            <span class="card-header-icon mr-1"><i class="tio-image"> </i></span>
                            <span>Company Logo</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-wrap flex-sm-nowrap __gap-12px">

                            <div class="row">
                                <div class="col-md-12 col-12 col-lg-12">
                                    <label class="__custom-upload-img mr-lg-5">

                                        <label class="form-label">
                                            {{ translate('logo') }} <span
                                                class="text--primary">({{ translate('1:1') }})</span>
                                        </label>
                                        <center>
                                            @php
                                            $filePath = public_path('images/post-images/' . $post->logo);
                                            @endphp

                                            <img class="img--vertical min-height-170px min-width-170px"
                                                id="imagePreview1"
                                                src="{{ file_exists($filePath) ? url('/images/post-images/' . $post->logo) : asset('public/assets/admin/img/upload-img.png') }}"
                                                onerror="this.src='{{ asset('public/assets/admin/img/upload-img.png') }}'"
                                                alt="Fav icon" />
                                        </center>
                                        <input type="file" name="logo" id="imageUpload1" class="custom-file-input"
                                            accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    </label>
                                    <i class="ti ti-trash" data-image-id="{{ $post->id }}"
                                        data-image-column="image2"></i>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>



    <br>

        @if ($post->user)
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2"><i class="tio-user"></i></span>
                        <span>{{ translate('messages.owner_information') }}</span>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group mb-0">
                                <label class="input-label" for="f_name">{{ translate('messages.Full_Name') }}</label>
                                <input type="text" name="f_name" class="form-control"
                                    placeholder="{{ translate('messages.first_name') }}"
                                    value="{{ $post->user->f_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ translate('messages.email') }}</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="{{ translate('messages.Ex:') }} ex@example.com"
                                    value="{{ $post->user->email ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group mb-0">
                                <label class="input-label" for="phone">{{ translate('messages.phone') }}</label>
                                <input type="text" id="phone" name="phone" class="form-control"
                                    placeholder="{{ translate('messages.Ex:') }} 017********"
                                    value="{{ $post->user->phone ?? '' }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif


        <div class="col-lg-12">
            <div class="btn--container justify-content-end">
                <button type="reset" id="reset_btn" class="btn btn--reset">{{ translate('messages.reset') }}</button>
                <button type="submit" class="btn btn--primary">{{ translate('messages.submit') }}</button>
            </div>
        </div>
</div>
</form>
</div>

@endsection

@push('script_2')
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput.min.js"
    integrity="sha512-QMUqEPmhXq1f3DnAVdXvu40C8nbTgxvBGvNruP6RFacy3zWKbNTmx7rdQVVM2gkd2auCWhlPYtcW2tHwzso4SA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"
    integrity="sha512-hkmipUFWbNGcKnR0nayU95TV/6YhJ7J9YUAkx4WLoIgrVr7w1NYz28YkdNFMtPyPeX1FrQzbfs3gl+y94uZpSw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.min.js"
        integrity="sha512-lv6g7RcY/5b9GMtFgw1qpTrznYu1U4Fm2z5PfDTG1puaaA+6F+aunX+GlMotukUFkxhDrvli/AgjAu128n2sXw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags.png"
    type="image/x-icon">
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags@2x.png"
    type="image/x-icon">


<script src="{{ asset('public/assets/admin/js/spartan-multi-image-picker.js') }}"></script>
<script type="text/javascript">
$(function() {
    $("#coba").spartanMultiImagePicker({
        fieldName: 'identity_image[]',
        maxCount: 5,
        rowHeight: '120px',
        groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
        maxFileSize: '',
        placeholderImage: {
            image: '{{ asset('
            public / assets / admin / img / 400 x400 / img2.jpg ') }}',
            width: '100%'
        },
        dropFileLabel: "Drop Here",
        onAddRow: function(index, file) {

        },
        onRenderedPreview: function(index) {

        },
        onRemoveRow: function(index) {

        },
        onExtensionErr: function(index, file) {
            toastr.error(
                '{{ translate('
                messages.please_only_input_png_or_jpg_type_file ') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
        },
        onSizeErr: function(index, file) {
            toastr.error('{{ translate('
                messages.file_size_too_big ') }}', {
                    CloseButton: true,
                    ProgressBar: true
                });
        }
    });
});
</script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ \App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value }}&libraries=places&callback=initMap&v=3.45.8">
</script>

<script>
function previewImage(input, imageId) {
    const fileInput = document.getElementById(input);
    const imagePreview = document.getElementById(imageId);

    fileInput.addEventListener('change', function() {
        if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        }
    });
}

// Call the function for each image input
previewImage('imageUpload1', 'imagePreview1');


// Attach a click event handler to the trash icons
$('i.ti-trash').on('click', function() {
    alert('test')
    const trashIcon = $(this);
    const imageId = $(this).data('image-id');
    // const imageColumn = $(this).data('image-column');

    if (imageId) {
        // Make an AJAX request to delete the image
        $.ajax({
            url: `{{ url('admin/jobs/delete-logo') }}/${imageId}`,
            type: 'get', // Use the appropriate HTTP method
            success: function(response) {
                if (response.message) {
                    toastr.success(response.message);
                    var defUrl = `{{ asset('public/assets/admin/img/upload-img.png') }}`
                    trashIcon.parent().find('img').attr('src', defUrl);
                    // $(this).parent().remove();
                }
            }
        });
    }
});
</script>
@endpush