<!DOCTYPE html>
<html style="overflow-y: hidden;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | Library System</title>

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
    <a href="Login"><b>Login</b></a>
  </div>
  <div class="login-box-body">
    <!-- <p class="login-box-msg">Sign in to start your session</p> -->
    <br>

    <div class="form-group has-feedback">
      <input type="email" id="email" class="form-control" placeholder="Enter Email Address">
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" id="password" class="form-control" placeholder="Enter Password">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-8"></div>
      <div class="col-xs-4">
        <a id="login" class="btn btn-primary btn-block btn-flat">Sign In</a>
      </div>
    </div>

    <a class="text-center" onclick="guestLogin()" style="cursor: pointer;">Sign in as Guest</a><br>
    <!-- <a href="#">I forgot my password</a> -->

  </div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swal.js"></script>

<script>
  <?php if($this->session->flashdata('error')): ?>
    swal({
      type: 'error',
      title: '<?= $this->session->flashdata('error'); ?>',
    });
  <?php endif; ?>

  $(document).on('keypress', key => {
    key.which == 13 ? $('#login').click() : '';
  });

  $('#login').on('click', () => {
    email = $('#email').val();
    password = $('#password').val();

    swal({
      title: 'Signing In',
      timer: 1000,
      onOpen: () => {
        swal.showLoading();
      }
    }).then(() => {
      checkAccount();
    })
  })

  function guestLogin(){
    swal({
      title: 'Signing In',
      timer: 1000,
      onOpen: () => {
        swal.showLoading();
      }
    }).then(() => {
      window.location.href = 'Guest';
    })
  }

  function checkAccount(){
    $.ajax({
      url: 'Login/checkAccount',
      data: {email: email, password: password},
      method: 'POST',
      success: result => {

        if(result[0] == "I")
        {
          swal({
            type: 'error',
            title: result,
            timer: 800,
            showConfirmButton: false,
          });
        }
        else
        {
          result = JSON.parse(result);

          swal({
            type: 'success',
            title: result[0] + ' Account',
            text: result[1],
            timer: 800,
            showConfirmButton: false,
          }).then(() => {
            window.location.href = result[0];
          })
        }
      }
    })
  }
</script>

</body>
</html>
