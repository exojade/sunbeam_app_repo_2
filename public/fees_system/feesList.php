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
            <h1>Fees Database</h1>
          </div>
          <div class="col-sm-6">
            <h1 id="feeTotal" class="float-right"> ₱ 0.00</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">







      <div class="modal fade" id="modalUpdateFee">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h4 class="modal-title">Edit Fee</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="generic_form_trigger" data-url="fees">
                <input type="hidden" name="action" value="updateFee">
                   <div class="fetched-data"></div>
                   <hr>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
      
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>







      <?php  $grade_level = query("select * from grade_level"); ?>




      <div class="modal fade" id="addFeeModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">Add Fee Modal</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="generic_form_trigger" data-url="fees">
                <input type="hidden" name="action" value="addFees">
                          <div class="form-group">
                            <label>Grade Level </label>
                            <select style="width: 100%;" name="grade_level" class="form-control select2" >
                              <option selected value="">Please select Grade Level</option>
                              <?php foreach($grade_level as $row): ?>
                                <option value="<?php echo($row["grade_level"]); ?>"><?php echo($row["grade_level"]); ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label>Fee Title <span class="color-red">*</span></label>
                              <input value="" name="fee_title" required type="text" class="form-control"  placeholder="Enter Fee Title Here ..">
                          </div>
                            <div class="form-group">
                              <label>Fee Type <span class="color-red">*</span></label>
                              <select style="width: 100%;" required name="fee_type" class="form-control select2" >
                                  <option selected value="">Please select Type</option>
                                    <option value="MAIN">MAIN</option>
                                    <option value="MISCELLANEOUS">MISCELLANEOUS</option>
                                    <option value="OTHERS">OTHERS</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label>Amount </label>
                                <input value="" name="fee_amount" step="0.01" type="number" class="form-control"  placeholder="Enter Fee Amount Here ..">
                            </div>


                 




                   
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
      
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
              <div class="row">
                    <!-- <div class="col-md-3">
                      <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter School Year</option>
                          <option value="">2023-2024</option>
                        </select>
                      </div>
                    </div> -->
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="gradeLevelSelect" class="form-control select2 selectFilter">
                          <option selected value="">Search Grade Level</option>
                          <?php
                          // dump($sy);
                         
                          // dump($student);
                          ?>
                          <?php foreach($grade_level as $row): ?>
                            <option value="<?php echo($row["grade_level"]); ?>"><?php echo($row["grade_level"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-9">
                      <div class="form-group">
                        <a href="" data-toggle="modal" data-target="#addFeeModal" class="btn btn-info float-right">Add Fee</a>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Action</th>
                      <th>Grade Level</th>
                      <th>Title</th>
                      <th>Type</th>
                      <th>Amount</th>
                      <th>Status</th>
                    </tr>
                  </thead>
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
                    'url':'fees',
                     'type': "POST",
                     "data": function (data){
                        data.action = "feesList";
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'grade_level', "orderable": false  },
                    { data: 'fee_title', "orderable": false  },
                    { data: 'fee_type', "orderable": false },
                    { 
                    data: 'fee_amount', 
                        "orderable": false,
                        render: function (data, type, row) {
                            return '₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    },
                    { data: 'status', "orderable": false  },

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
                        .column(4)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        console.log(received);

                    $('#feeTotal').html('₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                }
            });

            $('.selectFilter').on('change', function() {
              var gradeLevel = $('#gradeLevelSelect').val() || "";
              datatable.ajax.url('fees?action=feesList&gradeLevel='+gradeLevel).load();
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