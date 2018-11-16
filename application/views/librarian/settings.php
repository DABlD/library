<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Librarian
        <small>Settings</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Settings</li>
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
              <h3 class="box-title">Manage Settings</h3>
            </div>

            <div class="col-md-12 table-col">
              <table id="settingsTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>Name</td>
                    <td>Value</td>
                    <td>Last Updated</td>
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
    var table = $("#settingsTable").dataTable({
      "bProcessing": true,
      "sAjaxSource": "getAll/settings",
      "sPaginationType": "full_numbers",
      "columns": [
        { "data": "display"},
        { "data": "value"},
        { "data": "updated_at"},
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
        "targets": 2,
        "render": function ( data, type, row, meta ) {
          return moment(data).format('MMM DD, YYYY hh:mm A');
        }
      } ],
      initComplete: () => {
        $('.btn-danger').css('display', 'none');
      }
      // "order": [
      //   [0, "desc"]
      // ]
    });

  });

  function editRow(id)
  {
    $.ajax({
      url: 'getRow/settings',
      data: {id: id},
      success: result => {
        result = JSON.parse(result);

        swal({
          title: 'EDIT SETTING',
          html: `
            <form action="validateSettingDetails" method="POST" id="settingsForm">
            
            <input type="hidden" name="id" value="` + result.id + `" />

            <div class="row">
              <div class="col-md-4">
                <b><label>` + result.display + `</label></b>
              </div>
              <div class="col-md-8">
                <input type="text" name="value" value="` + result.value + `" class="form-control" /></br>
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
            $('#settingsForm').submit();
          }
        })
      }
    })
  }

  $('.table-col').css('float', 'none');
</script>