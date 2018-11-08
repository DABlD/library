<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Staff
        <small>User Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">User Management</li>
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
              <h3 class="box-title">Users</h3>
              <!-- <a class="btn add-user btn-success pull-right" data-toggle="tooltip" data-placement="left" title="Add User">
                <i class="fa fa-plus"></i>
              </a> -->
            </div>

            <div class="col-md-12 table-col">
              <table id="usersTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>Type</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Gender</td>
                    <td>Contact</td>
                    <td>Email</td>
                    <td>Join Date</td>
                    <td>Actions</td>
                  </tr>
                </thead>
              </table>

              <br>
            </div>

          </div>
        </section>
      </div>

    </section>
  </div>

<script src="<?= base_url() ?>assets/js/datatables.min.js"></script>
<script src="<?= base_url() ?>assets/js/swal.js"></script>

<script>

  $(document).ready(() => {
    var table = $("#usersTable").dataTable({
      "bProcessing": true,
      "sAjaxSource": "getAll/users",
      "sPaginationType": "full_numbers",
      "columns": [
        { "data": "type"},
        { "data": "fname"},
        { "data": "lname"},
        { "data": "gender"},
        { "data": "contact"},
        { "data": "email"},
        { "data": "created_at"},
        { "data": "actions"},
      ],
      "fnServerData": function (sSource, aoData, fnCallback){
        $.ajax({
          url: sSource,
          dataType: "json",
          data: {
            withActions: 1
          },
          success: fnCallback
        });
      },
      "columnDefs": [ {
        "targets": 6,
        "render": function ( data, type, row, meta ) {
          return moment(data).format('MMM DD, YYYY');
        }
      } ],
      // "order": [
      //   [0, "desc"]
      // ]
    });
  });

  function deleteRow(id)
  {
    swal({
      type: 'question',
      title: 'Are you sure you want to delete this user ?',
      showCancelButton: true
    }).then(choice => {
      if(choice.value)
      {
        $.ajax({
          url: 'deleteRow/users',
          data: {id: id},
          success: result => {
            if(result)
            {
              swal({
                type: 'success',
                title: 'Successfully deleted',
                timer: 800,
                showConfirmButton: false,
              }).then(() => {
                $('#usersTable').DataTable().ajax.reload();
              })
            }
            else
            {
              swal({
                type: 'error',
                title: 'Try Again',
                text: 'There was a problem deleting the user',
                timer: 800,
                showConfirmButton: false,
              })
            }
          }
        })
      }
    })
  }

  function editRow(id)
  {
    $.ajax({
      url: 'getRow/users',
      data: {id: id},
      success: result => {
        result = JSON.parse(result);

        swal({
          title: 'EDIT USER',
          html: `
            <form action="validateUserDetails" method="POST" id="userForm">
            
            <input type="hidden" name="id" value="` + result.id + `" />

            <div class="row">
              <div class="col-md-3">
                <b><label>First Name</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="fname" value="` + result.fname + `" class="form-control" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Last Name</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="lname" value="` + result.lname + `" class="form-control" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Gender</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="gender" value="` + result.gender + `" class="form-control" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Contact</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="contact" value="` + result.contact + `" class="form-control" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Email</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="email" value="` + result.email + `" class="form-control" /></br>
              </div>
            </div>
            </form>
          `,
          width: "500px",
          showCancelButton: true,
          confirmButtonText: "Update",
          onOpen: () => {
            $('#swal2-content label').css({
              'font-size': '1.5em',
              'line-height': '30px',
              'text-align': 'left'
            })
          },
        }).then(choice => {
          if(choice.value)
          {
            $('#userForm').submit();
          }
        })
      }
    })
  }

  $('.table-col').css('float', 'none');
</script>