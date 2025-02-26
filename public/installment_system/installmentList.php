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
            <h1>Installment Tracker</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">










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
                        <select required id="schoolYearSelect" class="form-control select2 selectFilter">
                          <option value="">Select School Year</option>
                          <?php
                          $syList = query("select * from school_year order by school_year desc");
                          ?>
                          <?php foreach($syList as $row): ?>

                            <?php if($school_year[0]["syid"] == $row["syid"]): ?>
                              <option selected value="<?php echo($row["syid"]); ?>"><?php echo($row["school_year"]); ?></option>
                            <?php else: ?>
                              <option value="<?php echo($row["syid"]); ?>"><?php echo($row["school_year"]); ?></option>
                            <?php endif; ?>

                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="installmentSelect" class="form-control select2 selectFilter">
                          <option  value="">Select Installment Period</option>
                          <option selected value="2">1st Installment</option>
                          <option value="3">2nd Installment</option>
                          <option value="4">3rd Installment</option>
                          <option value="5">4th Installment</option>
                          <option value="6">5th Installment</option>
                          <option value="7">6th Installment</option>
                          <option value="8">7th Installment</option>
                          <option value="9">8th Installment</option>
                          <option value="10">9th Installment</option>
                          <option value="11">10th Installment</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="gradeLevelSelect" class="form-control select2 selectFilter">
                          <option selected value="">Grade Level</option>
                          <?php
                          // dump($sy);
                          $grade_level = query("select * from grade_level");
                          // dump($student);
                          ?>
                          <?php foreach($grade_level as $row): ?>
                            <option value="<?php echo($row["grade_level"]); ?>"><?php echo($row["grade_level"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Student Name</th>
                    <th>School Year</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <th>Installment</th>
                    <th>Amount Due</th>
                    <th>Status</th>
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

$('.select2').select2({
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
                    'url':'installment',
                     'type': "POST",
                     "data": function (data){
                        data.action = "installmentList";
                     }
                },
                'columns': [
                    { data: 'student', "orderable": false  },
                    { data: 'school_year', "orderable": false  },
                    { data: 'grade_level', "orderable": false  },
                    { data: 'section', "orderable": false  },
                    { data: 'installment_number', "orderable": false  },
                    {
                        data: 'amount_due', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    { data: 'is_paid', "orderable": false },
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

            $('.selectFilter').on('change', function() {
              filterDatatable()
              });

        function filterDatatable(){
          var school_year = $('#schoolYearSelect').val() || "";
          var installment_number = $('#installmentSelect').val() || "";
          var grade_level = $('#gradeLevelSelect').val() || "";
          datatable.ajax.url('installment?action=installmentList&school_year='+school_year+'&installment_number='+installment_number+'&grade_level='+grade_level).load();
        }

        filterDatatable();


        </script>
  <?php require("layouts/footer.php") ?>