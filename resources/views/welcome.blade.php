<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
  <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link
    href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Lora:ital,wght@1,600&family=Raleway:wght@600&family=Roboto+Mono&family=Roboto+Slab&display=swap"
    rel="stylesheet">
</head>

<body class="antialiased bg-light">
    <nav class="navbar navbar-light bg-light">
        <div class="container">
          <a class="navbar-brand">
            <img src="{{asset('assets/img/logo_biologyLearner.png')}}" alt="" width="130" height="40">
          </a>
        </div>
    </nav>

<section class="min-vh-100 d-flex align-items-center justify-content-center">
  <div class="card shadow w-100 mx-5">
    <div class="container">
      <!-- Row -->
      <div class="row">
        <!-- Left Column -->
        <div class="col-md-6 d-flex align-items-center">
          <img src="{{ asset('assets/img/welcome.jpg') }}" class="img-fluid" alt="Welcome Image" style="width: 100%;">
        </div>
        <!-- Right Column -->
        <div class="col-md-6 text-center">
          <div class="p-3 mt-5">
            <img src="{{ asset('assets/img/biology.png') }}" class="img-fluid" alt="Biology Logo" style="width: 6rem;">
          </div>
          <div>
            <h1><strong>W</strong>elcome to</h1>
            <h1 class="text-success"><strong>Biology learner.</strong></h1>
          </div>
          @if (Route::has('login'))
            <div class="mt-5">
              @auth
                <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary mx-3">
                  <strong>Dashboard</strong>
                </a>
              @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary mx-3">
                  <strong>Login</strong>
                </a>
              @endauth
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
</body>

</html>
