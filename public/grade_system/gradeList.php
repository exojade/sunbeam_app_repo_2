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
      <div class="container-fluid">


      <div class="modal fade" id="modalPayment">
        <div class="modal-dialog ">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Payment</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="generic_form_files_trigger" role="form" enctype="multipart/form-data" data-url="subjects">
              <div class="form-group">
                    <label for="exampleInputEmail1">Balance</label>
                    <input type="text" readonly value="13,760.00" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>

              <div class="form-group">
                    <label for="exampleInputEmail1">Date</label>
                    <input type="date" readonly value="<?php echo(date("Y-m-d")); ?>" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">OR Number</label>
                    <input type="text"  class="form-control" id="exampleInputEmail1" placeholder="---">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Amount</label>
                    <input type="text"  class="form-control" id="exampleInputEmail1" placeholder="0.00">
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
          <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Subject Information</h3>
              </div>
              <!-- /.card-header -->
              
              <!-- form start -->
                <div class="card-body">
                  <div class="row">
                    <!-- <div class="col-md-2 text-center">
                    <img class="profile-user-img img-fluid img-circle"
                       src="resources/default.jpg"
                       alt="User profile picture">
                    </div> -->
                    <div class="col-md-12">
                    <table class="table" id="sectionTable">
                    <tr>
                      <th>Subject Code:</th>
                      <td>Math 1</td>
                      <th>Description:</th>
                      <td>Intro to Geometry</td>
                    </tr>
                    <tr>
                      <th>Grade Level:</th>
                      <td>Grade 3</td>
                      <th>School Year:</th>
                      <td>2023-2024</td>
                    </tr>
                    <tr>
                      <th>Section:</th>
                      <td>Section Apple</td>
                      <th>Schedule:</th>
                      <td>09:30 - 10:30 AM</td>
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
                 

         
              <!-- /.card-body -->
        
            <!-- /.card -->

            <!-- About Me Box -->
           
     
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Students</a></li> -->
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Students</a></li>
                  <!-- <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Record History</a></li>
                  <li class="nav-item"><a class="nav-link" href="#soa" data-toggle="tab">Statement of Account</a></li> -->
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Student Name</th>
                    <th>Q1</th>
                    <th>Q2</th>
                    <th>Q3</th>
                    <th>Q4</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>ST2020-091XN</td>
                      <td>Illest J. Morena</td>
                      <td>95</td>
                      <td><a class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;93</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>ST2020-092XN</td>
                      <td>Skusta J. Clee</td>
                      <td>92</td>
                      <td><a class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;93</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>ST2020-090XN</td>
                      <td>Jessie McCartney</td>
                      <td>92</td>
                      <td><a class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;</td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
              
                </table>
                    <!-- /.post -->
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="history">
                    <!-- The timeline -->
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Code</th>
                    <th>Subject</th>
                    <th>Description</th>
                    <th>Level</th>
                    <th>SY</th>
                    <th>Final Grade</th>
                  </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>SUB2010-101</td>
                      <td>Eng101</td>
                      <td>Grammars</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>99</td>
                    </tr>
                    <tr>
                      <td>SUB2010-102</td>
                      <td>CIV01</td>
                      <td>History of the Philippines</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>94</td>
                    </tr>
                    <tr>
                      <td>SUB2010-103</td>
                      <td>PE1</td>
                      <td>Chess</td>
                      <td>Grade 1</td>
                      <td>2022-2023</td>
                      <td>99</td>
                    </tr>
               

           
                  
                
                   
                 
                  </tbody>
              
                </table>
                  </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="soa">

                  <div class="row">
                    <div class="col-md-3">
                    <div class="form-group">
                        <select required name="gender" class="form-control select2">
                          <option selected disabled value="">Filter School Year</option>
                          <option value="">2023-2024</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5">
                    
                    </div>
                    <div class="col-md-4">
                    <div class="form-group">
                        <a href="#" data-toggle="modal" data-target="#modalPayment" class="btn btn-info ">Add Payment</a>
                        <a href="#" data-toggle="modal" data-target="modalPayment" class="btn btn-success ">View SoA</a>
                      </div>
                    </div>
                  </div>
                    
                  <table id="" class="table exampleDatatable table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Date Paid</th>
                    <th>OR #</th>
                    <th>Amount</th>
                    <th>Balance</th>
                  </tr>
                  </thead>
                  <tbody>
                   
                    <tr>
                      <td>06/01/2023</td>
                      <td>#01011</td>
                      <td class="text-right">2,150.00</td>
                      <td class="text-right">13,760.00</td>
                    </tr>
                  
               

           
                  
                
                   
                 
                  </tbody>
              
                </table>
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