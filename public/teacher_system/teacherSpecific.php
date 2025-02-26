<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


<?php

$teacher = query("select * from teacher where teacher_id = ?", $_GET["id"]);
$teacher = $teacher[0];

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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Teacher's Details</h1>
          </div>
     
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        

      <div class="modal fade" id="modalViewSchedule">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-primary">
					    <h3 class="modal-title text-center">Schedule Details</h3>
              </div>
            <div class="modal-body">
              <div class="fetched-data"></div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modalEditTeacher">
        <div class="modal-dialog modal-xl modal-dialog-centered">
          <div class="modal-content">
          <div class="modal-header bg-warning">
					    <h3 class="modal-title text-center">Edit Teacher's Profile</h3>
              </div>
            <div class="modal-body">

            <form class="generic_form_trigger" data-title="Edit Teacher" data-message="You are almost done! Are you sure you want to edit information of this teacher?" data-url="teacher">
                <input type="hidden" name="action" value="teacherEdit">
                <input type="hidden" name="teacher_id" value="<?php echo($_GET["id"]); ?>">
                <input type="hidden" name="region" id="true_region" value="<?php echo($teacher["teacher_region"]); ?>">
                  <input type="hidden" name="province" id="true_province" value="<?php echo($teacher["teacher_province"]); ?>">
                  <input type="hidden" name="cityMun" id="true_city_mun" value="<?php echo($teacher["teacher_citymun"]); ?>">
                  <input type="hidden" name="barangay" id="true_barangay" value="<?php echo($teacher["teacher_barangay"]); ?>">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">First Name <span class="text-danger">*</span></label>
                        <input required value="<?php echo($teacher["teacher_firstname"]); ?>" type="text" name="teacher_firstname" class="form-control" id="exampleInputEmail1" placeholder="First Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Middle Name</label>
                        <input  type="text" value="<?php echo($teacher["teacher_middlename"]); ?>" value="" name="teacher_middlename" class="form-control" id="exampleInputEmail1" placeholder="Middle Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Last Name <span class="text-danger">*</span></label>
                        <input required type="text" value="<?php echo($teacher["teacher_lastname"]); ?>" name="teacher_lastname" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Name Extension</label>
                        <input  type="text" value="<?php echo($teacher["teacher_extension"]); ?>" name="teacher_extension" class="form-control" id="exampleInputEmail1" placeholder="Ex. I, II, III, Jr. Sr.">
                      </div>
                    </div>
                  </div>

                  <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Region <span class="text-danger">*</span></label>
                              <select style="width:100%;" required class="form-control select2" id="region_select">
                                  <option selected value="<?php echo($teacher["teacher_region"]); ?>"><?php echo($teacher["teacher_region"]); ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Province <span class="text-danger">*</span></label>
                              <select style="width:100%;" required class="form-control select2" id="province_select">
                                <option selected value="<?php echo($teacher["teacher_province"]); ?>"><?php echo($teacher["teacher_province"]); ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">City | Municipality <span class="text-danger">*</span></label>
                              <select style="width:100%;" required class="form-control select2" id="city_mun_select">
                              <option selected value="<?php echo($teacher["teacher_citymun"]); ?>"><?php echo($teacher["teacher_citymun"]); ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleInputEmail1">Barangay <span class="text-danger">*</span></label>
                              <select style="width:100%;" required class="form-control select2" id="barangay_select">
                              <option selected value="<?php echo($teacher["teacher_barangay"]); ?>"><?php echo($teacher["teacher_barangay"]); ?></option>
                              </select>
                            </div>
                          </div>
                      </div>
                  
                      <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Street / House Number / Purok <span class="text-danger">*</span></label>
                              <input value="<?php echo($teacher["teacher_address"]); ?>" name="teacher_address" required type="text" class="form-control"  placeholder="Street / House Number / Purok">
                            </div>
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Birthdate <span class="text-danger">*</span></label>
                              <input  max="<?php echo date('Y-m-d'); ?>" value="<?php echo($teacher["teacher_birthdate"]); ?>" name="teacher_birthdate" required type="date" class="form-control"  placeholder="Birthdate">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Sex <span class="text-danger">*</span></label>
                              <select required name="teacher_gender" class="form-control select2" >
                                <option  selected value="<?php echo($teacher["teacher_gender"]); ?>"><?php echo($teacher["teacher_gender"]); ?></option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                              </select>
                            </div>
                          </div>

                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Contact Number <span class="text-danger">*</span></label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input name="teacher_contactNumber" value="<?php echo($teacher["teacher_contactNumber"]); ?>" required type="text" class="form-control" data-inputmask='"mask": "(+63) 9999999999"' data-mask>
                              </div>
                              <!-- /.input group -->
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Email Address (this will serve as username on the system) <span class="text-danger">*</span></label>
                              <input value="<?php echo($teacher["teacher_emailaddress"]); ?>" name="teacher_emailaddress" required type="email" class="form-control"  placeholder="---">
                            </div>
                          </div>


                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Undergraduate Course <span class="text-danger">*</span></label>
                              <input  value="<?php echo($teacher["college_course"]); ?>" name="college_course" required type="text" class="form-control"  placeholder="Ex. BS in Eduation">
                            </div>
                          </div>


                          <div class="col-md-6">
                          <div class="form-group">
                              <label>Postgraduate Course</label>
                              <input value="<?php echo($teacher["post_graduate_course"]); ?>" name="post_graduate_course" type="text" class="form-control"  placeholder="Ex. Masters in Education">
                            </div>
                          </div>

                          <div class="col-md-12">
                            
                          <div class="form-group">
                    <!-- <label for="customFile">Custom File</label> -->
                    <label>Profile Image</label>
                    <div class="custom-file">
                      <input accept="image/*" type="file" name="profileImage" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                  </div>
                          </div>



                      </div>
                      <hr>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>




            
              
            </div>
         
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>



        <div class="row">
          <div class="col-md-12">
              <div class="card card-info">
              <div class="card-header p-2">
              <h3 class="card-title">Teacher's Information</h3>
              </div>
              <div class="card-body">
                  <div class="row">
                    <div class="col-md-2 text-center">
                    <img style="width: 120px; height:120px;" class="profile-user-img img-fluid img-circle"
                      src="<?php echo !empty($teacher['teacher_profile']) ? $teacher['teacher_profile'] : 'resources/default.jpg'; ?>"
                      alt="User profile picture">
                    <a href="#" data-toggle="modal" data-target="#modalEditTeacher" class="btn btn-warning btn-sm btn-block mt-2">Edit Info</a>
                    </div>
                    <div class="col-md-10">
                    <table class="table" id="sectionTable">
                    <tr>
                      <th>Teacher's Code:</th>
                      <td><?php echo($teacher["teacher_id"]); ?></td>
                    </tr>
                    <tr>
                      <th>Teacher's Name:</th>
                      <td><?php echo($teacher["teacher_firstname"] . " " . $teacher["teacher_middlename"] . " " . $teacher["teacher_lastname"] . " " . $teacher["teacher_extension"]); ?></td>
                      <th>Address:</th>
                      <td><?php echo($teacher["teacher_citymun"] . ", " . $teacher["teacher_barangay"] . ", " . $teacher["teacher_address"]); ?></td>
                    </tr>
                    <tr>
                      <th>Birth Date:</th>
                      <td><?php echo($teacher["teacher_birthdate"]); ?></td>
                      <th>Gender:</th>
                      <td><?php echo($teacher["teacher_gender"]); ?></td>
                    </tr>
                    <tr>
                      <th>Undergraduate Course:</th>
                      <td><?php echo($teacher["college_course"]); ?></td>
                      <th>Post Graduate Course:</th>
                      <td><?php echo($teacher["post_graduate_course"]); ?></td>
                    </tr>
                    <tr>
                      <th>Contact Number:</th>
                      <td><?php echo($teacher["teacher_contactNumber"]); ?></td>
                      <th>Username:</th>
                      <td><?php echo($teacher["teacher_emailaddress"]); ?></td>
                    </tr>
                  </table>
                    </div>
                  </div>
                </div>
                </div>
                  <hr>
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Class Handled</a></li>
                  <li class="nav-item"><a class="nav-link" href="#history" data-toggle="tab">Subjects Handled</a></li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">

                  <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                  <?php $school_year = query("select * from school_year order by school_year desc"); ?>
                  
                  <select style="width:100%;" name="enrollment_id" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                    <option value="" selected disabled>Filter School Year</option>
                    <?php foreach($school_year as $sy): ?>
                      <option value="<?php echo($sy["syid"]); ?>"><?php echo($sy["school_year"]); ?></option>
                    <?php endforeach;?>
                  </select>
                  </div>
                    </div>
                  </div>
                    <table id="mySectionDatatable" class="table  table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Class</th>
                    <th>School Year</th>
                    <th>Male</th>
                    <th>Female</th>
                  </tr>
                  </thead>
                  <!-- <tbody></tbody> -->
                </table>
                  </div>
                  <div class="tab-pane" id="profile">
                  </div>
                  <div class="tab-pane" id="history">
                  <div class="row">
                    <div class="col-md-4">
                    <div class="form-group">
                  <?php $school_year = query("select * from school_year order by school_year desc"); ?>
                  
                  <select style="width:100%;" name="enrollment_id" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                    <option value="" selected disabled>Filter School Year</option>
                    <?php foreach($school_year as $sy): ?>
                      <option value="<?php echo($sy["syid"]); ?>"><?php echo($sy["school_year"]); ?></option>
                    <?php endforeach;?>
                  </select>
                  </div>
                    </div>
                  </div>
                  <table id="mySubjectsDatatable" style="width:100%;" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Action</th>
                        <th>Subject</th>
                        <th>Description</th>
                        <th>Level</th>
                        <th>School Year</th>
                        <th>Schedule</th>
                      </tr>
                    </thead>
                  </table>
                  </div>
                  <!-- /.tab-pane -->
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
  <script src="AdminLTE_new/plugins/inputmask/jquery.inputmask.min.js"></script>
