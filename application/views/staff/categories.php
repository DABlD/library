<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Staff
        <small>Category Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Category Management</li>
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
              <h3 class="box-title">Categories</h3>
              <a class="btn add-category btn-success pull-right" data-toggle="tooltip" data-placement="left" title="Add Category">
                <i class="fa fa-plus"></i>
              </a>
            </div>

            <div class="col-md-12 table-col">
              <table id="categoryTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Added On</td>
                    <td>Updated On</td>
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
    var table = $("#categoryTable").dataTable({
      "bProcessing": true,
      "sAjaxSource": "getAll/categories",
      "sPaginationType": "full_numbers",
      "columns": [
        { "data": "id"},
        { "data": "name"},
        { "data": "created_at"},
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
        "targets": [2,3],
        "render": function ( data, type, row, meta ) {
          return moment(data).format('MMM DD, YYYY hh:mm A');
        }
      } ],
      // "order": [
      //   [0, "desc"]
      // ]
    });

    //ADD CATEGORY
    $('.add-category').on('click', () => {
      swal({
        title: 'ADD CATEGORY',
        html: `
          <div class="row">
            <div class="col-md-3">
              <b><label>Name</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" id="name" class="form-control" /></br>
            </div>
          </div>
        `,
        width: "500px",
        showCancelButton: true,
        confirmButtonText: "Add",
        onOpen: () => {
          $('#swal2-content label').css({
            'font-size': '1.5em',
            'line-height': '30px',
            'text-align': 'left'
          })
        },
        preConfirm: () => {
          return new Promise((resolve) => {
              swal.showLoading();
              setTimeout(() => {

              data = {};

              $('#swal2-content input').each((a,input) => {
                
                data[$(input)[0].id] = $(input).val();

                if($(input).val() == "")
                {
                  swal.showValidationError($(input)[0].id + ' is required');
                  return false;
                }
              })

              resolve()}, 500);
          })
        },
      }).then(choice => {
        if(choice.value)
        {
          $.ajax({
            url: 'addRow/categories',
            method: 'POST',
            data: data,
            success: result => {
              if(result == 1)
              {
                swal({
                  type: 'success',
                  title: 'Category has been added successfully',
                  timer: 800,
                  showConfirmButton: false,
                }).then(() => {
                  $('#categoryTable').DataTable().ajax.reload();
                })
              }
              else
              {
                swal({
                  type: 'error',
                  title: 'Try Again',
                  title: 'There was a problem adding the category.',
                  timer: 800,
                  showConfirmButton: false,
                })
              }
            }
          })
        }
      })
    });
  });

  function deleteRow(id)
  {
    swal({
      type: 'question',
      title: 'Are you sure you want to delete this category ?',
      showCancelButton: true
    }).then(choice => {
      if(choice.value)
      {
        $.ajax({
          url: 'deleteRow/categories',
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
                $('#categoryTable').DataTable().ajax.reload();
              })
            }
            else
            {
              swal({
                type: 'error',
                title: 'Try Again',
                text: 'There was a problem deleting the category',
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
      url: 'getRow/categories',
      data: {id: id},
      success: result => {
        result = JSON.parse(result);

        swal({
          title: 'EDIT CATEGORY',
          html: `
            <form action="validateCategoryDetails" method="POST" id="categoryForm">
            
            <input type="hidden" name="id" value="` + result.id + `" />

            <div class="row">
              <div class="col-md-3">
                <b><label>Name</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" name="name" value="` + result.name + `" class="form-control" /></br>
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
            $('#categoryForm').submit();
          }
        })
      }
    })
  }

  $('.table-col').css('float', 'none');
</script>