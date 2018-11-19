<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Librarian
        <small>Transactions</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Transactions</li>
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
              <h3 class="box-title">Transactions</h3>
            </div>

            <div class="col-md-12 table-col">
              <table id="transactionsTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>ID</td>
                    <td>Transaction</td>
                    <td>Datetime</td>
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
    var table = $("#transactionsTable").dataTable({
      "bProcessing": true,
      "sAjaxSource": "getWhere/transactions",
      "sPaginationType": "full_numbers",
      "columns": [
        { "data": "id"},
        { "data": "transaction"},
        { "data": "created_at"},
      ],
      "fnServerData": function (sSource, aoData, fnCallback){
        $.ajax({
          url: sSource,
          dataType: "json",
          method: 'POST',
          data: {
            column: 'user_id',
            value: "<?= $this->session->logged_in_user->id ?>",
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
      // "order": [
      //   [0, "desc"]
      // ]
    });
  });

  $('.table-col').css('float', 'none');
</script>