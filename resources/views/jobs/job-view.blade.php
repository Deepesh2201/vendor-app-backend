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
        <link rel="stylesheet" href="{{url('public/css/post.css')}}">



    </head>
    <body>

        <div class="back">
            <a href="storelist.html"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
        </div>

        <div class="container">
            <div class="logosec" >
                <div>
                    <img src="images/restraurantData/MorrisonLogo.jpg" width="70px" height="70px">
                </div>
                <div class="share">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    <i class="fa fa-share-alt" aria-hidden="true"></i>
                </div>
            </div>

            <div class="jobDescrip">
                <h4><span>{{$vacancy->company_name ?? ''}}-</span> <span>{{$vacancy->job_title ?? ''}}</span></h4>

                <p><b>Job Details</b></p>
                <p><i class="fa fa-graduation-cap" aria-hidden="true"></i>{{$vacancy->min_education ?? ''}}</p>
                <p><i class="fa fa-briefcase" aria-hidden="true"></i><span>{{$vacancy->experience ?? ''}}</span> Years</p>
                <p><i class="fa fa-users" aria-hidden="true"></i> <span>1</span> Opening</p>
                <p><i class="fa fa-map-marker" aria-hidden="true"></i> <span>{{$vacancy->location ?? ''}}</span></p>
                <p><i class="fa fa-money" aria-hidden="true"></i> &#163;({{$vacancy->salary_min ?? ''}} - {{$vacancy->salary_max ?? ''}})</p>
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> <span>@if($vacancy->job_type ==
                1 )Full Time @else Part Time @endif</span>

                @if($vacancy->shift)
                    <span>
                        @foreach(explode(',', $vacancy->shift) as $shiftTypeId)
                            @if ($shiftTypeId == 1)
                                (Day Shift)
                            @elseif ($shiftTypeId == 2)
                                (Night Shift)
                            @elseif ($shiftTypeId == 3)
                                (Rotational Shift)
                            @endif
                        @endforeach
                    </span>
                @endif

            </p>

                <p><i class="fa fa-user" aria-hidden="true"></i> {{$vacancy->contact_person_name ?? ''}}</p>
                <p><i class="fa fa-mobile" aria-hidden="true"></i>{{$vacancy->contact_no ?? ''}} </p>
                <p><i class="fa fa-envelope-o" aria-hidden="true"></i>{{$vacancy->contact_email ?? ''}}</p>
                <p><i class="fa fa-globe" aria-hidden="true"></i> <a  target="_blank" href="//{{$vacancy->website ?? ''}}">{{$vacancy->website ?? ''}}</a></p>
                <br>
                <p><b>{{$vacancy->designation ?? ''}}</b></p>
                <p>{{$vacancy->job_description ?? ''}}</p>
            </div>


            <div class="row" style="margin-top: 30px;">
                <div class="col-xs-12 col-12 col-sm-12">
                <button class="btn  subBtn"> Apply Now</button>
                </div>
            </div>


        </div>



    <script src="{{url('public/js/jquery.min.js')}}"></script>
    <script src="{{url('public/js/popper.js')}}"></script>
    <script src="{{url('public/js/bootstrap.min.js')}}"></script>
    <script src="{{url('public/js/main.js')}}"></script>
</body>
</html>
