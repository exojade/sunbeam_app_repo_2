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
            <h1>Settings</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php $school_year = query("select * from school_year order by school_year"); ?>
    <?php 
    $first_grading = query("select * from settings where grading_period = 'first_grading'"); 
    $first_grading = $first_grading[0];
    ?>
    <?php $second_grading = query("select * from settings where grading_period = 'second_grading'"); 
    $second_grading = $second_grading[0];
    ?>
    <?php $third_grading = query("select * from settings where grading_period = 'third_grading'"); 
      $third_grading = $third_grading[0];
    ?>
    <?php $fourth_grading = query("select * from settings where grading_period = 'fourth_grading'"); 
    $fourth_grading = $fourth_grading[0];
    ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-8">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">
                  School Year Settings
                </h3>
              </div>
              <div class="card-body">
                <form class="generic_form_trigger" data-url="settings">
                  <input type="hidden" name="action" value="setSchoolYear">
                  <div class="row">
                    <div class="col-8">
                        <select style="width: 100%;" required name="school_year" class="form-control select2">
                          <?php foreach($school_year as $row): ?>
                            <option <?php echo $row["active_status"] == "ACTIVE" ? "selected" : ""; ?> value="<?php echo($row["syid"]); ?>"><?php echo($row["school_year"]); ?></option>
                          <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-4">
                      <button class="btn btn-primary btn-block">Select Active SY</button>
                    </div>
                  </div>
                </form>
                <hr>
                <form class="generic_form_trigger" data-url="settings">
                <input type="hidden" name="action" value="addSchoolYear">
                <div class="row">
                    <div class="col-4">
                        <input required name="fromSY" type="number" class="form-control" placeholder="From School Year">
                    </div>
                    <div class="col-4">
                        <input required name="toSY" type="number" class="form-control" placeholder="To School Year">
                    </div>
                    <div class="col-4">
                      <button class="btn btn-info btn-block">Submit</button>
                    </div>
                  </div>
                </form>
                


                
              </div>
            </div>


            <div class="card">
              <div class="card-header">
              <h3 class="card-title">
                  
                </h3>
              </div>
              <div class="card-body">
                <form class="generic_form_trigger" data-url="settings">
                  <input type="hidden" name="action" value="setGradeSettings">
                  <input type="hidden" name="grading" value="first_grading">
                  <label class="text-uppercase">1st Grading</label>
                  <div class="row">
                    <div class="col-8">
                        <select style="width: 100%;" required name="active_status" class="form-control select2">
                            <option <?php echo $first_grading["active_status"] == "active" ? "selected" : ""; ?> value="active">ACTIVE</option>
                            <option <?php echo $first_grading["active_status"] == "inactive" ? "selected" : ""; ?> value="inactive">INACTIVE</option>
                        </select>
                    </div>
                    <div class="col-4">
                      <button class="btn btn-warning btn-block">Update</button>
                    </div>
                  </div>
                </form>
                <hr>
                <form class="generic_form_trigger" data-url="settings">
                  <input type="hidden" name="action" value="setGradeSettings">
                  <input type="hidden" name="grading" value="second_grading">
                  <label class="text-uppercase">2nd Grading</label>
                  <div class="row">
                    <div class="col-8">
                        <select style="width: 100%;" required name="active_status" class="form-control select2">
                            <option <?php echo $second_grading["active_status"] == "active" ? "selected" : ""; ?> value="active">ACTIVE</option>
                            <option <?php echo $second_grading["active_status"] == "inactive" ? "selected" : ""; ?> value="inactive">INACTIVE</option>
                        </select>
                    </div>
                    <div class="col-4">
                      <button class="btn btn-warning btn-block">Update</button>
                    </div>
                  </div>
                </form>
                <hr>
                <form class="generic_form_trigger" data-url="settings">
                  <input type="hidden" name="action" value="setGradeSettings">
                  <input type="hidden" name="grading" value="third_grading">
                  <label class="text-uppercase">3rd Grading</label>
                  <div class="row">
                    <div class="col-8">
                        <select style="width: 100%;" required name="active_status" class="form-control select2">
                            <option <?php echo $third_grading["active_status"] == "active" ? "selected" : ""; ?> value="active">ACTIVE</option>
                            <option <?php echo $third_grading["active_status"] == "inactive" ? "selected" : ""; ?> value="inactive">INACTIVE</option>
                        </select>
                    </div>
                    <div class="col-4">
                      <button class="btn btn-warning btn-block">Update</button>
                    </div>
                  </div>
                </form>
                <hr>
                <form class="generic_form_trigger" data-url="settings">
                  <input type="hidden" name="action" value="setGradeSettings">
                  <input type="hidden" name="grading" value="fourth_grading">
                  <label class="text-uppercase">4th Grading</label>
                  <div class="row">
                    <div class="col-8">
                        <select style="width: 100%;" required name="active_status" class="form-control select2">
                            <option <?php echo $fourth_grading["active_status"] == "active" ? "selected" : ""; ?> value="active">ACTIVE</option>
                            <option <?php echo $fourth_grading["active_status"] == "inactive" ? "selected" : ""; ?> value="inactive">INACTIVE</option>
                        </select>
                    </div>
                    <div class="col-4">
                      <button class="btn btn-warning btn-block">Update</button>
                    </div>
                  </div>
                </form>
                <hr>
                
              </div>
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

$('#example1').DataTable({
     
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