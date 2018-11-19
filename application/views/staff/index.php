<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Staff
        <small>All Borrowed Books</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Borrowed Books</li>
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
              <h3 class="box-title">Borrowed Books</h3>
              <!-- <a class="btn add-user btn-success pull-right" data-toggle="tooltip" data-placement="left" title="Add User">
                <i class="fa fa-plus"></i>
              </a> -->
            </div>

            <div class="col-md-12 table-col">
              <table id="usersTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>ID</td>
                    <td style="max-width: 80px;">Borrower</td>
                    <td style="max-width: 130px;">Title</td>
                    <td>Borrow Date</td>
                    <td>Return Date</td>
                    <td>Fee</td>
                    <td>Status</td>
                    <td>Action</td>
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
      "sAjaxSource": "<?= $this->session->logged_in_user->type ?>/getAllWithJoin/borrows/books",
      "sPaginationType": "full_numbers",
      "columns": [
        { "data": "id"},
        { "data": "user_id"},
        { "data": "book_id"},
        { "data": "created_at"},
        { "data": "required_return_date"},
        { "data": "fee"},
        { "data": "status"},
        // { "data": "actions"},
      ],
      "fnServerData": function (sSource, aoData, fnCallback){
        $.ajax({
          url: sSource,
          dataType: "json",
          data: {
            withActions: 0,
            ref: 'book_id',
            type: ''
          },
          success: fnCallback
        });
      },
      "columnDefs": [ 
        {
          "targets": [3,4],
          "render": function ( data, type, row, meta ) {
            return moment(data).format('MMM DD, YYYY');
          }
        },
        {
          "targets": 1,
          "createdCell": (td,id) => {
            $.ajax({
              url: "<?= $this->session->logged_in_user->type ?>/getRow/users",
              data: {id: id},
              success: result => {
                result = JSON.parse(result);
                name = result.fname + ' ' + result.lname;
                $(td)[0].innerText = name;
              }
            })
          }
        },
        {
          "targets": 6,
          "render": function ( data, type, row, meta ) {
            bookStatus = data;
            return data;
          }
        },
        {
          "targets": 7,
          "createdCell": (td,id) => {
            show = ' onclick="handOver(' + $(td).parent().find('td:first')[0].innerText + ')" ';

            if(bookStatus == "Borrowed"){
              show = " disabled";
            }

            $(td)[0].innerHTML = '<a' + show + ' class="btn btn-xs btn-success handOver">Hand Over</i></a>';
          },
          "defaultContent": ''
        },
        {
          "targets": 2,
          "createdCell": (td,id) => {
            $.ajax({
              url: "<?= $this->session->logged_in_user->type ?>/getRow/books",
              data: {id: id},
              success: result => {
                result = JSON.parse(result);
                $(td)[0].innerText = result.title;
              }
            })
          }
        }
      ],
      drawCallback: () => {
        $('#usersTable tbody').append('<div class="preloader"></div>');
        setTimeout(() => {
          $('.preloader').fadeOut();
        }, 500);
      },
      // "order": [
      //   [0, "desc"]
      // ]
    });
  });

  function handOver(id){
    $.ajax({
      url: "<?= $this->session->logged_in_user->type ?>/getRow/borrows",
      data: {id: id},
      success: result => {
        result = JSON.parse(result);
        id = result.book_id;

        $.ajax({
          url: '<?= $this->session->logged_in_user->type ?>/updateRow/books',
          data: {id: id, status: 'Borrowed'},
          method: 'POST',
          success: result => {
            if(result)
            {
              swal({
                type: 'success',
                title: 'Successfully Updated Book Status.',
                timer: 800,
                showConfirmButton: false
              }).then(() => {
                $('#usersTable').DataTable().ajax.reload(() => {
                  setTimeout(() => {
                    $('.preloader').fadeOut();
                  }, 500);
                });
              })
            }
          }
        })
      }
    })
  }

  $('.table-col').css('float', 'none');
</script>