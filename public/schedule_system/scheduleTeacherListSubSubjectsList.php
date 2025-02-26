<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?php
// dump($_SESSION);
// $schedules = query("select s.*,sec.section, sub.subject_code, a.grade_level as gradeLevel from schedule s
//                     left join advisory a
//                     on a.advisory_id = s.advisory_id
//                     left join subjects sub
//                     on sub.subject_id = s.subject_id
//                     left join section sec
//                     on sec.section_id = a.section_id  
//                     left join    
//                     where s.teacher_id = ?
//                     and syid = ?
//                   ", $_SESSION["sunbeam_app"]["userid"], $sy["syid"]);
// dump($schedules);

$schedule = query("SELECT 
    s.*, 
    sec.section, 
    sub.subject_code, 
    a.grade_level as gradeLevel,
    CONCAT_WS(', ',
        IF(s.monday = 1, 'Monday', NULL),
        IF(s.tuesday = 1, 'Tuesday', NULL),
        IF(s.wednesday = 1, 'Wednesday', NULL),
        IF(s.thursday = 1, 'Thursday', NULL),
        IF(s.friday = 1, 'Friday', NULL)
    ) AS scheduled_days,
    sm.subject_head_name
FROM 
    schedule s
LEFT JOIN 
    advisory a ON a.advisory_id = s.advisory_id
LEFT JOIN 
    subjects sub ON sub.subject_id = s.subject_id
LEFT JOIN 
    section sec ON sec.section_id = a.section_id  
LEFT JOIN 
    subject_main sm ON sm.subject_head_id = sub.subject_head_id  
WHERE 
    s.schedule_id = ?
                  ", $_GET["id"]);
// dump($schedule);
$childSubjects = query("select * from subjects where subject_parent_id = ?", $schedule[0]["subject_id"]);
// dump($childSubjects);

?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <!-- <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Classrooms</h1>
            <small>Current SY: 2023 - 2024</small>
          </div>
        </div> -->
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      <h5 class="bg-teal p-2"><?php echo($schedule[0]["subject_head_name"] . " - " . $schedule[0]["subject_code"]); ?></h5>
      <table class="table table-bordered" id="advisorySection">
			<tr>
                   <th>Grade Level:</th>
                   <td><?php echo($schedule[0]["gradeLevel"]); ?></td>
                   <th>Section:</th>
                   <td><?php echo($schedule[0]["section"]); ?></td>
                 </tr>

                 <tr>
                   <th>Time</th>
                   <td><?php echo($schedule[0]["from_time"] . " - " . $schedule[0]["to_time"]); ?></td>
                   <th>Days</th>
                   <td><?php echo($schedule[0]["scheduled_days"]); ?></td>
                 </tr></table>

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
              <form class="generic_form_files_trigger" role="form" enctype="multipart/form-data" data-url="subjects">
              <div class="form-group">
                <label for="exampleInputEmail1">Grade / Section</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Please Grade Level</option>
                  <option value="Grade 1">Grade 1 - Section Orange</option>
                  <option value="Grade 1">Grade 1 - Section Sunflower</option>
                  <option value="Grade 1">Grade 2 - Section Apple</option>
                  <option value="Grade 1">Grade 3 - Section Rose</option>
                  <option value="Grade 1">Grade 4 - Section Moon</option>
                  <option value="Grade 1">Grade 5 - Section Honey Bee</option>
                  <option value="Grade 1">Grade 6 - Section Carnation</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Subject</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Please select Subject</option>
                  <option value="Grade 1">Math 01</option>
                  <option value="Grade 1">Math 03</option>
                </select>
              </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Teacher</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Please select Teacher!</option>
                  <option value="Grade 1">Victor Magtanggol</option>
                  <option value="Grade 1">Henry Canlas</option>
                  <option value="Grade 1">Maris Racal</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Time Schedule</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Please select schedule!</option>
                  <option value="Grade 1">07:30 - 08:30 AM</option>
                  <option value="Grade 1">08:30 - 09:30 AM</option>
                  <option value="Grade 1">09:30 - 10:30 AM</option>
                  <option value="Grade 1">10:30 - 11:30 AM</option>
                  <option value="Grade 1">12:30 - 01:30 PM</option>
                  <option value="Grade 1">01:30 - 02:30 PM</option>
                  <option value="Grade 1">02:30 - 03:30 PM</option>
                  <option value="Grade 1">03:30 - 04:30 PM</option>
                  <option value="Grade 1">03:30 - 04:30 PM</option>
                </select>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <div class="row">
          <?php foreach($childSubjects as $row): 
            // Remove the trailing comma
            // dump($row);
            // $days_string = rtrim($days_string, ',');
            ?>
            <div class="col-md-3">
            <a href="schedule?action=gradeTeacher&id=<?php echo($schedule[0]["schedule_id"]); ?>&subject_id=<?php echo($row["subject_id"]); ?>">
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username"><b><?php echo($row["subject_title"]); ?></b></h3>
                <!-- <h5 class="widget-user-desc"><?php echo($row["gradeLevel"]); ?> - 
                         <?php echo($row["section"]); ?></h5> -->
                <h5 class="widget-user-desc"></h5>
              </div>
           
    
            </div></a>
            </div>
          <?php endforeach; ?>
      </div>
      </div>
    </section>
    <!-- /.content -->
  </div>

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

$('#example1').DataTable({
  ordering: false
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