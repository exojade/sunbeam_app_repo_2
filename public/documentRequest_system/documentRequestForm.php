<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col">
            <h1>Online Payment Cashier Module</h1>
          </div>
         
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="updateStatusModal">
          <div class="modal-dialog">
            <div class="modal-content ">
              <div class="modal-header bg-warning">
					    <h3 class="modal-title text-center">Document Request Modal</h3>
              </div>
              <div class="modal-body" style="-webkit-user-select: none;  /* Chrome all / Safari all */
              -moz-user-select: none;     /* Firefox all */
              -ms-user-select: none;  ">
              <form class="generic_form_trigger" data-url="documentRequest">
                <input type="hidden" name="action" value="updateDocumentRequest">
                    <div class="fetched-data"></div>
                    <br>
                      <div class="modal-footer">
                        <button type="submit" class=" btn btn-primary float-right">Submit</button>
                        <button type="button" class=" btn btn-danger float-right" data-dismiss="modal" aria-label="Close">Close</button>
                      </div>
              </div>
</form>
            </div>
          </div>
        </div>




    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-body table-responsive">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Parent</th>
                    <th>Document</th>
                    <th>Student</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                    <!-- <th width="10%">Action</th> -->
                  </tr>
                  </thead>
               
                  <tfoot>
             
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- <div class="col-4">

          <div class="card">
          <div class="card-header bg-info">
                <h3 class="card-title">Request Form</h3>
              </div>
              <div class="card-body">
              <div class="alert alert-warning alert-dismissible">
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Note!</h5>
                  The duration for obtaining the document may depend on the type of document being requested.
                </div>

                <form class="generic_form_trigger" id="requestForm" data-url="documentRequest">
                  <input type="hidden" name="action" value="request">
                  <input type="hidden" name="parent_id" value="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>">

                  <div class="form-group">
                    <label>Document Type </label>
                    <select required class="form-control" name="documentType">
                      <option value="" selected disabled>Please select document</option>
                      <option value="Grade Card">Grade Card</option>
                      <option value="Form 137">Form 137</option>
                      <option value="Honorable Dismissal">Honorable Dismissal</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Student </label>
                    <select required class="form-control" name="student">
                      <?php $student = query("select * from student where parent_id = ?", $_SESSION["sunbeam_app"]["userid"]); ?>
                      <option value="" selected disabled>Please select student</option>
                      <?php foreach($student as $row): ?>
                        <option value="<?php echo($row["student_id"]); ?>"><?php echo($row["lastname"] . ", " . $row["firstname"]); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <button class="btn btn-primary" type="submit">Submit</button>

                </form>
            
              </div>
           
            </div>

          </div> -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <script src="AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
  <script src="AdminLTE_new/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="AdminLTE_new/plugins/jszip/jszip.min.js"></script>
<script src="AdminLTE_new/plugins/pdfmake/pdfmake.min.js"></script>
<script src="AdminLTE_new/plugins/pdfmake/vfs_fonts.js"></script>
<script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="AdminLTE_new/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="AdminLTE_new/plugins/inputmask/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="node_modules/philippine-location-json-for-geer/build/phil.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-validation/additional-methods.min.js"></script>

<script src="AdminLTE_new/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script>
$(function () {
  $('#requestForm').validate({
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-control').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid').removeClass('is-valid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid').addClass('is-valid');
    },
    success: function (label, element) {
      $(element).addClass('is-valid'); // Adds green border when valid
      // Add a green check icon or any valid styling you want to apply
      $(element).closest('.form-control').find('span.valid-feedback').remove();
      // $(element).closest('.form-group').append('<span class="valid-feedback">✓</span>'); // Adds a check mark
    }
  });
});

$('#updateStatusModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'documentRequest', //Here you will fetch records 
            data: {
              tblid: id,
               action: "updateStatusModal"
            },
            success : function(data){
                $('#updateStatusModal .fetched-data').html(data);
                Swal.close();
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });

var datatable = 
            $('#ajaxDatatable').DataTable({
                "searching": false,
                "pageLength": 10,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": true,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'documentRequest',
                     'type': "POST",
                     "data": function (data){
                        data.action = "documentRequestList";
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'parent', "orderable": false  },
                    { data: 'document', "orderable": false  },
                    { data: 'student', "orderable": false  },
                    { 
            data: 'request_status',
            orderable: false,
            render: function(data, type, row) {
                // Add custom class based on status
                if (data === 'PENDING') {
                    return '<span class="text-warning">PENDING</span>';
                } else if (data === 'FOR CLAIM') {
                    return '<span class="text-info">FOR CLAIM</span>';
                } else if (data === 'CLAIMED') {
                    return '<span class="text-success">CLAIMED</span>';
                } else {
                    return data; // Default for other statuses
                }
            }
        },
                    { data: 'dateRequested', "orderable": false  },

                ],
                "footerCallback": function (row, data, start, end, display) {
                    // var api = this.api(), data;
                    

                    // Remove the formatting to get integer data for summation
                    // var intVal = function (i) {
                    //     return typeof i === 'string' ?
                    //         i.replace(/[\$,]/g, '') * 1 :
                    //         typeof i === 'number' ?
                    //             i : 0;
                    // };

                    // // Total over all pages
                    // received = api
                    //     .column(5)
                    //     .data()
                    //     .reduce(function (a, b) {
                    //         return intVal(a) + intVal(b);
                    //     }, 0);
                    //     console.log(received);

                    // $('#currentTotal').html('$ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }
            });



      $('#modalPayOnline').on('show.bs.modal', function (e) {
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'onlinePayment', //Here you will fetch records 
            data: {
               action: "modalPayOnline"
            },
            success : function(data){
                $('#modalPayOnline .fetched-data').html(data);
                Swal.close();
                $(function () {
                  bsCustomFileInput.init();
                });
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });



     $('#verifyOnlinePaymentModal').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'onlinePaymentCashier', //Here you will fetch records 
            data: {
               action: "verifyOnlinePaymentModal",
               tblid: id
            },
            success : function(data){
                $('#verifyOnlinePaymentModal .fetched-data').html(data);
                Swal.close();
                $(function () {
                  bsCustomFileInput.init();
                });
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });






        </script>



  <?php require("layouts/footer.php") ?>