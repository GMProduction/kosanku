<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bona+Nova:ital,wght@0,400;0,700;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/myStyle.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}" type="text/css">

    <!-- Styles -->
    <script src="{{ asset('js/swal.js') }}"></script>

</head>


<body>
@if(count($errors->messages()) > 0)
    <script>
        swal('{{$errors->messages()[1][0]}}', {
            icon: "warning",
            buttons: false,
            timer: 2000
        })
    </script>
@endif
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="card login-content shadow-lg border-0">
					<div class="card-body">
						<div class="text-center">
							<img class="logo" src="https://cdn3.iconfinder.com/data/icons/galaxy-open-line-gradient-i/200/account-256.png">
						</div>
					<h3 class="text-logo">Login sebagai admin</h3>
					<br>
                        <form class="text-center" method="POST">
                            @csrf
                            <input class="form-control border-0" type="text" name="username" placeholder="Type Your Username">
                            <br>
                            <input class="form-control border-0" type="password" name="password" placeholder="Type Your Password">
                            <br>
                            <button class="btn btn-primary btn-sm border-0" type="submit" >Login</button>
                        </form>
					</div>

				</div>
			</div>
		</div>
	</div>

    <script src="{{ asset('bootstrap/js/jquery.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/myStyle.js') }}"></script>

</body>


</html>
