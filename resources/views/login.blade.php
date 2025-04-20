<!DOCTYPE html>
<html>
<head>
	<title>Admin login</title>
	 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

<!-- Admin css link-->
<link rel="stylesheet" type="text/css" href="style/admin.css">

</head>
<body>

	<div class="container">
		
		 <form action="{{ route('login.submit') }}" method="post" enctype="multipart/form-data">
                        @csrf
		 	<h2>Admin Login</h2>
  			<div class="form-group">
   				<label for="email">Username:</label>
    			<input type="Username" name="email" class="form-control" placeholder="Enter email" required>
  			</div>
  			<div class="form-group">
    			<label for="pwd">Password:</label>
    			<input type="password" class="form-control" placeholder="Enter password" name="password" required>
  			</div>

  			<input type="submit" name="login" class="btn btn-primary" value="login">
		</form> 

	</div>
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ $errors->first() }}',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif
</body>
</html>