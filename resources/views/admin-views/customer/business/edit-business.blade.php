<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Post</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="{{url('css/post.css')}}">
        {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    </head>
    <body>
        <section class="AB">
            <div class="back">
                <a href=""><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            </div>
            <div class="container">

                <form class="postsForm" action="{{url('/api/v1/business/save')}}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="store_id" value="{{$store->id ?? ''}}">
                    @if(session('errors'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach (session('errors') as $error)
                                    <li>{{ ($error[0] ) }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-row">
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Name</label>
                                <input class="effect form-control" type="text" name="store_name" placeholder="" value="{{$store->name ?? ''}}">

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Description</label>
                                <input class="effect form-control" name="description" type="text" placeholder="" value="{{$store->meta_description}}">

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>City</label>
                                <select class="effect form-control" id="citySelect" type="text" placeholder="" name="city">
                                    <option value="">select city</option>
                                    @foreach ($cities as $city)
                                    <option value="{{$city->id}}" @if ($city->id == $store->city_id)  selected @endif>{{$city->name}}</option>
                                    @endforeach

                                </select>


                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Area</label>
                                <select class="effect form-control" type="text" placeholder="" id="areaSelect" name="area">
                                    <option value="">select area</option>
                                    @foreach ($areas as $area)
                                    <option value="{{$area->id}}" @if ($area->id == $store->area_id)  selected @endif>{{$area->name}}</option>
                                    @endforeach
                                </select>

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Category</label>
                                <select class="effect form-control" type="text" placeholder="" name="category">
                                    <option value="">select category</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}" @if ($cat->id == $store->store_category)  selected @endif>{{$cat->name}}</option>
                                    @endforeach
                                </select>

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                             <label>Sub-Category</label>
                                <select class="effect form-control" type="text" placeholder="" name="sub_category">
                                </select>
                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Google Map Link</label>
                                <input class="effect form-control" type="text" placeholder="" name="google_map_link" value="{{$store->map_location_link ?? ''}}">
                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Owner Name</label>
                                <input class="effect form-control" type="text" placeholder="" name="owner_name" value="{{$store->owner_name ?? ''}}">

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input class="effect form-control" type="text" placeholder="" name="mobile" value="{{$store->phone ?? ''}}">
                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Email</label>
                                <input class="effect form-control" type="text" placeholder="" name="email" value="{{$store->email ?? ''}}">
                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="effect form-control" type="password" placeholder="" name="password">

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Offer(%)</label>
                                <input class="effect form-control" type="text" placeholder="" name="offer_percentage" value="{{$store->offer_percentage ?? ''}}">

                                {{-- <span class="focus-bg"></span> --}}
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Offer Image</label>
                                <input class="effect form-control" type="file" placeholder="" name="offer_image">
                            </div>
                            @if (file_exists(public_path('images/business-images/'.$store->offer_image)))
                                <div class="icard">
                                    <img width="50%"  src="{{ asset(url('images/business-images/'.$store->offer_image)) }}" class="card-img-top" alt="">
                                </div>
                            @endif
                        </div>

                        <style>
                            .icard{
                               display: flex;
                               justify-content: center;
                               /* margin: 0 auto; */
                            }
                        </style>


                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Logo</label>
                                <input class="effect form-control" type="file" placeholder=""  name="store_logo">
                            </div>
                            @if (file_exists(public_path('images/business-images/'.$store->logo)))
                                <div class="icard">
                                    <img width="50%"  src="{{ asset(url('images/business-images/'.$store->logo)) }}" class="card-img-top" alt="">
                                </div>
                            @endif
                        </div>


                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Banner</label>
                                <input class="effect form-control" type="file" placeholder="" name="store_banner">
                            </div>
                            @if (file_exists(public_path('images/business-images/'.$store->cover_photo)))
                                <div class="icard">
                                    <img width="50%"  src="{{ asset(url('images/business-images/'.$store->cover_photo)) }}" class="card-img-top" alt="">
                                </div>
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-12 col-sm-12">
                        <button class="btn  subBtn" type="submit"> Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>


        // JavaScript for label effects only
        window.addEventListener("load", function(){
		$(".col-3 input").val("");

		$(".input-effect input").focusout(function(){
			if($(this).val() != ""){
				$(this).addClass("has-content");
			}else{
				$(this).removeClass("has-content");
			}
		})
	});

    function showdate(){

        document.getElementsByClassName("typeDate").hidden=false;
    }
    </script>
    <script src="{{url('js/jquery.min.js')}}"></script>
    <script src="{{url('js/popper.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="{{url('js/main.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function () {
            // Add an event listener for the city select field
            $("#citySelect").change(function () {
                var cityId = $(this).val(); // Get the selected city ID

                if (cityId !== "") {
                    // Make an Ajax request to fetch areas based on the selected city
                    $.ajax({
                        url: "{{ url('/api/v1/areas') }}/" + cityId, // Replace with your actual API endpoint
                        type: "GET",
                        dataType: "json",
                        success: function (response) {
                            // Clear existing options in the area select field
                            $("#areaSelect").empty();
                            $.each(response, function (key, value) {
                                $("#areaSelect").append(
                                    '<option value="' + value.id + '">' + value.name + "</option>"
                                );
                            });
                        },
                        error: function () {
                            console.log("Error fetching areas.");
                        },
                    });
                } else {
                    // If no city is selected, clear the area select field
                    $("#areaSelect").empty();
                    $("#areaSelect").append('<option value="">select area</option>');
                }
            });
        });
    </script>

    <script>
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif
    </script>

</body>
</html>
