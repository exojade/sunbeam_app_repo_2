<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
<link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Schedule</h1>
          </div>

          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSchedule">Add Schedule</button>
            </ol>
          </div>
        
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="modal fade" id="addSchedule">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Schedule</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

            <?php
              $advisory = query("select a.*, s.section from advisory a left join section s
                                  on s.section_id = a.section_id
                                  where school_year = ?", $sy["syid"]);

              $subjects = query("select * from subjects where subject_type = 'PARENT'");
              $teacher = query("select * from teacher");

            ?>


              <form class="generic_form_files_trigger" role="form" enctype="multipart/form-data" data-url="schedule">
                <input type="hidden" name="action" value="addSchedule">
              <div class="form-group">
                <label for="exampleInputEmail1">Grade / Section</label>
                <select style="width: 100%;" required name="advisory_id" class="form-control select2">
                  <option selected disabled value="">Please Grade Level</option>
                  <?php foreach($advisory as $row): ?>
                    <option value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Subject</label>
                <select style="width: 100%;" required name="subject" class="form-control select2">
                  <option selected disabled value="">Please select Subject</option>
                  <?php foreach($subjects as $row): ?>
                    <option value="<?php echo($row["subject_id"]); ?>"><?php echo($row["subject_code"]); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Teacher</label>
                <select style="width: 100%;" required name="teacher" class="form-control select2">
                  <option selected disabled value="">Please select Teacher</option>
                  <?php foreach($teacher as $row): ?>
                    <option value="<?php echo($row["teacher_id"]); ?>"><?php echo($row["teacher_lastname"] . ", " . $row["teacher_firstname"]); ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="deceased_burial_time">Start Time</label>
                      <input required type="text" id="from_time" name="start_time" class="form-control ">
                  </div>
                </div>
                <div class="col-6">
                  <div class="form-group">
                      <label for="deceased_burial_time">End Time</label>
                      <input required type="text" id="to_time" name="end_time" class="form-control ">
                  </div>
                </div>
              </div>

              <div class="form-group clearfix">
                
                   
                      <div class="icheck-primary d-inline">
                        <input name="monday" type="checkbox" id="checkboxPrimary1" checked>
                        <label for="checkboxPrimary1">
                          M
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input name="tuesday" type="checkbox" id="checkboxPrimary2" checked>
                        <label for="checkboxPrimary2">
                          T
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input name="wednesday" type="checkbox" id="checkboxPrimary3" checked>
                        <label for="checkboxPrimary3">
                          W
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input name="thursday" type="checkbox" id="checkboxPrimary4" checked>
                        <label for="checkboxPrimary4">
                          TH
                        </label>
                      </div>
                      <div class="icheck-primary d-inline">
                        <input name="friday" type="checkbox" id="checkboxPrimary5" checked>
                        <label for="checkboxPrimary5">
                          F
                        </label>
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
                        <select required id="advisorySelect" class="form-control select2 selectFilter">
                          <option selected value="">Filter Advisory</option>
                          <?php
                          $advisory = query("select a.*, s.section from advisory a left join section s
                                              on s.section_id = a.section_id
                                              where school_year = ?", $sy["syid"]);
                          ?>
                          <?php foreach($advisory as $row): ?>
                            <option value="<?php echo($row["advisory_id"]); ?>"><?php echo($row["grade_level"] . " - " . $row["section"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <!-- <div class="col-md-3">
                      <div class="form-group">
                        <select required name="gender" class="form-control select2 selectFilter">
                          <option selected disabled value="">Filter Section</option>
                          <option value="">Section Apple</option>
                          <option value="">Section Orange</option>
                          <option value="">Section Grapes</option>
                         
                        </select>
                      </div>
                  
                    </div> -->

                    <div class="col-md-3">
                      <div class="form-group">
                        <select required id="teacherSelect" class="form-control select2 selectFilter">
                          <option selected value="">Filter Subject Teacher</option>
                          <?php
                          $teacher = query("select * from teacher");
                          ?>
                          <?php foreach($teacher as $row): ?>
                            <option value="<?php echo($row["teacher_id"]); ?>"><?php echo($row["teacher_lastname"] . ", " . $row["teacher_firstname"]); ?></option>
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
                    <th>SY</th>
                    <th>Level</th>
                    <th>Section</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th width="8%">Action</th>

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
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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
                    'url':'schedule',
                     'type': "POST",
                     "data": function (data){
                        data.action = "scheduleList";
                     }
                },
                'columns': [
                    { data: 'school_year', "orderable": false  },
                    { data: 'grade_level', "orderable": false  },
                    { data: 'section', "orderable": false  },
                    { data: 'subject', "orderable": false  },
                    { data: 'teacher', "orderable": false  },
                    { data: 'time_schedule', "orderable": false  },
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

      var advisory = $('#advisorySelect').val() || "";
      var teacher = $('#teacherSelect').val() || "";

      datatable.ajax.url('schedule?action=scheduleList&advisory='+advisory+'&teacher='+teacher).load();
    });



    flatpickr("#from_time", {
    enableTime: true,               // Enable time selection
    noCalendar: true,               // Disable calendar
    dateFormat: "h:i K",           // Date format (12-hour with AM/PM)
    minTime: "07:10",               // Minimum allowed time
    maxTime: "16:00",               // Maximum allowed time
    time_24hr: false,               // Use 12-hour time format
    minuteIncrement: 5,            // Set time interval if needed
    // disableMobile: true,             // Disable mobile-friendly mode
    defaultDate: "07:10", 
});


flatpickr("#to_time", {
    enableTime: true,               // Enable time selection
    noCalendar: true,               // Disable calendar
    dateFormat: "h:i K",           // Date format (12-hour with AM/PM)
    minTime: "07:20",               // Minimum allowed time
    maxTime: "16:00",               // Maximum allowed time
    time_24hr: false,               // Use 12-hour time format
    minuteIncrement: 5,            // Set time interval if needed
    // disableMobile: true,             // Disable mobile-friendly mode
    defaultDate: "07:10", 
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