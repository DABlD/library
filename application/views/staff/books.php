<link rel="stylesheet" href="<?= base_url() ?>assets/css/datatables.min.css">  
<link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css">  
<link rel="stylesheet" href="<?= base_url() ?>assets/css/flatpickr.css">  

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Staff
        <small>Book Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?= base_url() . $this->session->logged_in_user->type ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Book Management</li>
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
              <h3 class="box-title">Books</h3>
              <a class="btn add-book btn-success pull-right" data-toggle="tooltip" data-placement="left" title="Add Book">
                <i class="fa fa-plus"></i>
              </a>
            </div>

            <div class="col-md-12 table-col">
              <table id="booksTable" class="row-border hover">
                <thead>
                  <tr>
                    <td>ID</td>
                    <td style="max-width: 130px">Title</td>
                    <td style="max-width: 130px">Category</td>
                    <td>Author</td>
                    <td style="max-width: 130px">Publisher</td>
                    <td>Date Published</td>
                    <td>Accession<br>Number</td>
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
      "sAjaxSource": "getAllBooks",
      "sPaginationType": "full_numbers",
      "processing": true,
      "columns": [
        { "data": "id"},
        { "data": "title"},
        { "data": "categories", "searchable": false},
        { "data": "author_id", "searchable": false},
        { "data": "publisher_id", "searchable": false},
        { "data": "date_published"},
        { "data": "accession_number", "searchable": false},
        { "data": "actions", "searchable": false},
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
      "createdRow": (row, data, index) => {
        $(row.childNodes[7]).append('&nbsp;' + '<a onclick="viewRow(' + data.id + ')" class="btn btn-xs btn-info"><i class="fa fa-search fa-2x" data-toggle="tooltip" title="View"></i></a>');
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
          targets: 5,
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
      "order": [
        [1, "asc"]
      ]
    });

    //ADD BOOK
    $('.add-book').on('click', () => {
      swal({
        title: 'ADD BOOK',
        html: `
          <div class="row">
            <div class="col-md-3">
              <b><label>Title</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" id="title" class="form-control" placeholder="Enter Title" /></br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Description</label></b>
            </div>
            <div class="col-md-9">
              <textarea class="form-control" placeholder="Enter Description" id="description" cols="30" rows="3"></textarea><br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Category</label></b>
            </div>
            <div class="col-md-9">
              <select id="categories" class="form-control" multiple></select>
            </div>
          </div>
  
          <div class="row">
            <br>
            <div class="col-md-3">
              <b><label>ISBN</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" id="isbn" class="form-control" placeholder="Enter ISBN" /></br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Edition</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" id="edition" class="form-control" placeholder="Enter Edition" /></br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Published On</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" id="date_published" class="form-control" placeholder="Select Publish Date"/></br>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Author</label></b>
            </div>
            <div class="col-md-9">
              <select id="author_id" class="form-control"></select>
            </div>
          </div>

          <div class="row">
            <div class="col-md-3">
              <b><label>Publisher/s</label></b>
            </div>
            <div class="col-md-9">
              <select id="publisher_id" class="form-control" multiple></select>
            </div>
          </div>

          <div class="row">
            <br>
            <div class="col-md-3">
              <b><label>Accession number</label></b>
            </div>
            <div class="col-md-9">
              <input type="text" min="0" id="accession_number" class="form-control" placeholder="Enter Accession number"/></br>
            </div>
          </div>
        `,
        width: "600px",
        showCancelButton: true,
        confirmButtonText: "Add",
        onOpen: () => {
          $('#swal2-content label').css({
            'font-size': '1.5em',
            'line-height': '30px',
          })

          //FLATPICKR
          $('#date_published').flatpickr({
            altInput: true,
            altFormat: "F j, Y",
          });

          //SELECT
          $('#categories').select2({
            placeholder: 'Select Categories',
            ajax: {
              url: 'getForSelect/categories/name',
              processResults: function(result){
                return {
                  results: JSON.parse(result)
                };
              },
            }
          });
          
          $('#author_id').select2({
            placeholder: 'Select Author',
            ajax: {
              url: 'getForSelect/authors/name',
              processResults: function(result){
                return {
                  results: JSON.parse(result)
                };
              },
            }
          });

          $('#publisher_id').select2({
            placeholder: 'Select Publisher/s',
            ajax: {
              url: 'getForSelect/publishers/name',
              processResults: function(result){
                return {
                  results: JSON.parse(result)
                };
              },
            }
          });

          $('#categories, #author_id, #publisher_id').on('select2:open', function (e) {
            $('.select2-dropdown.select2-dropdown--below').css({
              'z-index': 1100,
              'color': '#545454'
            });
          });

          $('#categories, #author_id, #publisher_id').on('select2:select', function (e) {
            setTimeout(() => {
              $('.select2-selection__choice').css('color', '#545454 !important');
            }, 20);
          });

          $('.select2-selection__rendered, .swal2-content .col-md-3').css({
            'text-align': 'left',
          });

          $('.select2-selection--single, .select2-selection--multiple').css('border', '1px solid #d2d6de');
        },
        preConfirm: () => {
          return new Promise((resolve) => {
              swal.showLoading();
              setTimeout(() => {

              data = {};

              $('#swal2-content input[id], #swal2-content textarea[id], #swal2-content select[id]').each((a,input) => {
                data[$(input)[0].id] = $(input).val();

                if(typeof data[$(input)[0].id] == "object")
                {
                  data[$(input)[0].id] = JSON.stringify(data[$(input)[0].id]);
                }

                if($(input).val() == "")
                {
                  swal.showValidationError($(input)[0].id + ' is required');
                  return false;
                }

                if($(input)[0].id == "isbn")
                {
                  if(!/^[0-9-]*$/.test(data['isbn']))
                  {
                    swal.showValidationError('ISBN must contain only numbers and dash');
                    return false;
                  }
                }
              })

              resolve()}, 500);
          })
        },
      }).then(choice => {
        if(choice.value)
        {
          $.ajax({
            url: 'addRow/books',
            method: 'POST',
            data: data,
            success: result => {
              if(result == 1)
              {
                swal({
                  type: 'success',
                  title: 'Book has been added successfully',
                  timer: 800,
                  showConfirmButton: false,
                }).then(() => {
                  $('#booksTable').DataTable().ajax.reload();
                })
              }
              else
              {
                swal({
                  type: 'error',
                  title: 'Try Again',
                  title: 'There was a problem adding the book.',
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

  function viewRow(id)
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
            <textarea class="form-control" disabled placeholder="Enter Description" id="description" cols="30" rows="3"></textarea><br>
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
      `,
      width: "600px",
      confirmButtonText: "OK",
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
          'accession_number'
        ];

        getInputValues('books', id, values);
      }
    })
  }

  function getInputValues(table, id, values)
  {
    $.ajax({
      url: 'getRow/' + table,
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
                url: 'getRow/' + db_tables[index],
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
          }
        })
      }
    });
  }

  function deleteRow(id)
  {
    swal({
      type: 'question',
      title: 'Are you sure you want to delete this Book ?',
      showCancelButton: true
    }).then(choice => {
      if(choice.value)
      {
        $.ajax({
          url: 'deleteRow/books',
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
                $('#booksTable').DataTable().ajax.reload(getIdNames);
              })
            }
            else
            {
              swal({
                type: 'error',
                title: 'Try Again',
                text: 'There was a problem deleting the book',
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
      url: 'getRow/books',
      data: {id: id},
      success: result => {
        result = JSON.parse(result);

        swal({
          title: 'EDIT BOOK',
          html: `
            <form action="validateBookDetails" method="POST" id="bookForm">
            
            <input type="hidden" name="id" value="` + result.id + `" />

            <div class="row">
              <div class="col-md-3">
                <b><label>Title</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" id="title" name="title" class="form-control" placeholder="Enter Title" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Description</label></b>
              </div>
              <div class="col-md-9">
                <textarea class="form-control" placeholder="Enter Description" id="description" name="description" cols="30" rows="5"></textarea><br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Category</label></b>
              </div>
              <div class="col-md-9">
                <select id="categories" name="categories[]" class="form-control" multiple></select>
              </div>
            </div>
    
            <div class="row">
              <br>
              <div class="col-md-3">
                <b><label>ISBN</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" id="isbn" name="isbn" class="form-control" placeholder="Enter ISBN" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Edition</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" id="edition" name="edition" class="form-control" placeholder="Enter Edition" /></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Published On</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" id="date_published" name="date_published" class="form-control" placeholder="Select Publish Date"/></br>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Author</label></b>
              </div>
              <div class="col-md-9">
                <select id="author_id" name="author_id" class="form-control"></select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <b><label>Publisher/s</label></b>
              </div>
              <div class="col-md-9">
                <select id="publisher_id" name="publisher_id[]" class="form-control" multiple></select>
              </div>
            </div>

            <div class="row">
              <br>
              <div class="col-md-3">
                <b><label>Accession number</label></b>
              </div>
              <div class="col-md-9">
                <input type="text" min="0" id="accession_number" name="accession_number" class="form-control" placeholder="Enter Accession number"/></br>
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

            //PRESELECT VALUES
            values = [
              'title', 
              'description',
              'isbn', 
              'edition', 
              'date_published',
              'accession_number',
              'categories',
              'author_id',
              'publisher_id',
            ];

            db_tables['categories'] = 'categories';
            db_tables['author_id'] = 'authors';
            db_tables['publisher_id'] = 'publishers';

            values.forEach(column => {
              if(['categories', 'author_id', 'publisher_id'].includes(column))
              {
                ids = JSON.parse(result[column]);
                ids = typeof ids == "object" ? ids : [ids];

                ids.forEach((rowId, index) => {
                  $.ajax({
                    url: 'getRow/' + db_tables[column],
                    data: {id: rowId},
                    success: rowResult => {
                      rowResult = JSON.parse(rowResult);

                      if(rowResult.name)
                      {
                        name = rowResult.name;
                      }
                      else
                      {
                        name = rowResult.fname + " " + rowResult.lname;
                      }

                      var option = new Option(name, rowResult.id, true, true);
                      $('#' + column).append(option).trigger('change').trigger('select2:select');
                    }
                  })
                })

                $('#' + column).on('select2:unselect', () => {
                  $('#' + column).trigger('select2:select');
                });
              }
              else
              {
                $('#' + column).val(result[column]);
              }
            });

            //FLATPICKR
            $('#date_published').flatpickr({
              altInput: true,
              altFormat: "F j, Y",
            });

            //SELECT
            var select2Category = $('#categories').select2({
              placeholder: 'Select Categories',
              ajax: {
                url: 'getForSelect/categories/name',
                processResults: function(categories){
                  return {
                    results: JSON.parse(categories)
                  };
                },
              }
            });
            
            $('#author_id').select2({
              placeholder: 'Select Author',
              ajax: {
                url: 'getForSelect/authors/name',
                processResults: function(authors){
                  return {
                    results: JSON.parse(authors)
                  };
                },
              }
            });

            $('#publisher_id').select2({
              placeholder: 'Select Publisher/s',
              ajax: {
                url: 'getForSelect/publishers/name',
                processResults: function(publishers){
                  return {
                    results: JSON.parse(publishers)
                  };
                },
              }
            });

            $('#categories, #author_id, #publisher_id').on('select2:open', function (e) {
              $('.select2-dropdown.select2-dropdown--below').css({
                'z-index': 1100,
                'color': '#545454'
              });
            });

            $('#categories, #author_id, #publisher_id').on('select2:select', function (e) {
              setTimeout(() => {
                $('.select2-selection__choice').css('color', '#545454 !important');
              }, 20);
            });

            $('.select2-selection__rendered, .swal2-content .col-md-3').css({
              'text-align': 'left',
            });

            $('.select2-selection--single, .select2-selection--multiple').css('border', '1px solid #d2d6de');
          },
        }).then(choice => {
          if(choice.value)
          {
            $('#bookForm').submit();
          }
        })
      }
    })
  }

  function duplicateRow(id){
    swal({
      title: 'Add Copy of Book',
      text: 'Enter Accession number',
      input: "text",
      showCancelButton: true,
      preConfirm: (accession_number) => {
        return new Promise((resolve) => {
            swal.showLoading();
            setTimeout(() => {
              if(accession_number == ""){
                swal.showValidationError('Accession number is required');
              }
            resolve()}, 1000);
        })
      },
    }).then(choice => {
      if(choice.value){
        $.ajax({
          url: 'getRow/books',
          data: {id: id},
          success: result => {
            result = JSON.parse(result);
            result.accession_number = choice.value;
            delete result.id;
            delete result.created_at;
            delete result.updated_at;
            delete result.deleted_at;
            $.ajax({
              url: 'duplicateBook/books',
              method: 'POST',
              data: result,
              success: result => {
                window.location.reload();
              }
            })
          }
        })
      }
    })
  }

  $('.table-col').css('float', 'none');
</script>