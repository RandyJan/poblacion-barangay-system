

<!DOCTYPE html>
<html lang="en" style="position: relative;min-height: 100%;">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
      <title>Schedule</title>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
      <link rel="stylesheet" href={{ URL::asset('css/ClientCSS/Footer-Clean.css') }}>
      <link rel="stylesheet" href={{ URL::asset('css/ClientCSS/Header-Blue.css') }}>
      <link rel="stylesheet" href={{ URL::asset('css/ClientCSS/styles.css') }}>
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
   </head>
   <body style="margin: 0 0 100px;">
      <input type="hidden" id = "current_resident" data-id = {{ session("resident.id") }}>

      @include('inc.client_nav')

      <div style="margin: 30px;margin-bottom: 80px;">
         <div class="d-flex justify-content-center">
            @if (session()->has("success_certificate"))
            <div class="alert alert-success">
               {{ session()->get("success_certificate")}}
            </div>
            @endif
         </div>
         <div class="jumbotron" style="margin-bottom: 175px;padding-top: 0px;background-color: white !important;">
            <div class="album py-5 bg-white">
               <div class="text-center">
                  <h1 >Certificate</h1>
                  <br>
               </div>
              <div class="container">
    <div class="row">

        @if(count($request_list))
        @foreach ($request_list as $request)

            @php
                switch(strtolower($request->status)) {
                    case 'approved':
                        $statusClass = 'success';
                        break;
                    case 'completed':
                        $statusClass = 'primary';
                        break;
                    case 'rejected':
                        $statusClass = 'danger';
                        break;
                    default:
                        $statusClass = 'warning'; // pending
                }
            @endphp

            <div class="col-md-4">
                <div class="card mb-4 box-shadow">

                    <!-- HEADER -->
                    <div class="bg-info text-white text-center pt-2 position-relative"
                         style="height: 100px">

                        <span class="badge badge-{{ $statusClass }} position-absolute"
                              style="top:10px; right:10px;">
                            {{ ucfirst($request->status) }}
                        </span>

                        <h4 class="mt-4">{{ $request->request_type }}</h4>
                    </div>

                    <!-- BODY -->
                    <div class="card-body">
                        <div class="card-text border-bottom solid">
                            <div class="row text-center">
                                <div class="col-sm-6">
                                    <h5>Price</h5>
                                    <h5>{{ $request->price }}</h5>
                                </div>
                                <div class="col-sm-6">
                                    <h5>Paid</h5>
                                    <h5>{{ $request->paid }}</h5>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small>{{ \Carbon\Carbon::parse($request->created_at)->toDateString() }}</small>

                            <div class="btn-group">
                                <a href="schedule/{{ $request->request_id }}"
                                   class="btn btn-sm btn-outline-secondary">
                                    View
                                </a>

                                <button
                                    data-id="{{ $request->request_id }}"
                                    type="button"
                                    class="btn btn-sm btn-outline-secondary print-button"
                                    {{ !in_array(strtolower($request->status), ['approved','completed']) ? 'disabled' : '' }}
                                >
                                    Print
                                </button>
                            </div>
                        </div>

                        @if(!in_array(strtolower($request->status), ['approved','completed']))
                            <small class="text-muted d-block mt-2">
                                Printing available after approval
                            </small>
                        @endif
                        @if(strtolower($request->status) === 'rejected' && !empty($request->remarks))
    <div class="alert alert-danger mt-3 mb-0">
        <strong>Reason for Rejection:</strong>
        <p class="mb-0">{{ $request->remarks }}</p>
    </div>
@endif
                    </div>
                </div>
            </div>

        @endforeach
        @endif

    </div>
</div>
            </div>
         </div>
      </div>
      <footer class="footer-clean" style="background-color: gray;position: absolute;left: 0;bottom: 0;height: 174px;width: 100%;overflow: hidden;margin-top: 30px;">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-sm-4 col-md-3 item">
                  <h3>Services</h3>
                  <ul>
                     <li><a href="#">Web design</a></li>
                     <li><a href="#">Development</a></li>
                     <li><a href="#">Hosting</a></li>
                  </ul>
               </div>
               <div class="col-sm-4 col-md-3 item">
                  <h3>About</h3>
                  <ul>
                     <li><a href="#">Company</a></li>
                     <li><a href="#">Team</a></li>
                     <li><a href="#">Legacy</a></li>
                  </ul>
               </div>
               <div class="col-sm-4 col-md-3 item">
                  <h3>Careers</h3>
                  <ul>
                     <li><a href="#">Job openings</a></li>
                     <li><a href="#">Employee success</a></li>
                     <li><a href="#">Benefits</a></li>
                  </ul>
               </div>
               <div class="col-lg-3 item social">
                  <a href="#"><i class="icon ion-social-facebook"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-snapchat"></i></a><a href="#"><i class="icon ion-social-instagram"></i></a>
                  <p class="copyright">Company Name © 2017</p>
               </div>
            </div>
         </div>
      </footer>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
      <script type="text/javascript" src=" {{ URL::asset('js/app.js') }}"></script>
      <!---datatable-->
      <script type="text/javascript" src=" https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
      <!--pagination-->
      <script type="text/javascript" src="{{ URL::asset('js/pagination.js') }}"></script>
      <script type="text/javascript" src="{{ URL::asset('js/pagination.min.js') }}"></script>
   </body>
</html>

