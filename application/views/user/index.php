<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  
<link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css">  
<link rel="stylesheet" href="<?= base_url() ?>assets/css/flatpickr.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?= $type ?>
        <small>Borrows and Reservations</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Borrows and Reservations</li>
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
              <h3 class="box-title">Borrows and Reservations</h3>
            </div>

            <div class="col-md-12 table-col">
              <table id="booksTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>Status</td>
                    <td style="max-width: 130px">Title</td>
                    <td style="max-width: 130px">Category</td>
                    <td>Author</td>
                    <td style="max-width: 130px">Publisher</td>
                    <td>Borrow Date</td>
                    <td>Return Date</td>
                    <td>Fee</td>
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
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/flatpickr.js"></script>
<script src="<?= base_url() ?>assets/js/swal.js"></script>

<script>

  db_tables = [];

  $(document).ready(() => {

    var table = $("#booksTable").dataTable({
      "sAjaxSource": "<?= $this->session->logged_in_user->type ?>/getAllWithJoin/borrows/books",
      "sPaginationType": "full_numbers",
      "processing": true,
      "columns": [
        { "data": "status"},
        { "data": "title"},
        { "data": "categories", "searchable": false},
        { "data": "author_id", "searchable": false},
        { "data": "publisher_id", "searchable": false},
        { "data": "created_at"},
        { "data": "required_return_date"},
        { "data": "fee", "searchable": false},
        { "data": "actions", "searchable": false},
      ],
      "fnServerData": function (sSource, aoData, fnCallback){
        $.ajax({
          url: sSource,
          dataType: "json",
          data: {
            withActions: 0,
            ref: 'book_id',
            //TYPE OF JOIN. LEAVE '' IF YOU WILL NOT USE FAG.
            type: ''
          },
          success: fnCallback
        });
      },
      "createdRow": (row, data, index) => {
        $(row.childNodes[8]).append('&nbsp;' + '<a onclick="viewRow(' + data.book_id + ', ' + data.id + ')" class="btn btn-xs btn-info"><i class="fa fa-search fa-2x" data-toggle="tooltip" title="View"></i></a>');
      },
      columnDefs: [ 
        {
          targets: [2,3,4],
          render: function ( data, type, row, meta ) {
            data = JSON.parse(data);
            string = "";
            data.forEach(name => {
              string += '<span class="badge">' + name + "</span>";
            })

            return string;
          }
        },
        {
          targets: [5,6],
          render: function ( data, type, row, meta ) {
            return moment(data).format('MMM DD, YYYY');
          }
        },
      ],
      drawCallback: () => {
        $('#booksTable tbody').append('<div class="preloader"></div>');
        setTimeout(() => {
          $('.preloader').fadeOut();
        }, 500);
      },
      // "order": [
      //   [0, "desc"]
      // ]
    });
  });
  // id = book_id
  function viewRow(id, rowId)
  {
    swal({
      title: 'BOOK DETAILS',
      html: `
        <div class="row">
          <div class="col-md-3">
            <b><label>Title</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" id="title" disabled class="form-control" placeholder="Enter Title" /></br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <b><label>Description</label></b>
          </div>
          <div class="col-md-9">
            <textarea class="form-control" disabled placeholder="Enter Description" id="description" cols="30" rows="5"></textarea><br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <b><label>Category</label></b>
          </div>
          <div class="col-md-9">
            <div type="text" id="categories" disabled class="form-control" placeholder="Enter Categories" /></br>
          </div>
          </div>
        </div>
    
        <div class="row">
          <br>
          <div class="col-md-3">
            <b><label>ISBN</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" id="isbn" disabled class="form-control" placeholder="Enter ISBN" /></br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <b><label>Edition</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" id="edition" disabled class="form-control" placeholder="Enter Edition" /></br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <b><label>Published On</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" id="date_published" disabled class="form-control" placeholder="Select Publish Date"/></br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3">
            <b><label>Author</label></b>
          </div>
          <div class="col-md-9">
            <div type="text" id="author_id" disabled class="form-control" placeholder="Select Author"/></br>
          </div>
          </div>
        </div>

        <div class="row">
          <br>
          <div class="col-md-3">
            <b><label>Publisher/s</label></b>
          </div>
          <div class="col-md-9">
            <div type="text" id="publisher_id" disabled class="form-control" placeholder="Select Publisher"/></br>
          </div>
          </div>
        </div>

        <div class="row">
          <br>
          <div class="col-md-3">
            <b><label>Accession number</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" min="0" id="accession_number" disabled class="form-control" placeholder="Enter Accession number"/></br>
          </div>
        </div>

        <div class="row">
          <br>
          <div class="col-md-3">
            <b><label>Status</label></b>
          </div>
          <div class="col-md-9">
            <input type="text" min="0" id="status" disabled class="form-control" placeholder="Enter Status"/></br>
          </div>
        </div>
      `,
      width: "600px",
      confirmButtonText: "RETURN",
      showCancelButton: true,
      cancelButtonText: 'BACK',
      onOpen: () => {
        $('#swal2-content label').css({
          'font-size': '1.5em',
          'line-height': '30px',
        });

        values = [
          'title', 
          'description', 
          'categories', 
          'isbn', 
          'edition', 
          'date_published', 
          'author_id', 
          'publisher_id', 
          'accession_number',
          'status'
        ];

        getInputValues('books', id, values);
      }
    }).then(choice => {
      if(choice.value)
      {
        swal({
          type: 'question',
          title: 'Are you sure you want to return this book ?',
          showCancelButton: true,
          cancelButtonText: 'No',
          confirmButtonText: 'Yes',
        }).then(choice2 => {
          if(choice2.value)
          {
            timestamp = moment().format('YYYY-MM-DD hh:mm:ss');
            $.ajax({
              url: '<?= $this->session->logged_in_user->type ?>/updateRow/borrows',
              data: {id: rowId, returned_on: timestamp, deleted_at: timestamp},
              method: 'POST',
              success: result => {
                if(result)
                {
                  swal({
                    type: 'success',
                    title: 'Successfully Returned Book.',
                    timer: 800,
                    showConfirmButton: false
                  }).then(() => {
                    $.ajax({
                      url: '<?= $this->session->logged_in_user->type ?>/updateRow/books',
                      data: {id: id, status: 'Available'},
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
                            $('#booksTable').DataTable().ajax.reload(() => {
                              setTimeout(() => {
                                $('.preloader').fadeOut();
                              }, 500);
                            });
                          })
                        }
                      }
                    })
                  })
                }
              }
            })
          }
        })
      }
    })
  }

  function getInputValues(table, id, values)
  {
    $.ajax({
      url: '<?= $this->session->logged_in_user->type ?>/getRow/' + table,
      data: {id:id},
      success: result => {
        result = JSON.parse(result);

        values.forEach((column, index) => {

          // OPTIONAL
          db_tables[2] = 'categories';
          db_tables[6] = 'authors';
          db_tables[7] = 'publishers';

          if([2, 6, 7].includes(index))
          {
            ids = JSON.parse(result[column]);
            ids = typeof ids == "object" ? ids : [ids];

            string = "";
            ids.forEach((newId, newIndex, array) => {
              $.ajax({
                url: '<?= $this->session->logged_in_user->type ?>/getRow/' + db_tables[index],
                data: {id: newId},
                success: newResult => {
                  newResult = JSON.parse(newResult);
                  string += '<span class="badge">';
                  string += newResult.name ? newResult.name : (newResult.fname + ' ' + newResult.lname);
                  string += '</span>';
                  
                  if(newIndex == (array.length - 1))
                  {
                    $('#' + column)[0].innerHTML = string;
                    $($('#' + column)[0]).css('text-align', 'left');
                    string = "";
                  }
                }
              });
            });
          }//END OF OPTIONAL
          else
          {
            //REQUIRED LINE
            $('#' + column).val(result[column]);

            if(column == "status"){
              if(result[column] != "Borrowed"){
                $('.swal2-confirm').attr('disabled', true);
              }
            }
          }
        })
      }
    });
  }

  $('.table-col').css('float', 'none');
</script>