<script type="text/javascript" src="node_modules/philippine-location-json-for-geer/build/phil.min.js"></script>
<script src="AdminLTE_new/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
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

<script>
$(function () {
  bsCustomFileInput.init();
});


var datatable = 
            $('#mySectionDatatable').DataTable({
                "searching": false,
                "pageLength": 9999,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": false,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                
                'ajax': {
                    'url':'teacher',
                     'type': "POST",
                     "data": function (data){
                        data.action = "teacherClassList",
                        data.teacher_id = '<?php echo($_GET["id"]) ?>'
                     }
                },
                'columns': [
                  { data: 'action', "orderable": false  },
                  { data: 'class_section', "orderable": false  },
                  { data: 'school_year', "orderable": false  },
                  { data: 'male_count', "orderable": false  },
                  { data: 'female_count', "orderable": false  },
                ],
                "footerCallback": function (row, data, start, end, display) {

}
            });


            var datatable2 = 
            $('#mySubjectsDatatable').DataTable({
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
                    'url':'teacher',
                     'type': "POST",
                     "data": function (data){
                        data.action = "teacherSubjectList",
                        data.teacher_id = '<?php echo($_GET["id"]) ?>'
                     }
                },
                'columns': [
                  { data: 'action', "orderable": false  },
                  { data: 'subject_head_name', "orderable": false  },
                  { data: 'subject_title', "orderable": false  },
                  { data: 'class', "orderable": false  },
                  { data: 'school_year', "orderable": false  },
                  { data: 'schedule', "orderable": false  },
                ],
                "footerCallback": function (row, data, start, end, display) {

}
            });


      $('#modalViewSchedule').on('show.bs.modal', function (e) {
        var schedule_id = $(e.relatedTarget).data('schedule_id');
        var subject_id = $(e.relatedTarget).data('subject_id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'teacher', //Here you will fetch records 
            data: {
               schedule_id: schedule_id,
               subject_id: subject_id,
               action: "modalScheduleDetails"
            },
            success : function(data){
                $('#modalViewSchedule .fetched-data').html(data);
                Swal.close();
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });


     $('#modalEditTeacher').on('show.bs.modal', function (e) {
        var teacher_id = $(e.relatedTarget).data('teacher_id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'teacher', //Here you will fetch records 
            data: {
              teacher_id: teacher_id,
               action: "modalEditTeacher"
            },
            success : function(data){
                $('#modalEditTeacher .fetched-data').html(data);
                Swal.close();
                // $(".select2").select2();//Show fetched data from database
            }
        });
     });


     $('[data-mask]').inputmask()
    $('#region_select').select2({
      placeholder: 'Please select Region'
    });
    $('#province_select').select2({
      placeholder: 'Please select Province'
    });

    $('#city_mun_select').select2({
      placeholder: 'Please select City / Municipality'
    });

    $('#barangay_select').select2({
      placeholder: 'Please select Barangay'
    });
    


    
    var selectedRegion = '';
    var selectedCity = '';
  
    var all_region = Philippines.sort(Philippines.regions,"A");
    <?php if($teacher["teacher_region"] != ""): ?>
      html = "<option value='<?php echo($teacher["teacher_region"]); ?>' selected><?php echo($teacher["teacher_region"]); ?></option>";
    <?php else: ?>
      html = "<option value='' disabled selected></option>";
    <?php endif; ?>
    for(var key in all_region) {
      // console.log(all_province[key].name);
        html += "<option value=" + all_region[key].reg_code  + ">" +all_region[key].name + "</option>";
        html += "<option value=" + all_region[key].reg_code  + ">" +all_region[key].name + "</option>";
    }
    document.getElementById("region_select").innerHTML = html;





  $('#region_select').change(function(){
    $('#true_region').val($( "#region_select option:selected" ).text());
    province = Philippines.getProvincesByRegion($(this).val(), 'A');
    selectedRegion = $(this).val();
    html = "<option value='' disabled selected></option>";
    for(var key in province) {
      // console.log(city_mun[key].name);
        html += "<option value=" + province[key].prov_code  + ">" +province[key].name + "</option>"
    }
    document.getElementById("province_select").innerHTML = html;
});




$('#province_select').change(function(){
    $('#true_province').val($( "#province_select option:selected" ).text());
    city_mun = Philippines.getCityMunByProvince($(this).val(), 'A');
    html = "<option value='' disabled selected></option>";
    for(var key in city_mun) {
      // console.log(city_mun[key].name);
        html += "<option value=" + city_mun[key].mun_code  + ">" +city_mun[key].name + "</option>"
    }
    document.getElementById("city_mun_select").innerHTML = html;
});


$('#city_mun_select').change(function(){
    $('#true_city_mun').val($( "#city_mun_select option:selected" ).text());
    barangay = Philippines.getBarangayByMun($(this).val(), 'A');
    html = "<option value='' disabled selected></option>";
    for(var key in barangay) {
      // console.log(city_mun[key].name);
        html += "<option value=" + barangay[key].mun_code  + ">" +barangay[key].name + "</option>"
    }
    document.getElementById("barangay_select").innerHTML = html;
  

    // console.log(Philippines.getZipCode(selectedRegion, selectedProvince));
});

$('#barangay_select').change(function(){
    $('#true_barangay').val($( "#barangay_select option:selected" ).text());

});



            // modalViewSchedule

</script>


  <?php require("layouts/footer.php") ?>