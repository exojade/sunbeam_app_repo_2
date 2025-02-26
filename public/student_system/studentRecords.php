<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/toastr/toastr.min.css">


  
<style>
  /* #sectionTable td{
    border: 0px;
    padding: 5px 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 5px 0px;
  } */


  #advisorySection td{
    border: 0px;
    padding: 0px;
  }
  #advisorySection th{
    border: 0px;
    padding: 0px;
  }
</style>
<div class="content-wrapper">






<div class="modal fade" id="newForm137Modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">New Form 137</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="CaptureForm137" class="generic_form_trigger" data-url="student">
                <input type="hidden" name="action" value="captureForm137">
                <input type="hidden" name="student_id" value="<?php echo($_GET["id"]); ?>">

                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_name" placeholder="Enter School Name">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_id" placeholder="Enter School ID">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_district" placeholder="Enter District">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_division" placeholder="Enter Division">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_region" placeholder="Enter Region">
                    </div>
                  </div>
                </div>

                <hr>
                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="grade_level" placeholder="Enter Grade Level">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="section" placeholder="Enter Section">
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="school_year" data-inputmask='"mask": "9999-9999"'data-mask placeholder="SY. Ex. 2023-2024">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <input required type="text" class="form-control" name="adviser_name" placeholder="Enter Adviser Name">
                    </div>
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




      <div class="modal fade" id="updateGradesModal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header bg-success">
              <h4 class="modal-title">Update Grades</h4>
            </div>
            <div class="modal-body">
              <form class="generic_form_trigger" data-title="Update Grade" data-message="Are you sure you want to change the grade of your student?" data-url="student">
                <input type="hidden" name="action" value="updateAllGrades">
                  <div class="fetched-data"></div>
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


      <div class="modal fade" id="updateRequirementsModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h4 class="modal-title">Update Requirements</h4>
            </div>
            <div class="modal-body">
              <form class="generic_form_trigger" data-url="student">
                <input type="hidden" name="action" value="updateRequirements">
                <input type="hidden" name="student_id" value="<?php echo($_GET["id"]); ?>">
              <div class="fetched-data"></div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Save changes</button>
            </div>
          </form>
          </div>
        </div>
      </div>



















<?php
// $enrollment = query("select e.*, s.section from 
//                         enrollment e left join advisory a
//                         on a.advisory_id = e.advisory_id
//                         left join section s
//                         on s.section_id = a.section_id
//                       where e.enrollment_id = ?", $_GET["id"]);
// $enrollment = $enrollment[0];

