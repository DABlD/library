<!DOCTYPE html>
<html style="overflow-y: hidden;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register | Library System</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/ionicons.min.css">
  <link rel="stylesheet" href="assets/css/AdminLTE.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>

<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="Login"><b>Register</b></a>
  </div>
  <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    <br>
    
    <div class="form-group has-feedback">
      <select id="type" name="Type" class="form-control">
        <option disabled selected>Select Account Type</option>
        <option value="User">User</option>
        <option value="Librarian">Librarian</option>
      </select>
    </div>
    <div class="form-group has-feedback">
      <input type="text" id="fname" name="First Name" class="form-control" placeholder="Enter First name">
    </div>
    <div class="form-group has-feedback">
      <input type="text" id="lname" name="Last Name" class="form-control" placeholder="Enter Last name">
    </div>
    <div class="form-group has-feedback">
      <select id="gender" name="Gender" class="form-control">
        <option disabled selected>Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>
    </div>
    <div class="form-group has-feedback">
      <input type="text" id="contact" name="Contact" class="form-control" placeholder="Enter Contact Number">
    </div>
    <div class="form-group has-feedback">
      <input type="email" id="email" name="Email" class="form-control" placeholder="Enter Email Address">
    </div>
    <div class="form-group has-feedback">
      <input type="password" id="password" name="Password" class="form-control" placeholder="Enter Password">
    </div>
    <div class="form-group has-feedback">
      <input type="password" id="confirm_password" name="Confirm Password" class="form-control" placeholder="Confirm Password">
    </div>
    <div class="row">
      <div class="col-xs-8"></div>
      <div class="col-xs-4">
        <a id="register" class="btn btn-primary btn-block btn-flat">Register</a>
      </div>
    </div>

    <a href="Login" class="text-center">Login</a><br>

  </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swal.js"></script>

<script>
  $(document).on('keypress', key => {
    key.which == 13 ? $('#register').click() : '';
  });

  $('#register').on('click', () => {

    password = $('#password').val();
    confirm_password = $('#confirm_password').val();

    data = {};

    validate = [];
    validate['fname'] = 'name';
    validate['lname'] = 'name';
    validate['email'] = 'email';
    validate['contact'] = 'number';

    errors = "";

    $('.form-control').each((index, input) => {

      if($(input)[0].id != "confirm_password")
      {
        data[$(input)[0].id] = $(input).val();
      }

      if($(input).val() == "" || $(input).val() == null)
      {
        errors += $(input)[0].name + ' is required.<br>';
      }

      if(validate[$(input)[0].id])
      {
        if($(input).val() != "")
        {
          if(validate[$(input)[0].id] == 'name')
          {
            if(!/^[a-zA-Z .-]*$/.test($(input).val()))
            {
              errors += $(input)[0].name + ' contains invalid characters.<br>';
            }
          }
          else if(validate[$(input)[0].id] == 'number')
          {
            if(!/^[0-9 -+()]*$/.test($(input).val()))
            {
              errors += $(input)[0].name + ' is an invalid number.<br>';
            }
          }
          else
          {
            if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($(input).val()))
            {
              errors += $(input)[0].name + ' is an invalid email.<br>';
            }
          }
        }
      }
    });

    if(password != confirm_password)
    {
      errors += "Password does not match.";
    }

    if(errors != "")
    {
      swal({
        type: 'error',
        onOpen: () => {
          swal.showValidationError(errors);
        }
      })
    }
    else
    {
      $.ajax({
        url: 'Register/register',
        method: 'POST',
        data: data,
        success: result => {
          result = JSON.parse(result);
          
          if(result)
          {
            swal({
              type: 'success',
              title: 'Successfully Registered.',
              timer: 800,
              showConfirmButton: false,
            }).then(() => {
              window.location.href = 'Login';
            })
          }
          else
          {
            swal({
              type: 'error',
              title: 'Try Again.',
              text: 'There was a problem registering your account.',
              timer: 800,
              showConfirmButton: false,
            });
          }
        }
      })
    }

  })
</script>

</body>
</html>
