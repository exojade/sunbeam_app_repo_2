<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
     
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="modal fade" id="addSection">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Section</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="generic_form_files_trigger" role="form" enctype="multipart/form-data" data-url="subjects">
              <input type="hidden" name="action" value="addSubject">
              <div class="form-group">
                <label for="exampleInputEmail1">Section Name</label>
                <input required type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="---">
              </div>

             


              <div class="form-group">
                <label for="exampleInputEmail1">Adviser</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Select Adviser Here!</option>
                  <option value="Mr. Tanggol Cardo">Mr. Tanggol Cardo</option>
                  <option value="Mr. Tanggol Cardo">Mr. Ross Geller</option>
                  <option value="Mr. Tanggol Cardo">Mr. Chandler Bing</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">Grade Level</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Please Grade Level</option>
                  <option value="Grade 1">Grade 1</option>
                  <option value="Grade 1">Grade 2</option>
                  <option value="Grade 1">Grade 3</option>
                  <option value="Grade 1">Grade 4</option>
                  <option value="Grade 1">Grade 5</option>
                  <option value="Grade 1">Grade 6</option>
                </select>
              </div>

              <div class="form-group">
                <label for="exampleInputEmail1">School Year</label>
                <select required name="gender" class="form-control select2">
                  <option selected disabled value="">Select School Year Here!</option>
                  <option value="2023-2024">2023-2024</option>
                  
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



      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

            <!-- Profile Image -->
         
              <!-- /.card-header -->
                  <table class="table" id="sectionTable">
                    <tr>
                      <th>Section:</th>
                      <td>SAMPLE SECTION NAME</td>
                      <th>Adviser:</th>
                      <td>Victor Magtanggol</td>
                    </tr>
                    <tr>
                      <th>Grade Level:</th>
                      <td>Grade 1</td>
                      <th>School Year:</th>
                      <td>2023-2024</td>
                    </tr>
                  </table>

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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Students</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Classroom Schedule</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="15%">Action</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>2020-1540</td>
                      <td>BON S. JOVI</td>
                    </tr>
                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>2020-1541</td>
                      <td>ILLEST J. MORENA</td>
                    </tr>
                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>2020-1542</td>
                      <td>SKUSTA D. CLEE</td>
                    </tr>
                   
                
                 
                  </tbody>
                  <tfoot>
                  <tr>
                  <th >Action</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                  </tr>
                  </tfoot>
                </table>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->
                    <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th width="15%">Action</th>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Teacher</th>
                    <th>Schedule</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>SUB2010-501</td>
                      <td>Math 1</td>
                      <td>Introduction to Algebra</td>
                      <td>Mr. Victor T. Magtanggol</td>
                      <td>07:30 - 08:30 AM</td>
                    </tr>
                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>SUB2010-502</td>
                      <td>Eng 1</td>
                      <td>Introduction to English</td>
                      <td>Ms. Cynthia Soliman</td>
                      <td>08:30 - 09:30 AM</td>
                    </tr>

                    <tr>
                      <td>
                        <a href="section?action=specific" class="btn btn-danger btn-sm ">Remove</a>
                        <a href="section?action=specific" class="btn btn-info btn-sm ">Visit</a>
                      </td>
                      <td>SUB2010-503</td>
                      <td>FIL 1</td>
                      <td>Filipino to the Moon</td>
                      <td>Ms. Brenda Mage</td>
                      <td>09:30 - 10:30 AM</td>
                    </tr>
                   
                  
                
                   
                 
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
  <script>

$('.exampleDatatable').DataTable({
     
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