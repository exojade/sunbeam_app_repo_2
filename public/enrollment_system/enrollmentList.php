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
            <h1>Enrollment Masterlist</h1>
            <!-- <small>For School Year: 2023 - 2024</small> -->
          </div>
          <?php if($_SESSION["sunbeam_app"]["role"] == "admin"): ?>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <a href="enrollment?action=new" class="btn btn-primary">New Enrollee</a> &nbsp;&nbsp;
            <a href="#" data-toggle="modal" data-target="#reEnrollModal" class="btn btn-warning">Re-Enroll</a>
            </ol>
          </div>
          <?php endif; ?>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


      <div class="modal fade" id="reEnrollModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">RE ENROLL MODAL</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <?php $students = query("select s.* from student s left join enrollment e
                                    on e.student_id = s.student_id where
                                    e.syid != ?", $school_year[0]["syid"]);
                                    ?>

            <?php                    $advisory = query("SELECT a.*, s.*, a.grade_level AS grade_level,
       CASE 
           WHEN e.student_count IS NULL OR e.student_count < a.max_students THEN 'Active' 
           ELSE 'Inactive' 
       END AS advisory_status
FROM advisory a
LEFT JOIN section s ON s.section_id = a.section_id
LEFT JOIN (
    SELECT advisory_id, COUNT(*) AS student_count
    FROM enrollment
    GROUP BY advisory_id
) e ON e.advisory_id = a.advisory_id
WHERE a.school_year = ?
ORDER BY a.grade_level ASC", $sy["syid"]); 
                                    ?>
              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="enrollment">
                <input type="hidden" name="action" value="reEnroll">
                <input type="hidden" name="school_year" value="<?php echo($school_year[0]["syid"]); ?>">
              <div class="row">
                <div class="col-md-12">
                <div class="form-group">
                  <label>Student To Re-Enroll</label>
                  <select required name="student" class="form-control select2" id="" style="width: 100%;" >
                  <option selected disabled value="" data-amount="">Please Select Student</option>
                    <?php foreach($students as $row): ?>
                      <option value="<?php echo($row["student_id"]); ?>" ><?php echo($row["lastname"]. ", " . $row["firstname"]); ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group">
                  <label>Section To Enroll</label>
                  <select required name="advisory" class="form-control " id="" style="width: 100%;" >
                  <option selected disabled value="" data-amount="">Please Select Advisory</option>
                    <?php foreach($advisory as $row): ?>
                      <?php if($row["advisory_status"] == "Active"): ?>
                            <option class="text-success" value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?></option>
                            <?php else: ?>
                              <option class="text-danger" disabled value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?> (Full)</option>
                            <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
                </div>
              
              </div>

            

          
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                  </form>
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
                        <select required id="studentSelect" class="form-control select2 selectFilter">
                          <option selected value="">Search Student</option>
                          <?php
                          // dump($sy);
                          $student = query("select s.student_id, concat(lastname, ', ' , firstname) as student_name from enrollment e
                                            left join student s
                                            on s.student_id = e.student_id
                                            where e.syid = ?
                                            ", $sy["syid"]);
                          // dump($student);
                          ?>
                          <?php foreach($student as $row): ?>
                            <option value="<?php echo($row["student_id"]); ?>"><?php echo($row["student_name"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Student Name</th>
                    <th>Date Enrolled</th>
                    <th>Grade Level</th>
                    <th>Section</th>
                    <!-- <th>Adviser</th> -->
                    <th>Status</th>
                    <th>Action</th>
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
                    'url':'enrollment',
                     'type': "POST",
                     "data": function (data){
                        data.action = "enrollmentList";
                     }
                },
                'columns': [
                    { data: 'student_id', "orderable": false  },
                    { data: 'student', "orderable": false  },
                    { data: 'dateEnrolled', "orderable": false  },
                    { data: 'grade_level', "orderable": false  },
                    { data: 'section', "orderable": false  },
                    // { data: 'teacher', "orderable": false  },
                    { data: 'status', "orderable": false  },
                    { data: 'action', "orderable": false },

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
              var student_id = $('#studentSelect').val() || "";
              datatable.ajax.url('enrollment?action=enrollmentList&student_id='+student_id).load();
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