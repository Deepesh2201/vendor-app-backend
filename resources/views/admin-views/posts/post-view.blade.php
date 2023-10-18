@extends('layouts.admin.app')
<style>

.gallery {
  display: grid;
  /* grid-template-rows: repeat(4, 18vh); */
  /* grid-template-columns: repeat(1, 45vw); */
  transition: all 0.3s cubic-bezier(0.5, 0.8, 0.5, 0.2);
  background-color: #82a6cb;
  border-radius: 10px;
  padding: 0.25em;
  cursor: zoom-in;
}
@media (min-width: 40em) {
  .gallery {
    grid-template-rows: repeat(1, 20vh);
  }
}
@media (min-width: 10em) and (orientation: landscape) {
  .gallery {
    grid-template-columns: repeat(5, 18vw);
    grid-template-rows: repeat(2, 45vh);
  }
}
@media (min-width: 60em) {
  .gallery {
    grid-template-columns: repeat(10, 8vw);
    grid-template-rows: 25vh;
  }
}

.gallery img {
  object-fit: cover;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  transition: all 0.15s cubic-bezier(0.3, 0.1, 0.3, 0.85);
  position: relative;
  box-shadow: 0 0 0 #0000;
  /* opacity: 0.67; */
  /* filter: sepia(80%) hue-rotate(180deg); */
}
.gallery img:first-child {
  border-radius: 10px 10px 0 0;
}
.gallery img:last-child {
  border-radius: 0 0 10px 10px;
}
@media (min-width: 40em) and (max-width: 59.99em) {
  .gallery img:first-child {
    border-radius: 10px 0 0 0;
  }
  .gallery img:nth-child(5) {
    border-radius: 0 10px 0 0;
  }
  .gallery img:nth-child(6) {
    border-radius: 0 0 10px 0;
  }
  .gallery img:last-child {
    border-radius: 0 0 0 10px;
  }
}
@media (min-width: 60em) {
  .gallery img:first-child {
    border-radius: 10px 0 0 10px;
  }
  .gallery img:last-child {
    border-radius: 0 10px 10px 0;
  }
}
.gallery img:hover {
  opacity: 1;
  z-index: 1;
  box-shadow: 1em 1em 1em #0004;
  transition: all 0.3s cubic-bezier(0.3, 0.1, 0.3, 0.85);
  filter: sepia(0%) hue-rotate(0deg);
  border-radius: 5px;
  width: 250%;
  height: 250%;
  left: -100%;
  top: -100%;
}
@media (min-width: 40em) {
  .gallery img:hover {
    width: 250%;
    height: 500%;
    left: -75%;
    top: -200%;
  }
}
@media (min-width: 10em) and (orientation: landscape) {
  .gallery img:hover {
    width: 250%;
    height: 200%;
  }
}
@media (min-width: 40em) and (orientation: portrait) {
  .gallery img:hover {
    width: 300%;
    height: 300%;
    left: -100%;
    top: -100%;
  }
}
@media (min-width: 60em) {
  .gallery img:hover {
    width: 350%;
    height: 150%;
    left: -75%;
    top: -25%;
  }
  .gallery img:hover ~ img {
    left: 175%;
  }
}
@media (min-width: 60em) and (orientation: landscape) {
  .gallery img:hover {
    width: 300%;
    height: 300%;
    left: -75%;
    top: -100%;
  }
  .gallery img:hover ~ img {
    left: 100%;
  }
}
</style>



@push('css_or_js')
<!-- Custom styles for this page -->
<link href="{{asset('public/assets/admin/css/croppie.css')}}" rel="stylesheet">
@endpush

