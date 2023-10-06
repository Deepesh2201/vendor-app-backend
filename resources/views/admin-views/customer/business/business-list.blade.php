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
    </head>
    <body>
        <section class="">
            <div class="back">
                <a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
            </div>
            <div class="container">
                <div class="businessListPage">

                    @foreach ($businessList as $item)
                        <a href="{{url('api/v1/business/edit/'.$item->id)}}" class="listBox">

                            <img src="{{ file_exists(public_path('images/business-images/'.$item->logo)) ? asset(url('images/business-images/'.$item->logo)) : url('images/business.png') }}" alt="Image">


                            {{-- <img src="images/business.png"> --}}
                            <div class="listDesc">
                                <h4>{{$item->name}}</h4>
                                <p class="date">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</p>
                                <p class="desc">{{ Str::limit($item->meta_description, $limit = 100, $end = '...') }} </p>
                                @if($item->active == 1)
                                   <p class="text-success status"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;Active</p>
                                @else
                                  <p class="text-danger status"><i class="fa fa-circle" aria-hidden="true"></i>&nbsp;In Active</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="create">
                    <a href="{{url('api/v1/business/create')}}" class="fa-pluss"  >+</a>
                </div>
                <div class="d-flex justify-content-center text-center" id="paginationContainer">
                    {!! $businessList->links('vendor.pagination.bootstrap-4') !!}
                </div>



                <!-- <div class="btnsCreatePost"  id="btnsCreatePost" hidden>
                    <div class="btn1">
                        <a href="createjobpost.html" class="btn btn-sm btn-info">Jobs / Vacancies</a>
                    </div>

                    <div class="btn2">
                        <a href="createpost.html" class="btn btn-sm btn-primary">Rent / Sells</a>
                    </div>
                </div> -->


            </div>

        </div>
    </section>


    <script>
        function showOptions(){
            // document.getElementById("btnsCreatePost").hidden=false;

            var x = document.getElementById("btnsCreatePost");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }

        }
    </script>
    <script src="{{url('js/jquery.min.js')}}"></script>
    <script src="{{url('js/popper.js')}}"></script>
    <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="{{url('js/main.js')}}"></script>
</body>
</html>
