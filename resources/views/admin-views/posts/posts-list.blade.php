@extends('layouts.admin.app')

@section('title',translate('posts_list'))

@push('css_or_js')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="content container-fluid">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-header-title"><i class="tio-filter-list"></i> {{translate('messages.posts')}} <span class="badge badge-soft-dark ml-2" id="itemCount">{{$posts->count() ?? '0'}}</span></h1>
            <div class="page-header-select-wrapper">
                @if(!isset(auth('admin')->user()->zone_id))
                    <div class="select-item">
                        <select name="zone_id" class="form-control js-select2-custom"
                                onchange="set_filter('{{url()->full()}}',this.value,'zone_id')">
                            <option value="" {{!request('zone_id')?'selected':''}}>{{ translate('messages.All_Zones') }}</option>
                            @foreach(\App\Models\Zone::orderBy('name')->get() as $z)
                                <option
                                    value="{{$z['id']}}" {{isset($zone) && $zone->id == $z['id']?'selected':''}}>
                                    {{$z['name']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif
                
            </div>
        </div>
        <!-- End Page Header -->

         <!-- rent Card Wrapper -->
         <div class="row g-3 mb-3">
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-1">
                    
                    <h4 class="title">{{$posts->count() ?? '0'}}</h4>
                    <span class="subtitle">Total Posts</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/total-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-2">
                   
                    <h4 class="title">{{$activePosts ?? '0'}}</h4>
                    <span class="subtitle">Active Posts</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/active-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-3">
                   
                    <h4 class="title">{{$inActivePosts ?? '0'}}</h4>
                    <span class="subtitle">Inactive Posts</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/close-store.png')}}" alt="store">
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="resturant-card card--bg-4">
                    <h4 class="title">{{$postsThisWeek ?? '0'}}</h4>
                    <span class="subtitle">New Posts</span>
                    <img class="resturant-icon" src="{{asset('/public/assets/admin/img/add-store.png')}}" alt="store">
                </div>
            </div>
        </div>
        <!-- rent Card Wrapper -->


         <!-- Transaction Information -->
         <ul class="transaction--information text-uppercase">
            <li class="text--info">
                <i class="tio-document-text-outlined"></i>
                <div>
                    @php($total_transaction = \App\Models\OrderTransaction::where('module_id', Config::get('module.current_module_id'))->count())
                    @php($total_transaction = isset($total_transaction) ? $total_transaction : 0)
                    <span>{{translate('messages.total_transactions')}}</span> <strong>{{$total_transaction}}</strong>
                </div>
            </li>
            <li class="seperator"></li>
            <li class="text--success">
                <i class="tio-checkmark-circle-outlined success--icon"></i>
                <div>
                    @php($comission_earned = \App\Models\AdminWallet::sum('total_commission_earning'))
                    @php($comission_earned = isset($comission_earned) ? $comission_earned : 0)
                    <span>{{translate('messages.commission_earned')}}</span> <strong>{{\App\CentralLogics\Helpers::format_currency($comission_earned)}}</strong>
                </div>
            </li>
            <li class="seperator"></li>
            <li class="text--danger">
                <i class="tio-atm"></i>
                <div>
                    @php($store_withdraws = \App\Models\WithdrawRequest::where(['approved'=>1])->sum('amount'))
                    @php($store_withdraws = isset($store_withdraws) ? $store_withdraws : 0)
                    <span>{{translate('messages.total_withdraws')}}</span> <strong>{{\App\CentralLogics\Helpers::format_currency($store_withdraws)}}</strong>
                </div>
            </li>
        </ul>
        <!-- Transaction Information -->

          <!-- Card -->
          <div class="card">
            <!-- Header -->
            <div class="card-header py-2">
                <div class="search--button-wrapper">
                    <h5 class="card-title">{{translate('messages.Post_list')}}</h5>
                    <form  class="search-form">
                                    <!-- Search -->
                        <div class="input-group input--group">
                            <input id="datatableSearch_" type="search" value="{{ request()?->search ?? null }}" name="search" class="form-control"
                                    placeholder="{{translate('ex_:_Search_Post_Name')}}" aria-label="{{translate('messages.search')}}" >
                            <button type="submit" class="btn btn--secondary"><i class="tio-search"></i></button>

                        </div>
                        <!-- End Search -->
                    </form>
                    <!-- Unfold -->
                    <div class="hs-unfold mr-2">
                        <a class="js-hs-unfold-invoker btn btn-sm btn-white dropdown-toggle min-height-40" href="javascript:;"
                            data-hs-unfold-options='{
                                    "target": "#usersExportDropdown",
                                    "type": "css-animation"
                                }'>
                            <i class="tio-download-to mr-1"></i> {{ translate('messages.export') }}
                        </a>

                        <div id="usersExportDropdown"
                            class="hs-unfold-content dropdown-unfold dropdown-menu dropdown-menu-sm-right">

                            <span class="dropdown-header">{{ translate('messages.download_options') }}</span>
                            <a id="export-excel" class="dropdown-item" href="{{route('admin.store.export', ['type'=>'excel',request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/excel.svg"
                                    alt="Image Description">
                                {{ translate('messages.excel') }}
                            </a>
                            <a id="export-csv" class="dropdown-item" href="{{route('admin.store.export', ['type'=>'csv',request()->getQueryString()])}}">
                                <img class="avatar avatar-xss avatar-4by3 mr-2"
                                    src="{{ asset('public/assets/admin') }}/svg/components/placeholder-csv-format.svg"
                                    alt="Image Description">
                                .{{ translate('messages.csv') }}
                            </a>

                        </div>
                    </div>
                    <!-- End Unfold -->
                </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <div class="table-responsive datatable-custom">
                <table id="columnSearchDatatable"
                        class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table"
                        data-hs-datatables-options='{
                            "order": [],
                            "orderCellsTop": true,
                            "paging":false

                        }'>
                    <thead class="thead-light">
                    <tr>
                        <th class="border-0">{{translate('S.No')}}</th>
                        <th class="border-0">{{translate('messages.Post_Title')}}</th>
                        <th class="border-0">{{translate('messages.module')}}</th>
                        <th class="border-0">{{translate('messages.address')}}</th>
                        <th class="border-0">{{translate('messages.type')}}</th>
                        <th class="border-0">{{translate('Index')}}</th>
                        <th class="text-uppercase border-0">{{translate('messages.status')}}</th>
                        <th class="text-uppercase border-0">{{translate('messages.active')}}</th>
                        <th class="text-center border-0">{{translate('messages.action')}}</th>
                    </tr>
                    </thead>
                    <tbody id="">
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$post->title ?? ''}}</td>
                                <td>Posts</td>
                                <td> {{Str::limit($post->address,20,'...')}}</td>
                                <td>Rent & Sales</td>
                                <td>{{$post->index ?? '-'}}</td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="featuredCheckbox{{$post->id}}">
                                        <input type="checkbox" onclick="location.href='{{route('admin.posts.status',[$post->id,$post->status?0:1])}}'" class="toggle-switch-input" id="featuredCheckbox{{$post->id}}" {{$post->status?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
    
                                </td>
                                <td>
                                    <label class="toggle-switch toggle-switch-sm" for="activeCheckbox{{$post->id}}">
                                        <input type="checkbox" onclick="location.href='{{route('admin.posts.active',[$post->id,$post->is_active?0:1])}}'" class="toggle-switch-input" id="activeCheckbox{{$post->id}}" {{$post->is_active?'checked':''}}>
                                        <span class="toggle-switch-label">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </label>
    
                                </td>
                                <td>
                                <div class="btn--container justify-content-center">
                                        <a class="btn action-btn btn--warning btn-outline-warning"
                                                href=""
                                                title="{{ translate('messages.view') }}"><i
                                                    class="tio-visible-outlined"></i>
                                            </a>
                                        <a class="btn action-btn btn--primary btn-outline-primary"
                                        href=""><i class="tio-edit"></i>
                                        </a>
                                        <a class="btn action-btn btn--danger btn-outline-danger" href="javascript:"
                                        title="{{translate('messages.delete_Post')}}"><i class="tio-delete-outlined"></i>
                                        </a>
                                        <form action="" method="post" id="">
                                            @csrf @method('delete')
                                        </form>
                                    </div>
                                </td>
                            
                            </tr>
                        @endforeach
                    </tbody>

                   
                </table>
               
                <hr>
               
              

            </div>
            <!-- End Table -->
        </div>
        <!-- End Card -->

        



    </div>

@endsection

@push('script_2')
    <script>
        function status_change_alert(url, message, e) {
            e.preventDefault();
            Swal.fire({
                title: '{{ translate('Are you sure?') }}' ,
                text: message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#FC6A57',
                cancelButtonText: '{{translate('messages.no')}}',
                confirmButtonText: '{{translate('messages.yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    location.href=url;
                }
            })
        }
        $(document).on('ready', function () {
            // INITIALIZATION OF DATATABLES
            // =======================================================
            var datatable = $.HSCore.components.HSDatatables.init($('#columnSearchDatatable'));

            $('#column1_search').on('keyup', function () {
                datatable
                    .columns(1)
                    .search(this.value)
                    .draw();
            });

            $('#column2_search').on('keyup', function () {
                datatable
                    .columns(2)
                    .search(this.value)
                    .draw();
            });

            $('#column3_search').on('keyup', function () {
                datatable
                    .columns(3)
                    .search(this.value)
                    .draw();
            });

            $('#column4_search').on('keyup', function () {
                datatable
                    .columns(4)
                    .search(this.value)
                    .draw();
            });


            // INITIALIZATION OF SELECT2
            // =======================================================
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>

@endpush