$student = query("select s.*, sy.school_year, e.grade_level, e.status as enrollment_status from student s
                        left join enrollment e
                        on e.enrollment_id = s.current_enrollment_id
                        left join school_year sy
                        on sy.syid = e.syid
                        where s.student_id = ?", $_GET["id"]);
                        $student = $student[0];

$StudentEnrollment = query("select * from enrollment where student_id = ?", $_GET["id"]);
// dump($school_year[0]);
$boolEnrolled = 0;
$theStatus = "";
foreach($StudentEnrollment as $s):
  if($s["syid"] == $school_year[0]["syid"]):
    $boolEnrolled = 1;
    $theStatus = $s["status"];
  endif;
endforeach;


// if($student["school_year"] == ):
//   if($student["enrollment_status"] == 'ENROLLED'):
//     $boolEnrolled = 1;
//   endif;
// endif;

$enrollment = query("select * from enrollment e
                    left join advisory a
                    on a.advisory_id = e.advisory_id
                    left join section s
                    on s.section_id = a.section_id
                    where e.enrollment_id = ?", $student["current_enrollment_id"]);
if(!empty($enrollment))
$enrollment = $enrollment[0];


$enrollmentList = query("select e.*, sy.school_year from enrollment e
                          left join school_year sy
                          on sy.syid = e.syid
                          where student_id = ?
                          order by sy.school_year desc
                          ", $_GET["id"]);


?>


    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
          <?php if($boolEnrolled == 0): ?>
          <div class="alert alert-warning alert-block">
            <h5><i class="icon fas fa-ban"></i> Alert!</h5>
            Student Not Enrolled in this School Year
          </div>

          <?php else: ?>
            <?php if($theStatus == "PENDING"): ?>
              <div class="alert alert-warning alert-block">
                <h5><i class="icon fas fa-ban"></i> PENDING !</h5>
              </div>
              <?php elseif($theStatus == "ENROLLED"): ?>
                <div class="alert alert-primary alert-block">
                <h5><i class="icon fas fa-check"></i> ENROLLED !</h5>
              </div>
              <?php elseif($theStatus == "CANCELLED"): ?>
                <div class="alert alert-danger alert-block">
                <h5><i class="icon fas fa-close"></i> CANCELLED !</h5>
              </div>
              <?php endif; ?>

          <?php endif; ?>
            <!-- Profile Image -->




            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Student Info</h3>
              </div>
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="AdminLTE_new/dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo($student["lastname"].", ".$student["firstname"]); ?></h3>

                <p class="text-muted text-center"><?php echo($student["student_id"]); ?></p>

                <hr>

             

                <?php if(!empty($enrollment)): ?>
                  <div class="text-center">

                    <strong> Grade Level</strong>
                    <p class="text-muted">
                      <?php echo($enrollment["grade_level"]); ?>
                    </p>
                    <strong> Section</strong>
                    <p class="text-muted">
                      <?php echo($enrollment["section"]); ?>
                    </p>
                  </div>
                <?php endif; ?>
                



              </div>
            </div>
            <form class="generic_form_trigger mb-3" data-url="form137" data-title="Print Form 137" data-message="Are you sure you want to download and print the Form 137?">
              <input type="hidden" name="action" value="printForm137">
              <input type="hidden" name="student_id" value="<?php echo($_GET["id"]); ?>">
              <button type="submit" class="btn btn-info btn-block">Print Form 137</button>
            </form>


            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Requirements</h3>
              </div>
              <!-- /.card-header -->
              <!-- <style>
                #reqTable tbody td {
                  font-size: 15px !important;
                }
              </style> -->
              <table id="reqTable" class="table table-bordered">
                <tbody>
                  <?php $requirements = query("select * from enrollment_requirements where student_id = ?", $_GET["id"]); ?>
                  <?php foreach($requirements as $row): ?>
                    <tr>
                      <td><b><?php echo($row["document_name"]); ?></b></td>
                      <?php if($row["status"] == "NOT APPLICABLE"):
                              $row["status"] = "N/A";
                            elseif($row["status"] == "YES"):
                              $row["status"] = '<i class="fa fa-check"></i>';
                            else:
                              $row["status"] = '<i class="fa fa-times"></i>';
                            endif; ?>
                      <td class="text-right"><?php echo($row["status"]); ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"><a href="#" data-id="<?php echo($_GET["id"]); ?>" data-toggle="modal" data-target="#updateRequirementsModal" class="btn btn-warning btn-block">Update Requirements</a></td>
                  </tr>
                </tfoot>

              </table>
              <!-- /.card-body -->

              <?php if($student["grade_settings"] == "ACTIVE"): ?>
              <form class="generic_form_trigger" data-url="student" data-title="Grade Viewing" data-message="Are you sure you want to disable grade viewing? The parent will not be able to view the grade of the child.">
                <input type="hidden" name="action" value="updateGradeSettings">
                <input type="hidden" name="trigger" value="disable">
                <input type="hidden" name="student_id" value="<?php echo($student["student_id"]); ?>">
                <button class="btn btn-block btn-danger">Disable Grade Viewing</button>

              </form>

              <?php else: ?>

                <form class="generic_form_trigger" data-url="student" data-title="Grade Viewing" data-message="Are you sure you want to enable grade viewing? The parent will be able to view the grade of the child.">
                <input type="hidden" name="action" value="updateGradeSettings">
                <input type="hidden" name="trigger" value="enable">
                <input type="hidden" name="student_id" value="<?php echo($student["student_id"]); ?>">
                <button class="btn btn-block btn-success">Enable Grade Viewing</button>

              </form>
              <?php endif; ?>

            </div>








          </div>


      
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#profile" data-toggle="tab">Profile Info</a></li>
                  <li class="nav-item"><a class="nav-link " href="#grades" data-toggle="tab">Grades</a></li>
                  <li class="nav-item"><a class="nav-link " href="#payment_history" data-toggle="tab">Payment History</a></li>
                  <li class="nav-item"><a class="nav-link " href="#form137" data-toggle="tab">Capture Form 137</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="profile">


                  <div class="row">
                    <div class="col-12">
                    <div id="pds_elig">
                      <div id="form_pds_elig" class="ui tiny form">
                        <!-- <button @click="goUpdate" class="btn btn-primary btn-sm btn_pds_elig_update"><i class="fa fa-edit"></i> Update</button>
                        <div class="btns_pds_elig_update btn-group" style="display:none">
                            <button @click="goSave" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                <div class="or"></div>
                            <button @click="goCancel" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Discard</button>
                        </div>
                        <br>
                        <br> -->
                    <table class="table table-bordered" id="sectionTable">
                 
                    <tr>
                      <th>Student Code:</th>
                      <td colspan="3"><input readonly v-model="student.student_id" type="text" class="form-control form-control-border"></td>
                    </tr>
                    <tr>
                      <th width="15%">Student Name:</th>
                      <td colspan="3">
                        <div class="row">
                            <div class="col">
                              <input placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.lastname" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.firstname" type="text" class="form-control form-control-border">
                            </div> 
                            <div class="col"> 
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Middle Name" :readonly = "readonly" :required="!readonly" v-model="student.middlename" type="text" class="form-control form-control-border">
                            </div> 
                            <div class="col"> 
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Name Extension" :readonly = "readonly" :required="!readonly" v-model="student.name_extension" type="text" class="form-control form-control-border">
                            </div>
                        </div>
                      </td>
                    </tr>
                    
                    <tr>
                      <th>Birth Date:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Birth Date" :readonly = "readonly" :required="!readonly" v-model="student.birthDate" type="date" class="form-control form-control-border"></td>
                      <th>Birth Place:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Birth Place" :readonly = "readonly" :required="!readonly" v-model="student.birthPlace" type="text" class="form-control form-control-border"></td>
                    </tr>
                    <tr>
                      <th>Religion:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Religion" :readonly = "readonly" :required="!readonly" v-model="student.religion" type="text" class="form-control form-control-border"></td>
                      <th>Sex:</th>
                      <td><select 
                            v-bind:class="{ editState: !readonly, readOnly: readonly }" 
                            :disabled="readonly" 
                            :required="!readonly" 
                            v-model="student.sex" 
                            class="custom-select form-control-border" 
                          >
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select></td>
                    </tr>
                    <tr>
                      <th>Address:</th>
                      <td colspan="3">
                      <div class="row">

<div class="col">
<div class="form-group">
<select 
v-bind:class="{ editState: !readonly, readOnly: readonly }" 
:disabled="readonly" 
v-model="student.region" 
@change="updateProvinces" 
class="custom-select form-control-border"
>
<option value="" disabled>Select a region</option>
<option v-for="region in regions" :key="region.reg_code" :value="region.reg_code">{{ region.name }}</option>
</select>
</div>
</div>

<div class="col">
<div class="form-group">
<select 
v-bind:class="{ editState: !readonly, readOnly: readonly }" 
:disabled="readonly" 
v-model="student.province" 
@change="updateCities" 
class="custom-select form-control-border"
>
<option value="" disabled>Select a province</option>
<option v-for="province in provinces" :key="province.prov_code" :value="province.prov_code">{{ province.name }}</option>
</select>
</div>
</div>

<div class="col">
<div class="form-group">
<select 
v-bind:class="{ editState: !readonly, readOnly: readonly }" 
:disabled="readonly || !cities.length" 
v-model="student.city_mun" 
@change="updateBarangays" 
class="custom-select form-control-border"
>
<option value="" disabled>Select a city/municipality</option>
<option v-for="city in cities" :key="city.mun_code" :value="city.mun_code">{{ city.name }}</option>
</select>
</div>
</div>

<div class="col">
<div class="form-group">
<select 
v-bind:class="{ editState: !readonly, readOnly: readonly }" 
:disabled="readonly || !barangays.length" 
v-model="student.barangay" 
class="custom-select form-control-border"
>
<option value="" disabled>Select a barangay</option>
<option v-for="barangay in barangays" :key="barangay.mun_code" :value="barangay.name">{{ barangay.name }}</option>
</select>
</div>
</div>
</div>
<div class="form-group">
<input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.address" type="text" class="form-control form-control-border">
</div>


                      </td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Father:</th>
                      <td>
                        
                      <div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.father_lastname" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.father_firstname" type="text" class="form-control form-control-border">
                            </div> 
                            <div class="col"> 
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Middle Name" :readonly = "readonly" :required="!readonly" v-model="student.father_middlename" type="text" class="form-control form-control-border">
                            </div> 
                            
                        </div>
                      </td>
                      <th>Contact / FB:</th>
                      <td><div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.father_contact" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.father_fb" type="text" class="form-control form-control-border">
                            </div> 
                        </div></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.father_occupation" type="text" class="form-control form-control-border"></td>
                      <th>Education:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.father_education" type="text" class="form-control form-control-border"></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Mother:</th>
                      <td>
                      <div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_lastname" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_firstname" type="text" class="form-control form-control-border">
                            </div> 
                            <div class="col"> 
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Middle Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_middlename" type="text" class="form-control form-control-border">
                            </div> 
                        </div>
                      </td>
                      <th>Contact / FB:</th>
                      <td><div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_contact" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_fb" type="text" class="form-control form-control-border">
                            </div> 
                        </div></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_occupation" type="text" class="form-control form-control-border"></td>
                      <th>Education:</th>
                      <td><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.mother_education" type="text" class="form-control form-control-border"></td>
                    </tr>
                    <tr>
                      <th colspan="4">-</th>
                    </tr>

                    <tr>
                      <th>Guardian:</th>
                      <td>
                      <div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Last Name" :readonly = "readonly" :required="!readonly" v-model="student.guardian_lastname" type="text" class="form-control form-control-border">
                            </div>
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="First Name" :readonly = "readonly" :required="!readonly" v-model="student.guardian_firstname" type="text" class="form-control form-control-border">
                            </div> 
                            <div class="col"> 
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Middle Name" :readonly = "readonly" :required="!readonly" v-model="student.guardian_middlename" type="text" class="form-control form-control-border">
                            </div> 
                        </div>
                      </td>
                      <th>Contact:</th>
                      <td><div class="row">
                            <div class="col">
                              <input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Contact" :readonly = "readonly" :required="!readonly" v-model="student.guardian_phone" type="text" class="form-control form-control-border">
                            </div>
                        </div></td>
                    </tr>
                    <tr>
                      <th>Occupation:</th>
                      <td colspan="3"><input v-bind:class="{editState:!readonly,readOnly:readonly}" placeholder="Occupation" :readonly = "readonly" :required="!readonly" v-model="student.guardian_occupation" type="text" class="form-control form-control-border"></td>
      
                    </tr>
                  </table>

                  <button @click="goUpdate" class="btn btn-primary btn-sm btn_pds_elig_update"><i class="fa fa-edit"></i> Update</button>
                        <div class="btns_pds_elig_update btn-group" style="display:none">
                            <button @click="goSave" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                <div class="or"></div>
                            <button @click="goCancel" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Discard</button>
                        </div>

                      </div>
                    </div>
                  </div>
                    <!-- <div class="col-5">

                    <div class="card p-3">
                    <h5 class="card-title text-black"><b><?php echo($student["father_lastname"] . ", " . $student["father_firstname"]); ?></b></h5>
                    <p class="card-text text-gray m-0">Father</p>
                    <p class="card-text text-gray m-0"><?php echo($student["father_occupation"]); ?></p>
                    <p class="card-text text-gray m-0"><?php echo($student["father_education"]); ?></p>
                    <p class="card-text text-gray mdd-0"><?php echo($student["father_contact"] . " / " . $student["father_fb"]); ?></p>
          </div>


          <div class="card p-3">
                    <h5 class="card-title text-black"><b><?php echo($student["mother_lastname"] . ", " . $student["mother_firstname"]); ?></b></h5>
                    <p class="card-text text-gray m-0">Mother</p>
                    <p class="card-text text-gray m-0"><?php echo($student["mother_occupation"]); ?></p>
                    <p class="card-text text-gray m-0"><?php echo($student["mother_education"]); ?></p>
                    <p class="card-text text-gray mdd-0"><?php echo($student["mother_contact"] . " / " . $student["mother_fb"]); ?></p>
          </div>
                    
                    <table class="table" id="sectionTable">

                    
       

          </table>
                    </div> -->
                  </div>

                 

                 

             
                  </div>

                  <div class=" tab-pane" id="grades">
                  <div class="row">
                 
               
                    
                    <div class="col-12">
                      <div class="row">
                        <div class="col-3">
                        <select style="width: 100%;" required id="enrollmentSelect" class="form-control select2 selectFilter">
                          <?php foreach($enrollmentList as $eList):?>

                            <?php
                              if($sy["syid"] == $eList["syid"]):
?>
                            <option selected value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
                              else: ?>

<option value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
                              endif;
                              ?>
                          <?php endforeach; ?>
                        </select>
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <br>

                    <h5 class="bg-teal p-2">Advisory Details</h5>

                  <table class="table" id="advisorySection">
                 <tr>
                   <th>Grade Level:</th>
                   <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                   <th>Section:</th>
                   <td><?php echo($student["student_id"]); ?></td>
                 </tr>

                 <tr>
                   <th>Adviser:</th>
                   <td><?php echo($student["lastname"] . ", " . $student["firstname"]); ?></td>
                   <th>Year Level:</th>
                   <td><?php echo($student["student_id"]); ?></td>
                 </tr>
               </table>


                  <table style="width: 100%;" id="ajaxDatatable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>
                          
                          <form class="generic_form_trigger" data-title="Print Grade Card" data-message="Are you sure you want to download and print the grade card?" id="gradeCardForm" data-url="teacherAdvisory">
                            <input type="hidden" name="action" value="generateGradeExcel">
                            <input type="hidden" id="advisory_idTextbox" name="advisory_id">
                            <input type="hidden" name="student_id" value="<?php echo($_GET["id"]); ?>">
                              <button class="btn btn-sm btn-block btn-success" type="submit">Print Grade Card</button>
                          </form>
                        
                        
                        
                        </th>
                        <th>Subject</th>
                        <th>Subject</th>
                        <th>G1</th>
                        <th>G2</th>
                        <th>G3</th>
                        <th>G4</th>
                        <th>Final</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                  </table>


                 

             
                  </div>

                  <div class=" tab-pane" id="payment_history">
                  <form class="generic_form_trigger" data-title="Print Statement of Account!" data-message="Are you sure you want to download and print the statement of account?”" data-url="enrollment">
                  <div class="row mb-2">
                  <input type="hidden" name="action" value="printSOA">
                <div class="col-6">
                  <div class="form-group">
                  <select style="width:100%;" name="enrollment_id" required id="enrollmentSelect2" class="form-control select2 selectFilter2">
                  <?php foreach($enrollmentList as $eList):?>

<?php
  if($sy["syid"] == $eList["syid"]):
?>
<option selected value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  else: ?>

<option value="<?php echo($eList["enrollment_id"]); ?>"><?php echo($eList["school_year"]); ?></option>
<?php
  endif;
  ?>
<?php endforeach; ?>
                          </select>
                  </div>
                          
                     
                    </div>
                    
                    <div class="col-6">
                      <button type="submit" class="btn btn-info float-right" >Print Statement of Account</button>
                    </div>
                    
                  </div>
                  </form>
                  <table style="width: 100%;" id="ajaxDatatable2" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>School Year</th>
                        <th>Date Paid</th>
                        <th>OR Number</th>
                        <!-- <th>From</th> -->
                        <th>Paid</th>
                        <!-- <th>Remaining</th> -->
                        <th>Type</th>
                      </tr>
                    </thead>
                  </table>
                  </div>





                  <div class=" tab-pane" id="form137">
                      <table style="width: 100%;" id="ajaxDatatable2" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th width="15%"><a href="#" data-toggle="modal" data-target="#newForm137Modal" class="btn btn-info btn-block btn-sm"><i class="fa fa-plus"></i></a></th>
                            <th>School</th>
                            <th>School Year</th>
                            <th>Grade Level</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $form137 = query("select * from captureform137 where student_id = ?
                                                  order by school_year", $_GET["id"]); ?>
                        <?php foreach($form137 as $row): ?>
                          <tr>
                            <td>
                              <div class="btn-group btn-block">
                                <!-- <button @click="showModal(<?php echo($row["form137_id"]); ?>)" class="btn btn-sm btn-warning">Update</button> -->
                               
                                
                                <a href="#" data-toggle="modal" data-id="<?php echo($row["form137_id"]); ?>" data-target="#modalUpdate" class="btn btn-sm btn-warning">Update</a>
                                <a href="form137?action=addGrade&id=<?php echo($row["form137_id"]); ?>" class="btn btn-sm btn-success">Grades</a>
                              </div>
                            </td>
                            <td><?php echo($row["school_name"]); ?></td>
                            <td><?php echo($row["school_year"]); ?></td>
                            <td><?php echo($row["grade_level"]); ?></td>
                          </tr>
                        <?php endforeach; ?>

                        </tbody>
                      </table>
                  </div>



                </div>
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
  <script src="resources/js/vue.js"></script>
  <script src="AdminLTE_new/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="AdminLTE_new/plugins/jquery-validation/additional-methods.min.js"></script>
<script type="text/javascript" src="node_modules/philippine-location-json-for-geer/build/phil.min.js"></script>
<script src="AdminLTE_new/plugins/toastr/toastr.min.js"></script>
<?php require("public/student_system/updateStudent_js.php"); ?>
  <script>




            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }
        </script>


<script>


loadDetails()

$('.select2').select2({
    });


var enrollment_id = $('#enrollmentSelect').val() || "";
var datatable = 
            $('#ajaxDatatable').DataTable({
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
                    'url':'student',
                     'type': "POST",
                     "data": function (data){
                        data.action = "gradeList";
                        data.enrollment_id = enrollment_id;
                     }
                },
                'columns': [
                    { data: 'action', "orderable": false  },
                    { data: 'advisory_id', "orderable": false, "visible": false  },
                    { data: 'subject', "orderable": false  },
                    { data: 'first_grading', "orderable": false  },
                    { data: 'second_grading', "orderable": false  },
                    { data: 'third_grading', "orderable": false  },
                    { data: 'fourth_grading', "orderable": false  },
                    { data: 'average', "orderable": false  },
                    { data: 'remarks', "orderable": false  },


                ],

                
                "footerCallback": function (row, data, start, end, display) {
    var api = this.api();


    var advisory_id = api
    .cell( { row: 0, column: 1 } )  // Get advisory_id from the first row
    .data();

// Check if advisory_id is undefined or empty
if (typeof advisory_id === 'undefined' || advisory_id === '') {
    $('#gradeCardForm').hide();  // Hide the form if advisory_id is undefined or empty
} else {
  $('#gradeCardForm').show();
  $('#advisory_idTextbox').val(advisory_id); // Optionally, show the form if advisory_id is available
}  // Get the data in the first cell of column 1 (index 1)
      // alert(advisory_id);

      gradeCardForm


   

    // Remove the formatting to get integer data for summation
    var intVal = function (i) {
        return typeof i === 'string' ?
            i.replace(/[\$,]/g, '') * 1 :
            typeof i === 'number' ?
                i : 0;
    };

    

    // Total over all pages
    var received = api
        .column(2)
        .data()
        .reduce(function (a, b) {
            return intVal(a) + intVal(b);
        }, 0);

    // Calculate installment
    var installment = received / 10;

    // Format the output
    var formattedReceived = '₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    var formattedInstallment = '₱ ' + installment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });



    // Update the footer
    $('#feeTotal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
    $('#totalVal').val(received);
}
            });

            $('[data-mask]').inputmask()
  function loadDetails(){
  // alert("awit");

  var enrollment_id = $('#enrollmentSelect').val() || "";
                  Swal.fire({title: 'Please wait...', 
                    showClass: {
    popup: `
      animate__animated
      animate__bounceIn
      animate__faster
    `
  },
  hideClass: {
    popup: `
      animate__animated
      animate__bounceOut
      animate__faster
    `
  },
                    imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
                        $.ajax({
                            type : 'post',
                            url : 'student', //Here you will fetch records 
                            data: {
                              enrollment_id: enrollment_id, action: "advisoryDetailsHTML"
                            },
                            success : function(data){
                                $('#advisorySection').html(data);
                        
                                // $(".select2").select2();//Show fetched data from database
                            }
                        });
                        Swal.close();
                
                }  
            $('.selectFilter').on('change', function() {
              loadDetails();

              var thisEnrollmentID = $('#enrollmentSelect').val() || "";
              // alert(thisEnrollmentID);
              datatable.ajax.url('student?action=gradeList&thisEnrollmentID='+thisEnrollmentID).load();
 
              });


          var datatable2 = 
            $('#ajaxDatatable2').DataTable({
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
                    'url':'studentAccounts',
                     'type': "POST",
                     "data": function (data){
                        data.action = "paymentHistoryList";
                        data.enrollment_id = enrollment_id;
                     }
                },
                'columns': [
                    { data: 'school_year', "orderable": false  },
                    
                    { data: 'date_paid', "orderable": false  },
                    { data: 'or_number', "orderable": false  },
                    // {
                    //     data: 'from_balance', 
                    //     orderable: false,
                    //     render: function (data, type, row) {
                    //         return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                    //     }
                    // },
                    {
                        data: 'amount_due', 
                        orderable: false,
                        render: function (data, type, row) {
                            return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                        }
                    },
                    // {
                    //     data: 'to_balance', 
                    //     orderable: false,
                    //     render: function (data, type, row) {
                    //         return '<span class="float-right">₱ ' + parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + '</span>';
                    //     }
                    // },
                    { data: 'type', "orderable": false  },

                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api();

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over all pages
                    var received = api
                        .column(1)
                        .data()
                        .reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);

                    // Calculate installment
                    var installment = received / 10;

                    // Format the output
                    var formattedReceived = '₱ ' + received.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    // var formattedInstallment = '₱ ' + installment.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    // Update the footer
                    $('#feeTotal').html(formattedReceived);
                    // $('#feeTotalModal').html(formattedReceived + ' (' + formattedInstallment + ' / month)');
                    $('#totalVal').val(received);
                }
            });
            
            $('.selectFilter2').on('change', function() {
              var enrollmentFilterID = $('#enrollmentSelect2').val() || "";
              datatable2.ajax.url('studentAccounts?action=paymentHistoryList&enrollmentFilterID='+enrollmentFilterID).load();
              });

            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "";
            }


  $(function () {
      $('#CaptureForm137').validate({
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-control').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid').addClass('is-valid');
        },
        success: function (label, element) {
          $(element).addClass('is-valid'); // Adds green border when valid
          // Add a green check icon or any valid styling you want to apply
          $(element).closest('.form-control').find('span.valid-feedback').remove();
          // $(element).closest('.form-group').append('<span class="valid-feedback">✓</span>'); // Adds a check mark
        }
      });
  });


  $('#updateRequirementsModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'student', //Here you will fetch records 
            data: {
               action: "updateRequirementsModal",
               student_id: id,
            },
            success : function(data){
                $('#updateRequirementsModal .fetched-data').html(data);
                Swal.close();
            }
        });
     });


     $('#updateGradesModal').on('show.bs.modal', function (e) {
        var id = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'student', //Here you will fetch records 
            data: {
               action: "updateGradesModal",
               grade_id: id,
            },
            success : function(data){
                $('#updateGradesModal .fetched-data').html(data);
                Swal.close();
            }
        });
     });

     



  // $('#modalUpdateGrades').on('show.bs.modal', function (e) {
  //   var row_id = $(e.relatedTarget).data('id');
  //   // Call Vue method and pass form137_id
  //     var vueInstance = $("#updateGrades")[0].__vue__;
  //     vueInstance.fetchGrades(row_id);
  // });



  // $('#modalUpdateGrades').on('show.bs.modal', function (e) {
  //       var row_id = $(e.relatedTarget).data('id');
  //       Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
  //       $.ajax({
  //           type : 'post',
  //           url : 'student', //Here you will fetch records 
  //           data: {
  //             form137_id: row_id,
  //             action: "modalUpdateGrades"
  //           },
  //           success : function(data){
  //               $('#modalUpdateGrades .fetched-data').html(data);





  //               Swal.close();
  //               // $(".select2").select2();//Show fetched data from database
  //           }
  //       });
  //    });
  new Vue({
  el: "#updateGrades",
  data: {
    readonly: true,
    form137_id: 0,
    grades: [],  // Make sure grades is initialized here
    grade: {
      subject: null,
      first_grading: null,
      second_grading: null,
      third_grading: null,
      fourth_grading: null,
      final_rating: null,
      remarks: null
    },
  },
  computed: {
  numOfGrades() {
    return this.grades ? this.grades.length : 0;
  }
},
  methods: {
    fetchGrades(form137_id) {
      Swal.fire({
        title: 'Please wait...',
        imageUrl: 'AdminLTE_new/dist/img/loader.gif',
        showConfirmButton: false
      });

      $.ajax({
        type: 'post',
        url: 'student',
        data: {
          form137_id: form137_id,
          action: "modalUpdateGrades"
        },
        success: (response) => {
          this.grades = response;
          console.log(this.grades);  // Assume response contains grades data
          Swal.close();
        },
        error: (err) => {
          console.error('Error fetching grades:', err);
          Swal.close();
        }
      });
    },
    addGrade() {
      this.grades = [];
      // console.log(this.grades);
      this.grades.push({
                Title: null,
                Rating: null,
                DateExam: null,
                PlaceExam: null,
                License: null,
                DateReleased: null
             })
    },
    remGrade(index) {
      this.grades.splice(index, 1);
    }
  },
  mounted() {
    $('#modalUpdateGrades').on('show.bs.modal', (e) => {
      var row_id = $(e.relatedTarget).data('id');
      this.fetchGrades(row_id);
    });
  }
});


        </script>


  <?php require("layouts/footer.php") ?>