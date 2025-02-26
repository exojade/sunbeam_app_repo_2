<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">

<?php

$subject = query("select * from subjects where subject_id = ?", $_GET["subject_id"]);
$subject = $subject[0];

if($subject["subject_type"] == "CHILD"):
  $concatSubject = $subject["subject_title"];
else:
  $concatSubject = "";
endif;


$schedule = query("select a.grade_level,sched.*,s.section, sub.subject_code, sub.subject_title,
                  CONCAT(t.teacher_lastname, ', ', t.teacher_firstname) AS adviser,
                  sm.subject_head_name
                  from schedule sched
                  left join advisory a
                  on a.advisory_id = sched.advisory_id
                  left join teacher t
                  on t.teacher_id = a.teacher_id
                  left join section s
                  on s.section_id = a.section_id
                  left join subjects sub
                  on sub.subject_id = sched.subject_id
                  left join subject_main sm
                  on sm.subject_head_id = sub.subject_head_id
                  where schedule_id = ?", $_GET["id"]);
  $schedule = $schedule[0];
  // dump($schedule);

  $days_string = '';
                          if ($schedule["monday"] == 1) {
                            $days_string .= 'M,';
                          }
                          if ($schedule["tuesday"] == 1) {
                            $days_string .= 'T,';
                          }
                          if ($schedule["wednesday"] == 1) {
                            $days_string .= 'W,';
                          }
                          if ($schedule["thursday"] == 1) {
                            $days_string .= 'TH,';
                          }
                          if ($schedule["friday"] == 1) {
                            $days_string .= 'F,';
                          }
                        
                          // Remove the trailing comma
                          $days_string = rtrim($days_string, ',');


$teacher = query("select * from teacher where teacher_id = ?", $schedule["teacher_id"]);  
$teacher = $teacher[0];
$grades = query("select g.*, concat(s.lastname, ', ', s.firstname) as student_name, sub.subject_type from student_grades g
                  left join student s
                  on s.student_id = g.student_id
                  left join subjects sub
                  on sub.subject_id = g.subject_id
                  where schedule_id = ?
                  and g.subject_id = ?
                  group by schedule_id, student_id
                  order by s.lastname asc, s.firstname asc
                  ", $schedule["schedule_id"], $_GET["subject_id"]);
// dump($grades);
                          ?>

                          


<style>
  #sectionTable td{
    border: 0px;
    padding: 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 0px;
  }
</style>
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-0">
       
        </div>
      </div>
    </section>
    <section class="content">
    <div class="modal fade" id="modalUpdateGrades">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content ">
              <div class="modal-header bg-warning">
					    <h3 class="modal-title text-center">Update Grade</h3>
              </div>
              <div class="modal-body" style="-webkit-user-select: none;  /* Chrome all / Safari all */
              -moz-user-select: none;     /* Firefox all */
              -ms-user-select: none;  ">
                  <form class="generic_form_trigger" data-title="Update Grade" data-message="Are you sure you want to update the grade?" data-url="schedule" autocomplete="off">
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
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Schedule Information</h3>
              </div>
                <div class="card-body">
                  <div class="row">
                 
                    <div class="col-md-12">
                    <table class="table" id="sectionTable">
                    <tr>
                      <th>Section:</th>
                      <td><?php echo($schedule["grade_level"]. " - " . $schedule["section"]); ?></td>
                      <th>Adviser:</th>
                      <td><?php echo($schedule["adviser"]); ?></td>
                    </tr>
                    <tr>
                      <th>Subject:</th>
                      <td><?php echo($schedule["subject_head_name"] . " - " . $concatSubject); ?></td>
                      <th>Teacher:</th>
                      <td><?php echo($teacher["teacher_lastname"]. ", " . $teacher["teacher_firstname"]); ?></td>
                    </tr>
                    <tr>
                      <th>Time Schedule:</th>
                      <td><?php echo($schedule["from_time"] . " - " . $schedule["to_time"]); ?></td>
                      <th>Day:</th>
                      <td><?php echo($days_string); ?></td>
                    </tr>
                  </table>
                    </div>
                  </div>
                </div>
            </div>
                  <hr>
          <div class="col-md-12">
          <?php if(!empty($unenrolled)): ?>
          <form class="generic_form_trigger" data-url="advisory">
            <input type="hidden" name="action" value="addClass">
            <input type="hidden" name="advisory_id" value="<?php echo($_GET["id"]); ?>">
          <div class="row">
            <div class="col-3">
            <div class="form-group">
              <select required name="student_id" class="form-control select2">
                <option selected disabled value="">Please select Learner</option>
                <?php foreach($unenrolled as $row): ?>
                  <option value="<?php echo($row["student_id"]); ?>"><?php echo($row["lastname"] . ", " . $row["firstname"]); ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            </div>
            <div class="col-2">
              <button class="btn btn-primary btn-block">Submit</button>
              
            </div>
          </div>
          </form>
          <?php endif; ?>


            <div class="card">
              <div class="card-header p-2">
              
              <?php
              $settings = query("select * from settings");
              ?>
              <?php foreach($settings as $row): ?>
                <?php
                  if($row["grading_period"] == "first_grading"): ?>
                  <?php if($row["active_status"] == "active"): ?>
                  <a href="#" data-toggle="modal" 
                      data-schedule="<?php echo($schedule["schedule_id"]); ?>"
                      data-subject_id="<?php echo($_GET["subject_id"]); ?>"
                      data-teacher="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>"
                      data-grading="first_grading"
                      data-target="#modalUpdateGrades" class="btn btn-warning">Update 1st Grading</a>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if($row["grading_period"] == "second_grading"): ?>
                  <?php if($row["active_status"] == "active"): ?>
                    <a href="#" data-toggle="modal" 
                      data-schedule="<?php echo($schedule["schedule_id"]); ?>"
                      data-subject_id="<?php echo($_GET["subject_id"]); ?>"
                      data-teacher="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>"
                      data-grading="second_grading"
                      data-target="#modalUpdateGrades" class="btn btn-warning">Update 2nd Grading</a>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if($row["grading_period"] == "third_grading"): ?>
                  <?php if($row["active_status"] == "active"): ?>
                    <a href="#" data-toggle="modal" 
                      data-schedule="<?php echo($schedule["schedule_id"]); ?>"
                      data-subject_id="<?php echo($_GET["subject_id"]); ?>"
                      data-teacher="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>"
                      data-grading="third_grading"
                      data-target="#modalUpdateGrades" class="btn btn-warning">Update 3rd Grading</a>
                  <?php endif; ?>
                <?php endif; ?>

                <?php if($row["grading_period"] == "fourth_grading"): ?>
                  <?php if($row["active_status"] == "active"): ?>
                    <a href="#" data-toggle="modal" 
                      data-schedule="<?php echo($schedule["schedule_id"]); ?>"
                      data-subject_id="<?php echo($_GET["subject_id"]); ?>"
                      data-teacher="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>"
                      data-grading="fourth_grading"
                      data-target="#modalUpdateGrades" class="btn btn-warning">Update 4th Grading</a>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endforeach; ?>

              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>1st</th>
                    <th>2nd</th>
                    <th>3rd</th>
                    <th>4th</th>
                    <th>Ave</th>
                    <th>Remarks</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach($grades as $row): ?>
                      <tr>
                        <td><?php echo($row["student_id"]); ?></td>
                        <td><?php echo($row["student_name"]); ?></td>
                        <td><?php echo($row["first_grading"]); ?></td>
                        <td><?php echo($row["second_grading"]); ?></td>
                        <td><?php echo($row["third_grading"]); ?></td>
                        <td><?php echo($row["fourth_grading"]); ?></td>
                        <td><?php echo($row["average"]); ?></td>
                        <td><?php echo($row["remarks"]); ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                 
                </table>
                    <!-- /.post -->
                  </div>
                  <div class="tab-pane" id="timeline">
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Code</th>
                          <th>Subject</th>
                          <th>Teacher</th>
                          <th>Schedule</th>
                        </tr>
                      </thead>
                    <tbody>
                      <?php $schedules = query("select * from schedule s left join subjects sub
                                                on sub.subject_id = s.subject_id
                                                left join teacher t
                                                on s.teacher_id = t.teacher_id
                                                where s.advisory_id = ?
                                                order by from_time asc", $_GET["id"]); ?>

                      <?php foreach($schedules as $row): 
                        
                        $days_string = '';
                        if ($row["monday"] == 1) {
                          $days_string .= 'M,';
                        }
                        if ($row["tuesday"] == 1) {
                          $days_string .= 'T,';
                        }
                        if ($row["wednesday"] == 1) {
                          $days_string .= 'W,';
                        }
                        if ($row["thursday"] == 1) {
                          $days_string .= 'TH,';
                        }
                        if ($row["friday"] == 1) {
                          $days_string .= 'F,';
                        }
                      
                        // Remove the trailing comma
                        $days_string = rtrim($days_string, ',');
                        
                        ?>
                        <tr>
                          <td><?php echo($row["subject_code"]); ?></td>
                          <td><?php echo($row["subject_title"]); ?></td>
                          <td><?php echo($row["teacher_lastname"] . ", " . $row["teacher_firstname"]); ?></td>
                          <td><?php echo($row["from_time"] . " - " . $row["to_time"] . " | " . $days_string); ?></td>
                        </tr>
                      <?php endforeach; ?>
                  
                    </tbody>
              
                </table>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputName" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName2" placeholder="Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                            </label>
                          </div>
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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
  <script src="AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
  <script>

$('.select2').select2({});


$('#modalUpdateGrades').on('show.bs.modal', function (e) {
        var schedule_id = $(e.relatedTarget).data('schedule');
        var teacher_id = $(e.relatedTarget).data('teacher');
        var subject_id = $(e.relatedTarget).data('subject_id');
        var grading = $(e.relatedTarget).data('grading');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'schedule', //Here you will fetch records 
            data: {
              schedule_id: schedule_id,
              teacher_id: teacher_id,
              subject_id: subject_id,
              grading: grading,
               action: "updateGradesModal"
            },
            success : function(data){
                $('#modalUpdateGrades .fetched-data').html(data);
                Swal.close();
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });

$('.exampleDatatable').DataTable({
  "ordering": false,
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