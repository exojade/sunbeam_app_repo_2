<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<?php
// dump($_SESSION);
$schedules = query("
    SELECT 
        s.*, 
        sec.section, 
        sub.subject_code, 
        a.grade_level AS gradeLevel,
        CASE 
            WHEN sub.subject_id IN (SELECT subject_parent_id FROM subjects WHERE subject_parent_id IS NOT NULL) THEN 1
            ELSE 0
        END AS has_parent
    FROM schedule s
    LEFT JOIN advisory a ON a.advisory_id = s.advisory_id
    LEFT JOIN subjects sub ON sub.subject_id = s.subject_id
    LEFT JOIN section sec ON sec.section_id = a.section_id
    WHERE s.teacher_id = ?
    AND syid = ?
", $_SESSION["sunbeam_app"]["userid"], $sy["syid"]);
// dump($schedules);
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>My Classrooms</h1>
            <small>Current SY: 2023 - 2024</small>
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
          <?php foreach($schedules as $row): 
            $days_string = '';
            if ($row["monday"] == 1) {
              $days_string .= 'M , ';
            }
            if ($row["tuesday"] == 1) {
              $days_string .= 'T , ';
            }
            if ($row["wednesday"] == 1) {
              $days_string .= 'W , ';
            }
            if ($row["thursday"] == 1) {
              $days_string .= 'TH , ';
            }
            if ($row["friday"] == 1) {
              $days_string .= 'F';
            }
          
            // Remove the trailing comma
            $days_string = rtrim($days_string, ',');
            ?>
            <div class="col-md-4">

           <?php if($row["has_parent"] == 0): ?>
            <a href="schedule?action=gradeTeacher&id=<?php echo($row["schedule_id"]); ?>&subject_id=<?php echo($row["subject_id"]); ?>">
           <?php else: ?>
            <a href="schedule?action=childSubjects&id=<?php echo($row["schedule_id"]); ?>">
           <?php endif; ?>
            
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username"><?php echo($row["subject_code"]); ?></h3>
                <h5 class="widget-user-desc"><?php echo($row["gradeLevel"]); ?> - 
                         <?php echo($row["section"]); ?></h5>
                <h5 class="widget-user-desc"></h5>
              </div>
           
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="description-block">
                      <h5 class="description-header"><?php echo($row["from_time"] . " - " . $row["to_time"]); ?></h5>
                      <span class="description-text"><?php echo($days_string); ?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
             
                </div>
                <!-- /.row -->
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