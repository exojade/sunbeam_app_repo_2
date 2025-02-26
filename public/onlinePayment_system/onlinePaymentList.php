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
            <h1>Online Payment</h1>
          </div>
            <div class="col">
              <a href="#" data-target="#modalPayOnline" data-toggle="modal" class="btn btn-primary float-right">Pay Online</a>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <div class="modal fade" id="modalPayOnline">
          <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content ">
              <div class="modal-header bg-primary">
					    <h3 class="modal-title text-center">Pay Online Module</h3>
              </div>
              <div class="modal-body" style="-webkit-user-select: none;  /* Chrome all / Safari all */
              -moz-user-select: none;     /* Firefox all */
              -ms-user-select: none;  ">
                <?php if(!empty($payment_settings)): ?>
                <div class="alert alert-warning alert-dismissible">
                  <h5><i class="icon fas fa-exclamation-triangle"></i> Payment Schedule Due Date : <?php echo($payment_settings[0]["dueDate"]); ?></h5>
                </div>
                <?php endif; ?>
                  <form class="generic_form_trigger" data-url="onlinePayment" autocomplete="off">
                    <div class="fetched-data"></div>
                    <br>
                      <div class="box-footer">
                        <button type="button" class=" btn btn-danger btn-flat pull-right" data-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-primary btn-flat pull-right">Submit</button>
                      </div>
                  </form>
              </div>
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
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>Transaction Code</th>
                    <th>Date</th>
                    <th>Amount Paid</th>
                    <th>Bank</th>
                    <th>Status</th>
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

<script src="AdminLTE_new/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <script>


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
                    'url':'onlinePayment',
                     'type': "POST",
                     "data": function (data){
                        data.action = "onlinePaymentList";
                        data.paidBy = "<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>";
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'transactionCode', "orderable": false  },
                    { data: 'transactionDate', "orderable": false  },
                    {
            data: 'amount',
            orderable: false,
            render: function(data, type, row) {
                // Format the number with peso sign, commas, and two decimal places
                if (type === 'display' || type === 'filter') {
                    return '₱' + parseFloat(data).toLocaleString('en-PH', { 
                        minimumFractionDigits: 2, 
                        maximumFractionDigits: 2 
                    });
                }
                // Return raw data for other types (like sorting)
                return data;
            }
        },
                    { data: 'bank', "orderable": false  },
                    { data: 'status', "orderable": false  },

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






        </script>



  <?php require("layouts/footer.php") ?>