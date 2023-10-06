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
                                <input class="effect form-control" type="text" name="store_name" placeholder="">
                                <label>Store Name</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" name="description" type="text" placeholder="">
                                <label>Store Description</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <select class="effect form-control" id="citySelect" type="text" placeholder="" name="city">
                                    <option value="">select city</option>
                                    @foreach ($cities as $city)
                                    <option value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach

                                </select>

                                <label>City</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <select class="effect form-control" type="text" placeholder="" id="areaSelect" name="area">
                                    <option value="">select area</option>
                                    @foreach ($areas as $area)
                                    <option value="{{$area->id}}">{{$area->name}}</option>
                                    @endforeach
                                </select>
                                <label>Area</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <select class="effect form-control" type="text" placeholder="" name="category">
                                    <option value="">select category</option>
                                    @foreach ($categories as $cat)
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                                <label>Category</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <select class="effect form-control" type="text" placeholder="" name="sub_category">
                                </select>
                                <label>Sub-Category</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="text" placeholder="" name="google_map_link">
                                <label>Google Map Link</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="text" placeholder="" name="owner_name">
                                <label>Owner Name</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="text" placeholder="" name="mobile">
                                <label>Mobile No.</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="text" placeholder="" name="email">
                                <label>Email</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>
                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="password" placeholder="" name="password">
                                <label>Password</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <input class="effect form-control" type="text" placeholder="" name="offer_percentage">
                                <label>Offer(%)</label>
                                <span class="focus-bg"></span>
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Offer Image</label>
                                <input class="effect form-control" type="file" placeholder="" name="offer_image">
                            </div>
                        </div>


                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Logo</label>
                                <input class="effect form-control" type="file" placeholder=""  name="store_logo">
                            </div>
                        </div>

                        <div class="col-auto input-effect ">
                            <div class="form-group">
                                <label>Store Banner</label>
                                <input class="effect form-control" type="file" placeholder="" name="store_banner">
                            </div>
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
