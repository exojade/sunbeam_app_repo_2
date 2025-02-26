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
            <h1>Parents</h1>
          </div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">


      <div class="modal fade" id="addParentModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">ADD PARENT MODAL</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="totalVal">
              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="parents">
                <input type="hidden" name="action" value="addParent">
                  <div class="row">
                    <div class="col-md-12">
                    <div class="form-group">
                      <label>Select Student</label>
                      <select style="width: 100%;" name="student_id" required class="form-control select2">
                          <option selected value="">Search Student</option>
                          <?php
                          $student = query("select * from student where (parent_id = '' or parent_id is null)");
                          ?>
                          <?php foreach($student as $row): ?>
                            <option value="<?php echo($row["student_id"]); ?>"><?php echo($row["firstname"] . " " . $row["lastname"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                      <label>Select Parent</label>
                      <select name="parent_id" style="width: 100%;" required class="form-control select2">
                          <option selected value="">Search Parent</option>
                          <?php
                          $parents = query("SELECT * from users
                                          WHERE role = 'parent'");
                          ?>
                          <?php foreach($parents as $row): ?>
                            <option value="<?php echo($row["id"]); ?>"><?php echo($row["fullname"] . " - " . $row["username"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                    </div>
                  </div>

              <hr>
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
                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="studentSelect" class="form-control select2 selectFilter">
                          <option selected value="">Search Parent</option>
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

                    <div class="col-md-6">
                      <a href="#" data-toggle="modal" data-target="#addParentModal" class="btn btn-primary float-right">ADD PARENT</a>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="ajaxDatatable" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Parent</th>
                    <th>Username</th>
                    <th>Student</th>
                    <th>Address</th>
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
                    'url':'parents',
                     'type': "POST",
                     "data": function (data){
                        data.action = "parentsList";
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'parent', "orderable": false  },
                    { data: 'username', "orderable": false  },
                    { data: 'student_name', "orderable": false  },
                    { data: 'student_address', "orderable": false  },
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