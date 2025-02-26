<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Payment</h1>
          </div>
          <div class="col-sm-6">
            <h1 id="feeTotal" class="float-right"> ₱ 0.00</h1>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
              <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="methodSelect" class="form-control select2 selectFilter">
                          <option selected value="">Method of Payment</option>
                          <option  value="CASH">CASH</option>
                          <option  value="BANK">BANK</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <input type="date" id="fromDate" class="form-control">
                    </div>
                    <div class="col-md-3">
                      <input type="date" id="toDate" class="form-control">
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Amount Paid</th>
                      <th>OR Number</th>
                      <th>Type</th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
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
  <script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>



$('#modalUpdateFee').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'fees', //Here you will fetch records 
            data: {
                fees_id: rowid, action: "modalUpdateFee"
            },
            success : function(data){
                $('#modalUpdateFee .fetched-data').html(data);
                Swal.close();
            }
        });
     });


$('.select2').select2({
    });

var datatable = 
            $('#ajaxDatatable').DataTable({
                "searching": false,
                "pageLength": 100,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": true,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'payment',
                     'type': "POST",
                     "data": function (data){
                        data.action = "paymentList",
                        data.syid = "<?php echo($sy["syid"]); ?>"
                     }
                },
                'columns': [
                    { data: 'date_paid', "orderable": false  },
                    { 
                    data: 'amount_paid', 
                        "orderable": false,
                        render: function (data, type, row) {
                            return '₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    },
                    { data: 'or_number', "orderable": false  },
                    { data: 'method_of_payment', "orderable": false },

                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    received = api
                        .column(1)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        console.log(received);

                    $('#feeTotal').html('₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }
            });

            function filter(){
              var methodSelect = $('#methodSelect').val() || "";
              var fromDate = $('#fromDate').val() || "";
              var toDate = $('#toDate').val() || "";
              datatable.ajax.url('payment?action=paymentList&method='+methodSelect+'&from='+fromDate+'&to='+toDate).load();
            }

            $('.selectFilter').on('change', function() {
                filter();
              });

              $("#fromDate, #toDate").on("keyup change", function() {
                  filter();
              });
            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }
        </script>
  <?php require("layouts/footer.php") ?>