@section('content')
<div class="content container-fluid">

    <div class="d-flex justify-content-between">
        <div>
            <h1 class="page-header-title text-break">
                <span class="page-header-icon">
                    <img src="{{asset('public/assets/admin/img/house.png')}}" alt="deposit" class="w--26">
                </span>
                <span>Title</span>
            </h1>
        </div>
        <div>
            <a href="http://127.0.0.1:8000/admin/store/edit/2" class="btn btn--primary float-right">
                <i class="tio-edit"></i> Edit 
            </a>
        </div>
    </div>
    <br>



    <!-- Page Heading -->

    <div class="row g-3 text-capitalize">
        <!-- Earnings (Monthly) Card Example -->
        <!-- <div class="col-md-4">
            <div class="card h-100 card--bg-1">
                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center">
                    <h5 class="cash--subtitle text-white">
                    Collected Cash 
                    </h5>
                    <div class="d-flex align-items-center justify-content-center mt-3">
                        <div class="cash-icon mr-3">
                            <img src="{{asset('public/assets/admin/img/cash.png')}}" alt="img">
                        </div>
                        <h2 class="cash--title text-white">0</h2>
                    </div>
                </div>
                <div class="card-footer pt-0 bg-transparent border-0">
                    <button class="btn text-white text-capitalize bg--title h--45px w-100" id="collect_cash"
                        type="button" data-toggle="modal" data-target="#collect-cash"
                        title="Collect Cash">collect cash 
                    </button>
                    {{-- <a class="btn text-white text-capitalize bg--title h--45px w-100" href="">collect cash</a>
                    --}}
                </div>
            </div>
        </div> -->
        <div class="col-md-12">
            <div class="row g-3">
                <!-- Panding Withdraw Card Example -->
                <div class="col-sm-4">
                    <div class="resturant-card card--bg-2">
                        <h4 class="title">$ 12000</h4>
                        <div class="subtitle">Deposit</div>
                        <img class="resturant-icon w--30"
                            src="{{asset('public/assets/admin/img/cash.png')}}" alt="deposit">
                    </div>
                </div>

                <!-- Earnings (Monthly) Card Example -->
                <div class="col-sm-4">
                    <div class="resturant-card card--bg-3">
                        <h4 class="title">$1000</h4>
                        <div class="subtitle">Rent</div>
                        <img class="resturant-icon w--30"
                            src="{{asset('assets/admin/img/transactions/moneyDoller1.png')}}"
                            alt="transaction">
                    </div>
                </div>

                <!-- Collected Cash Card Example -->
                <div class="col-sm-4">
                    <div class="resturant-card card--bg-4">
                        <h4 class="title">20 Dec 2023</h4>
                        <div class="subtitle">Possession</div>
                        <img class="resturant-icon w--30"
                            
                            src="{{asset('assets/admin/img/schedule.png')}}" alt="deposit"
                            alt="transaction">
                    </div>
                </div>

                <!-- Pending Requests Card Example -->
                <!-- <div class="col-sm-6">
                    <div class="resturant-card card--bg-1">
                        <h4 class="title">total_earning</h4>
                        <div class="subtitle">total_earning</div>
                        <img class="resturant-icon w--30"
                            src="{{asset('public/assets/admin/img/transactions/earning.png')}}" alt="transaction">
                    </div>
                </div> -->
            </div>

        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title m-0 d-flex align-items-center">
                <span class="card-header-icon mr-2">
                    <i class="tio-home-outlined"></i>
                </span>
                <span class="ml-1">House Info</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-lg-12">
                    <div class="resturant--info-address">
                        <div class="logo">
                            <img onerror="this.src='{{asset('public/assets/admin/img/100x100/1.png')}}'" src=""
                                alt="Logo">
                        </div>
                        <div class="left-list">
                            <ul class="address-info list-unstyled list-unstyled-py-3 text-dark">
                                <li>
                                    <h5 class="name">name</h5>
                                    
                                </li>
                                
                                <li>
                                    <!-- <i class="tio-city nav-icon"></i> -->
                                    <span>Address</span> <span>:&nbsp;</span> <span>address</span>
                                </li>

                                <li>
                                    <!-- <i class="tio-call-talking nav-icon"></i> -->
                                    <span>Email</span> <span>:&nbsp;</span> <span>email</span>
                                </li>
                                <li>
                                    <!-- <i class="tio-email nav-icon"></i> -->
                                    <span>Phone</span> <span>:&nbsp;</span> <span>phone</span>
                                </li>
                            </ul>
                        </div>
                        <div class="left-right" style="margin-left:50px">
                             <ul class="address-info list-unstyled list-unstyled-py-3 text-dark">
                                <li>
                                    &nbsp;
                                </li>
                               
                                <li>
                                    <!-- <i class="tio-bed nav-icon"></i> -->
                                    <span>Bedroom</span> <span>:&nbsp;</span> <span>2</span>
                                </li>

                                <li>
                                    <!-- <i class="tio-tub nav-icon"></i> -->
                                    <span>Bathroom</span> <span>:&nbsp;</span> <span>1</span>
                                </li>
                                <li>
                                    <!-- <i class="tio-email nav-icon"></i> -->
                                    <span>Floor</span> <span>:&nbsp;</span> <span>2</span>
                                </li>
                            </ul>

                        </div>


                        <div class="left-right" style="margin-left:50px">
                             <ul class="address-info list-unstyled list-unstyled-py-3 text-dark">
                                <li>
                                    &nbsp;
                                </li>
                               
                                <li>
                                    <!-- <i class="tio-bed nav-icon"></i> -->
                                    <span>Aminity</span> <span>:&nbsp;</span> <span>1</span>
                                </li>

                                <li>
                                    <!-- <i class="tio-tub nav-icon"></i> -->
                                    <span>Aminity</span> <span>:&nbsp;</span> <span>2</span>
                                </li>
                                <li>
                                    <!-- <i class="tio-email nav-icon"></i> -->
                                    <span>Aminity</span> <span>:&nbsp;</span> <span>3</span>
                                </li>
                            </ul>

                        </div>
                        
                    </div>
                    <br>
                    <p>Description Description Description Description Description Description Description Description </p>
                </div>
                <!-- <div class="col-lg-6">
                    
                
                </div> -->
            </div>
        </div>
    </div>
    <div class="row pt-3 g-3">
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2">
                            <i class="tio-user"></i>
                        </span>
                        <span class="ml-1">{{translate('messages.owner_info')}}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="resturant--info-address">
                        <div class="avatar avatar-xxl avatar-circle avatar-border-lg">
                            <img class="avatar-img"
                                onerror="this.src='{{asset('public/assets/admin/img/160x160/img1.jpg')}}'" src=""
                                alt="Image Description">
                        </div>
                        <ul class="address-info address-info-2 list-unstyled list-unstyled-py-3 text-dark">
                            <li>
                                <h5 class="name">Name</h5>
                            </li>
                            <li>
                                <i class="tio-call-talking nav-icon"></i>
                                <span class="pl-1">email</span>
                            </li>
                            <li>
                                <i class="tio-email nav-icon"></i>
                                <span class="pl-1">phone</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0 d-flex align-items-center">
                        <span class="card-header-icon mr-2">
                            <i class="tio-image"></i>
                        </span>
                        <span class="ml-1">{{translate('messages.House Images')}}</span>
                    </h5>
                </div>
                <div class="card-body">
                <div class="gallery">
                    <img src='https://images.unsplash.com/photo-1544568100-847a948585b9?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt=''>
                    <img src='https://images.unsplash.com/photo-1517423440428-a5a00ad493e8?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt=''>
                    <img src='https://images.unsplash.com/photo-1510771463146-e89e6e86560e?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt=''>
                    <img src='https://images.unsplash.com/photo-1507146426996-ef05306b995a?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt=''>
                    
                    </div>
                </div>
                </div>
            </div>
        </div>

      
    </div>
