@extends('layouts.admin.app')

@section('title','Update rent/sales info')
@push('css_or_js')
<link rel="stylesheet" href="{{asset('/public/assets/admin/css/intlTelInput.css')}}" />
<link rel="stylesheet" href="{{url('https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css')}}">
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

<div class="d-flex justify-content-between">
        <div>
            <h1 class="page-header-title text-break">
                <span class="page-header-icon"> 
                    <img src="{{asset('public/assets/admin/img/briefcase.png')}}" alt="deposit" class="w--26">
                </span>
                <span>Job Details</span>
            </h1>
        </div>
        <div>
            <a href="" class="btn btn--primary float-right">
                <i class="tio-edit"></i> Edit 
            </a>
        </div>
    </div>
    <br>

    

    <!-- End Page Header -->
    <form method="post" class="js-validate" enctype="multipart/form-data" id="vendor_form">


        <div class="row g-2">
            <div class="col-lg-6">
                <div class="card shadow--card-2">
                    <div class="card-body">




                        <div class="lang_form" id="default-form">
                            <div class="form-group">
                                <label class="input-label" for="">Company Name
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Company Name"
                                    value="" disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for=""> Job Title
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder=" Job Tilte" value=""
                                disabled>
                            </div>

                            <div class="form-group mb-0">
                                <label class="input-label"
                                    for="exampleFormControlInput1">{{ translate('messages.Description') }}</label>
                                <textarea type="text" name="address[]"
                                    placeholder="{{translate('messages.Description')}}"
                                    class="form-control min-h-90px ckeditor" disabled></textarea>
                            </div>


                            <div class="form-group">
                                <label class="input-label" for="">Designation
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Designation" value=""
                                disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Salary
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Min Salary" value=""
                                disabled>
                                <input type="text" name="" id="" class="form-control" placeholder="Max Salary" value=""
                                disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Location
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Location" value=""
                                disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Min Education
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Min Education"
                                    value="" disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Experience
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="Experience" value=""
                                disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Contact Personal Name
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="dd/mm/yyyy" value=""
                                    required>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Contact No.
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="dd/mm/yyyy" value=""
                                disabled>
                            </div>



                            <div class="form-group">
                                <label class="input-label" for="">Contact Email Id
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="dd/mm/yyyy" value=""
                                disabled>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Website
                                </label>
                                <input type="text" name="" id="" class="form-control" placeholder="dd/mm/yyyy" value=""
                                disabled>
                            </div>


                            <div class="form-group">
                                <label class="input-label" for="">Job Typpe
                                </label>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <input type="radio" name="jobType" id="" class="" disabled
                                            value=""><span class="ml-2">Full time</span>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-6">
                                        <input type="radio" name="jobType" id="" class="" disabled
                                            value=""><span class="ml-2">Part Time</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="input-label" for="">Shift
                                </label>
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" disabled
                                            value=""><span class="ml-2">Day Shift</span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" disabled
                                            value=""><span class="ml-2">Night Shift</span>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-4">
                                        <input type="radio" name="shift" id="" class="" disabled
                                            value=""><span class="ml-2">Rotational shift</span>
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
                                        {{ translate('logo') }} 
                                    </label>
                                    <center>
                                        <img class="img--110 min-height-170px min-width-170px" id="viewer"
                                            onerror="this.src='{{ asset('public/assets/admin/img/pinterest.png') }}'"
                                            src="" alt=""
                                            alt="logo image" />
                                    </center>
                                   
                                </label>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
</div>






<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title m-0 d-flex align-items-center">
                <span class="card-header-icon mr-2"><i class="tio-user"></i></span>
                <span>{{translate('messages.owner_information')}}</span>
            </h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group mb-0">
                        <label class="input-label" for="f_name">{{translate('messages.Full_Name')}}</label>
                        <input type="text" name="f_name" class="form-control"
                            placeholder="{{translate('messages.first_name')}}" value="" disabled>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group mb-0">
                        <label class="input-label"
                            for="exampleFormControlInput1">{{translate('messages.email')}}</label>
                        <input type="email" name="email" class="form-control"
                            placeholder="{{ translate('messages.Ex:') }} ex@example.com" value="" disabled>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <div class="form-group mb-0">
                        <label class="input-label" for="phone">{{translate('messages.phone')}}</label>
                        <input type="text" id="phone" name="phone" class="form-control"
                            placeholder="{{ translate('messages.Ex:') }} 017********" value="" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <div class="btn--container justify-content-end">
        <button type="reset" id="reset_btn" class="btn btn--reset">{{translate('messages.reset')}}</button>
        <button type="submit" class="btn btn--primary">{{translate('messages.submit')}}</button>
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/utils.min.js" integrity="sha512-lv6g7RcY/5b9GMtFgw1qpTrznYu1U4Fm2z5PfDTG1puaaA+6F+aunX+GlMotukUFkxhDrvli/AgjAu128n2sXw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags.png"
    type="image/x-icon">
<link rel="shortcut icon" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/img/flags@2x.png"
    type="image/x-icon">


<script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
<script type="text/javascript">
$(function() {
    $("#coba").spartanMultiImagePicker({
        fieldName: 'identity_image[]',
        maxCount: 5,
        rowHeight: '120px',
        groupClassName: 'col-lg-2 col-md-4 col-sm-4 col-6',
        maxFileSize: '',
        placeholderImage: {
            image: '{{asset('
            public / assets / admin / img / 400 x400 / img2.jpg ')}}',
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
            toastr.error('{{translate('
                messages.please_only_input_png_or_jpg_type_file ')}}', {
                    CloseButton: true,
                    ProgressBar: true
                });
        },
        onSizeErr: function(index, file) {
            toastr.error('{{translate('
                messages.file_size_too_big ')}}', {
                    CloseButton: true,
                    ProgressBar: true
                });
        }
    });
});
</script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&libraries=places&callback=initMap&v=3.45.8">
</script>




@endpush