<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Librarian
        <small>Add User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="users">User Management</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <section class="col-lg-12 connectedSortable">

          <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $this->session->flashdata('success') ?>
          </div>
          <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= $this->session->flashdata('error') ?>
          </div>
          <?php endif; ?>

          <div class="box box-success">

            <div class="box-header">
              <i class="fa fa-table"></i>
              <h3 class="box-title">User Details</h3>
              <a href="users" class="btn btn-success pull-right" data-toggle="tooltip" data-placement="left" title="User List">
                <i class="fa fa-table"></i>
              </a>
            </div>

            <div class="col-md-12 table-col">

              <div class="col-md-2">
                <label for="type">Account Type: </label>
              </div>
              <div class="col-md-10">
                <select id="type" name="Type" class="form-control">
                  <option disabled selected>Select Account Type</option>
                  <option value="Staff">Staff</option>
                  <option value="Teacher">Teacher</option>
                  <option value="Student">Student</option>
                </select>
              </div>
              
              <div class="id-fg" style="display: none;">
                <div class="col-md-2">
                  <label for="">ID: </label>
                </div>
                <div class="col-md-10">
                  <input type="text" id="id" name="ID" class="form-control" placeholder="Enter ID">
                </div>
              </div>

              <div class="col-md-2">
                <label for="">First Name: </label>
              </div>
              <div class="col-md-10">
                <input type="text" id="fname" name="First Name" class="form-control" placeholder="Enter First name">
              </div>

              <div class="col-md-2">
                <label for="">Last Name: </label>
              </div>
              <div class="col-md-10">
                <input type="text" id="lname" name="Last Name" class="form-control" placeholder="Enter Last name">
              </div>

              <div class="col-md-2">
                <label for="">Gender: </label>
              </div>
              <div class="col-md-10">
                <select id="gender" name="Gender" class="form-control">
                  <option disabled selected>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <div class="col-md-2">
                <label for="">Contact: </label>
              </div>
              <div class="col-md-10">
                <input type="text" id="contact" name="Contact" class="form-control" placeholder="Enter Contact Number">
              </div>

              <div class="col-md-2">
                <label for="">Email: </label>
              </div>
              <div class="col-md-10">
                <input type="email" id="email" name="Email" class="form-control" placeholder="Enter Email Address">
              </div>

              <div class="col-md-2">
                <label for="">Password: </label>
              </div>
              <div class="col-md-10">
                <input type="password" id="password" name="Password" class="form-control" placeholder="Enter Password">
              </div>

              <div class="col-md-2">
                <label for="">Confirm Password: </label>
              </div>
              <div class="col-md-10">
                <input type="password" id="confirm_password" name="Confirm Password" class="form-control" placeholder="Confirm Password">
              </div>

              <div class="row">
                <div class="col-xs-10"></div>
                <div class="col-xs-2">
                  <a id="register" class="btn btn-primary btn-block btn-flat">Register</a>
                </div>
              </div>

              <br>
            </div>

          </div>
        </section>
      </div>

    </section>
  </div>

<script src="<?= base_url() ?>assets/js/swal.js"></script>

<script>
  $('.col-md-10').css('margin-bottom', '10px');

  validate = [];
  validate['fname'] = 'name';
  validate['lname'] = 'name';
  validate['email'] = 'email';
  validate['contact'] = 'number';

  $('#type').on('change', a => {
    if(a.currentTarget.value == "Staff"){
      if($('.id-fg').is(':visible')){
        $('.id-fg').slideUp();
      }
    }
    else{
      if($('.id-fg').not(':visible')){
        $('.id-fg').slideDown();
      }
      
      text = ""
      if(a.currentTarget.value == "Teacher"){
        text = "Faculty ID: ";
      }
      else{
        text = "Student ID: ";
      }

      $($('.id-fg div')[0])[0].innerHTML = "<b>" + text + "<b>";
    }
  })

  $('#register').on('click', () => {
    password = $('#password').val();
    confirm_password = $('#confirm_password').val();

    data = {};
    errors = "";

    $('.form-control').each((index, input) => {
      
      if(index == 0){
        return;
      }

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
            else
            {
              $.ajax({
                url: 'checkIfExisting/users',
                method: 'POST',
                data: {
                  column: 'email',
                  value: $(input).val()
                },
                success: result => {
                  if(result == 1){
                    errors += $(input)[0].name + ' is already registered.<br>';
                  }
                }
              })
            }
          }
        }
      }
    });

    if(password != confirm_password){
      errors += "Password does not match.";
    }

    // TO WAIT FOR THE AJAX IN CHECKING OF EMAIL BEFORE SUBMITTING
    swal.showLoading();
    setTimeout(() => {
      submit();
    }, 1000);
  })

  function submit(){
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
        url: '<?= base_url() ?>Register/register',
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
              window.location.href = 'users';
            })
          }
          else
          {
            swal({
              type: 'error',
              title: 'Try Again.',
              text: 'There was a problem registering the account.',
              timer: 800,
              showConfirmButton: false,
            });
          }
        }
      })
    }
  }

  $('.table-col').css('float', 'none');
</script>