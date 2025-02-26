<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
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

<?php
$enrollment = query("select * from enrollment where student_id = ? and syid = ?", $_SESSION["sunbeam_app"]["userid"], $sy["syid"]);
?>





<div class="content-wrapper">


    <!-- Content Header (Page header) -->
    <section class="content-header">
    <?php if(empty($enrollment)): ?>
  <div class="alert alert-danger alert-dismissible">
    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
    Currently not Enrolled in this School Year
  </div>


<?php else: 
  
  $student = query("select * from student where student_id = ?", $_SESSION["sunbeam_app"]["userid"]);
  $student = $student[0];
  $advisory = query("select a.*, s.section, 
                      concat(t.teacher_lastname, ', ', t.teacher_firstname) as adviser from advisory a
                      left join section s
                      on s.section_id = a.section_id
                      left join teacher t
                      on t.teacher_id = a.teacher_id
                      where a.advisory_id = ?", $enrollment[0]["advisory_id"]);
  $grades = [];
  if(!empty($advisory)):
    $grades = query("select g.*, concat(t.teacher_lastname, ', ', t.teacher_firstname) as teacher,
    sub.subject_code, sched.*
    from student_grades g
    left join schedule sched
    on sched.schedule_id = g.schedule_id
    left join subjects sub
    on sub.subject_id = sched.subject_id
    left join teacher t
    on t.teacher_id = sched.teacher_id
    where g.student_id = ? and g.advisory_id = ?", $_SESSION["sunbeam_app"]["userid"], $advisory[0]["advisory_id"]);
  $advisory = $advisory[0];
  endif;

  
  ?>
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
     
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">

            <?php if(empty($advisory)): ?>
              <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  You are not yet enrolled to a class. Kindly wait for the administrator to enroll you to an advisory class!
                </div>
            <?php endif; ?>




            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Student Information</h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2 text-center">
                    <img class="profile-user-img img-fluid img-circle"
                       src="resources/default.jpg"
                       alt="User profile picture">
                    </div>
                    <div class="col-md-10">
                    <table class="table" id="sectionTable">
                    <tr>
                      <th>Student Learner ID:</th>
                      <td><?php echo($student["student_id"]); ?></td>
                      <th></th>
                      <td></td>
                    </tr>
                    <tr>
                      <th>Student Name:</th>
                      <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                      <th>Adviser:</th>

                      <?php if(empty($advisory)): ?>
                        <td></td>
                      <?php else: ?>
                        <td><?php echo($advisory["adviser"]); ?></td>
                      <?php endif ?>
                    </tr>
                    <tr>
                      <th>Grade Level:</th>
                      <?php if(empty($advisory)): ?>
                        <td><?php echo($enrollment[0]["grade_level"]); ?></td>
                      <?php else: ?>
                        <td><?php echo($enrollment[0]["grade_level"] . " - " . $advisory["section"]); ?></td>
                      <?php endif ?>
                      
                      <th>School Year:</th>
                      <td><?php echo($sy["school_year"]); ?></td>
                    </tr>
                  </table>
                    </div>
                  </div>
                
                </div>
               
            </div>
              
            </div>
          </div>

          

            <!-- Profile Image -->
         
              <!-- /.card-header -->
                 

                  <hr>
                  <br>
              <!-- /.card-body -->
        
            <!-- /.card -->

            <!-- About Me Box -->
           
     
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Subjects / Grades</a></li>
                  <li class="nav-item"><a class="nav-link" href="#profile" data-toggle="tab">Profile</a></li>
                  <li class="nav-item"><a class="nav-link" href="#soa" data-toggle="tab">Statement of Account</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                    <th>G1</th>
                    <th>G2</th>
                    <th>G3</th>
                    <th>G4</th>
                    <th>Average</th>
                    <th>Remarks</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($grades as $row): 
                    // dump($row);
                    ?>
                    <tr>
                      <td><?php echo($row["subject_code"]); ?></td>
                      <td><?php echo($row["teacher"]); ?></td>
                      <td><?php echo($row["from_time"] . " - " . $row["to_time"]); ?></td>
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
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="profile">


                  <table class="table" id="sectionTable">
                 
                    <tr>
                      <th>Student Name:</th>
                      <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                      <th>Grade Level:</th>
                      <td><?php echo($enrollment[0]["grade_level"]); ?></td>
                    </tr>
                    <tr>
                      <th>Address:</th>
                      <td><?php echo($student["province"] . " , " . $student["city_mun"] . " , " . $student["barangay"] . " , " . $student["address"]); ?></td>
                      <th>Sex:</th>
                      <td><?php echo($student["sex"]); ?></td>
                    </tr>
                    <tr>
                      <th>Birth Date:</th>
                      <td><?php echo($student["birthDate"]); ?></td>
                      <th>Birth Place:</th>
                      <td><?php echo($student["birthPlace"]); ?></td>
                    </tr>
                    <tr>
                      <th>Religion:</th>
                      <td><?php echo($student["religion"]); ?></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Father:</th>
                      <td><?php echo($student["father_lastname"] . ", " . $student["father_firstname"]); ?></td>
                      <th>Contact / FB:</th>
                      <td><?php echo($student["father_contact"] . " / " . $student["father_fb"]); ?></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><?php echo($student["father_occupation"]); ?></td>
                      <th>Educational Attainment:</th>
                      <td><?php echo($student["father_education"]); ?></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Mother:</th>
                      <td><?php echo($student["mother_lastname"] . ", " . $student["mother_firstname"]); ?></td>
                      <th>Contact / FB:</th>
                      <td><?php echo($student["mother_contact"] . " / " . $student["mother_fb"]); ?></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><?php echo($student["mother_occupation"]); ?></td>
                      <th>Educational Attainment:</th>
                      <td><?php echo($student["mother_education"]); ?></td>
                    </tr>
                  </table>
                  <hr>
                  </div>
                  <div class="tab-pane" id="soa">
                  <form class="generic_form_trigger" data-url="enrollment">
                          <input type="hidden" name="action" value="printSOA">
                          <input type="hidden" name="enrollment_id" value="<?php echo($enrollment[0]["enrollment_id"]); ?>">
                          <button type="submit"class="btn btn-info">Print Statement of Account</button>
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

      <?php endif; ?>
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

$('.exampleDatatable').DataTable({
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