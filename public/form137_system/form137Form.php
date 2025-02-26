<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="AdminLTE_new/plugins/toastr/toastr.min.css">
  <!-- Theme style -->

  <link rel="stylesheet" href="AdminLTE/bower_components/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="AdminLTE_new/dist/css/adminlte.min.css">
  
<!-- <style>
  #sectionTable td{
    border: 0px;
    padding: 0px;
  }
  #sectionTable th{
    border: 0px;
    padding: 0px;
  }


  #advisorySection td{
    border: 0px;
    padding: 0px;
  }
  #advisorySection th{
    border: 0px;
    padding: 0px;
  }
</style> -->
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
       
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <div class="row">
      <div class="col-md-3">
 
            <!-- Profile Image -->




            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Form 137</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php 
              $form137 = query("select * from captureform137 where form137_id = ?", $_GET["id"]);
              $form137 = $form137[0];
              ?>

                <strong><?php echo($form137["grade_level"]); ?></strong>
                <hr>
                <strong>Section</strong>
                <p class="text-muted">
                  <?php echo($form137["section"]); ?>
                </p>
                <hr>
                <strong>School Information</strong>

                <p class="text-muted">
                  <?php echo($form137["school_name"]); ?>
                  <br>  <?php echo($form137["school_id"]); ?>
                  <br>  <?php echo($form137["district"]); ?>
                  <br>  <?php echo($form137["division"] . " " . $form137["region"]); ?>
                </p>
                <hr>
                <strong><i class="fas fa-pencil-alt mr-1"></i> Adviser</strong>
                <p class="text-muted">
                <?php echo($form137["adviser_name"]); ?>
             
                </p>

              </div>
              <!-- /.card-body -->
            </div>
            

          </div>

          <div class="col-9">


          <div class="card">
        <div class="card-header bg-primary">
          <h3 class="card-title">Grades</h3>
        </div>
        <div class="card-body">

        <div id="pds_elig">
                    <div id="form_pds_elig" class="ui tiny form">
                        <button @click="goUpdate" id="btn_pds_elig_update" class="btn btn-primary btn-sm"><i class="icon edit"></i> Update</button>
                        <div class="btns_pds_elig_update btn-group" style="display:none">
                            <button @click="goSave" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                <div class="or"></div>
                            <button @click="goCancel" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Discard</button>
                        </div>

                 
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                            <tr class="center aligned">
                                <th>Subject</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>Final</th>
                                <th>Remarks</th>
                                <th :hidden="readonly"></th>
                            </tr>
                         
                            </thead>
                            <tbody>
                            <template v-if="eligs.length != 0">
                            <tr v-for="(elig, i) in eligs" :key="i">
                                <td>
                                <select 
                                    v-bind:class="{ editState: !readonly, readOnly: readonly }" 
                                    :disabled="readonly" 
                                    :required="!readonly" 
                                    v-model="elig.subject_head_id" 
                                    class="custom-select form-control-border" 
                                >
                                <?php $subject_head = query("select * from subject_main order by subject_head_id asc"); ?> 
                                <?php foreach($subject_head as $row): ?>
                                    <option value="<?php echo($row["subject_head_id"]); ?>"><?php echo($row["subject_head_name"]); ?></option>
                                <?php endforeach; ?>
                                </select>

                                </td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="number" v-model="elig.first_grading" @input="calculateFinal(elig, i)"></td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="number" v-model="elig.second_grading" @input="calculateFinal(elig, i)"></td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="number" v-model="elig.third_grading" @input="calculateFinal(elig, i)"></td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="number" v-model="elig.fourth_grading" @input="calculateFinal(elig, i)"></td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.final_rating" readonly></td>
                                <td><input class="form-control form-control-border" :readonly="readonly" :class="{readOnly: readonly}" type="text" v-model="elig.remarks"></td>
                                <td :hidden="readonly">
                                    <button class="btn btn-sm btn-danger" @click="removeItem(i)"> 
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                            </template>
                            <template  v-else>
                                <tr class="center aligned" style="color:lightgrey">
                                    <td colspan="6">-- N/A --</td>
                                </tr>
                            </template>
                            <template v-if="!readonly">
                                <tr>
                                    <td colspan="6">
                                        <button class="btn btn-primary btn-sm" @click="addItem">
                                            <i class="fa fa-plus"></i> Add
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>

                        <div class="btns_pds_elig_update btn-group" style="display:none">
                            <button @click="goSave" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Save</button>
                                <div class="or"></div>
                            <button @click="goCancel" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Discard</button>
                        </div>
                        
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
  <script src="AdminLTE_new/plugins/toastr/toastr.min.js"></script>
  <script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script src="resources/js/vue.js"></script>




  <?php require("layouts/footer.php") ?>

  <script>
  new Vue({
    el: "#form_pds_elig",
    data: {
        readonly: true,
        id: null,
        eligs: [],
        elig: {
            subject: null,
            subject_head_id: null,
            first_grading: null,
            second_grading: null,
            third_grading: null,
            fourth_grading: null,
            final_rating: null,
            remarks: null
        },
    },
    methods: {  
        getEmployeeData() {
            this.id = '<?php echo($_GET["id"]); ?>';
            $.ajax({
                type: "get",
                url: "form137?action=getGrades",
                data: {id: this.id},
                dataType: "json",
                success: (response) => {
                    this.eligs = response;
                },
                async: false,
            });
        },
        goUpdate() {
            this.readonly = false;
            $("#btn_pds_elig_update").hide();
            $(".btns_pds_elig_update").show();
        },
        goSave() {
            const isValid = 1;
            if (isValid) {
                toastr.options = {
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "timeOut": "3000",
                    "extendedTimeOut": "500"
                };
                $.post(
                    "form137",
                    { action: "saveGrades", id: this.id,  data: this.eligs },
                    (data) => {
                        toastr.success('Grades Saved');
                        this.getEmployeeData();
                        this.readonly = true;
                        $("#pds_elig #btn_pds_elig_update").show();
                        $("#pds_elig .btns_pds_elig_update").hide();
                    },
                    "json"
                );
            } else {
                console.log("Form validation failed!");
            }
        },
        savedToast() {
            $('#form_pds_elig').toast({
                title: 'Saved!',
                message: 'Successfully saved changes!',
                showProgress: 'bottom',
                classProgress: 'green',
                position: 'top center',
                className: {
                    toast: 'ui message'
                }
            });
        },
        goCancel() {
            this.getEmployeeData();
            this.readonly = true;
            $("#btn_pds_elig_update").show();
            $(".btns_pds_elig_update").hide();
        },
        addItem() {
            this.eligs.push({
                subject: null,
                subject_head_id: null,
                first_grading: null,
                second_grading: null,
                third_grading: null,
                fourth_grading: null,
                final_rating: null,
                remarks: null
            });
        },
        removeItem(i) {
            this.eligs.splice(i, 1);
        },
        calculateFinal(elig, index) {
            let total = 0;
            let count = 0;
            // Add grades if they are not null or empty
            ['first_grading', 'second_grading', 'third_grading', 'fourth_grading'].forEach((grading) => {
                if (elig[grading] != null && elig[grading] !== '') {
                    total += parseFloat(elig[grading]);
                    count++;
                }
            });

            if (count > 0) {
                const average = total / count;
                elig.final_rating = average.toFixed(2); // Round the average to 2 decimal places
                elig.remarks = average >= 75 ? "Passed" : "Failed";
            }
        }
    },
    created() {
        var checkLoaded = setInterval(() => {
            if (document.readyState == 'complete') {
                this.getEmployeeData();
                clearInterval(checkLoaded);
            }
        }, 100);
    }
});
  </script>