</div>

<div class="modal fade" id="collect-cash" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{translate('messages.collect_cash_from_store')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.transactions.account-transaction.store')}}" method='post'
                    id="add_transaction">
                    @csrf
                    <input type="hidden" name="type" value="store">
                    <input type="hidden" name="store_id" value="">
                    <div class="form-group">
                        <label class="input-label">{{translate('messages.payment_method')}} <span
                                class="input-label-secondary text-danger">*</span></label>
                        <input class="form-control" type="text" name="method" id="method" required maxlength="191"
                            placeholder="{{translate('messages.Ex_:_Card')}}">
                    </div>
                    <div class="form-group">
                        <label class="input-label">{{translate('messages.reference')}}</label>
                        <input class="form-control" type="text" name="ref" id="ref" maxlength="191">
                    </div>
                    <div class="form-group">
                        <label class="input-label">{{translate('messages.amount')}} <span
                                class="input-label-secondary text-danger">*</span></label>
                        <input class="form-control" type="number" min=".01" step="0.01" name="amount" id="amount"
                            max="999999999999.99" placeholder="{{translate('messages.Ex_:_1000')}}">
                    </div>
                    <div class="btn--container justify-content-end">
                        {{-- <button type="reset" class="btn btn--reset">{{translate('reset')}}</button> --}}
                        <button type="submit" id="submit_new_customer"
                            class="btn btn--primary">{{translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script_2')
<!-- Page level plugins -->
<script>
// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>
<script
    src="https://maps.googleapis.com/maps/api/js?key={{\App\Models\BusinessSetting::where('key', 'map_api_key')->first()->value}}&callback=initMap&v=3.45.8">
</script>
<script>
// const myLatLng = { lat: , lng:  };
// let map;
// initMap();
// function initMap() {
//          map = new google.maps.Map(document.getElementById("map"), {
//         zoom: 15,
//         center: myLatLng,
//     });
//     new google.maps.Marker({
//         position: myLatLng,
//         map,
//         title: "",
//     });
// }
</script>
<script>
$(document).on('ready', function() {
    // INITIALIZATION OF DATATABLES
    // =======================================================
    var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

    $('#column1_search').on('keyup', function() {
        datatable
            .columns(1)
            .search(this.value)
            .draw();
    });

    $('#column2_search').on('keyup', function() {
        datatable
            .columns(2)
            .search(this.value)
            .draw();
    });

    $('#column3_search').on('change', function() {
        datatable
            .columns(3)
            .search(this.value)
            .draw();
    });

    $('#column4_search').on('keyup', function() {
        datatable
            .columns(4)
            .search(this.value)
            .draw();
    });


    // INITIALIZATION OF SELECT2
    // =======================================================
    $('.js-select2-custom').each(function() {
        var select2 = $.HSCore.components.HSSelect2.init($(this));
    });
});

function request_alert(url, message) {
    Swal.fire({
        title: '{{translate('
        messages.are_you_sure ')}}',
        text: message,
        type: 'warning',
        showCancelButton: true,
        cancelButtonColor: 'default',
        confirmButtonColor: '#FC6A57',
        cancelButtonText: '{{translate('
        messages.no ')}}',
        confirmButtonText: '{{translate('
        messages.yes ')}}',
        reverseButtons: true
    }).then((result) => {
        if (result.value) {
            location.href = url;
        }
    })
}
</script>
<!-- <script>
        $('#add_transaction').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post({
                url: '{{route('admin.transactions.account-transaction.store')}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.errors) {
                        for (var i = 0; i < data.errors.length; i++) {
                            toastr.error(data.errors[i].message, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    } else {
                        toastr.success('{{translate('messages.transaction_saved')}}', {
                            CloseButton: true,
                            ProgressBar: true
                        });
                        setTimeout(function () {
                            location.href = '';
                        }, 2000);
                    }
                }
            });
        });
    </script> -->
@endpush