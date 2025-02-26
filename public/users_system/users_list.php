<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <a href="#" class="btn btn-info float-right" data-toggle="modal" data-target="#addUserModal">Add User</a>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="modal fade" id="addUserModal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header bg-info">
              <h4 class="modal-title">Register User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form class="generic_form_files_trigger" autocomplete="off" role="form" enctype="multipart/form-data" data-url="users">
              <input type="hidden" name="action" value="addUser">

              <div class="row">
                <div class="col-8">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address / Username <span class="color-red">*</span></label>
                    <input required type="text" name="username" class="form-control" id="exampleInputEmail1" placeholder="---">
                  </div>

                  <div class="form-group">
                <label for="exampleInputEmail1">Fullname <span class="color-red">*</span></label>
                <input required type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="---">
              </div>


              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Gender <span class="color-red">*</span></label>
                    <select required name="gender" class="form-control select2">
                      <option selected disabled value="">Please select Gender</option>
                      <option value="MALE">MALE</option>
                      <option value="FEMALE">FEMALE</option>
                    </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Role <span class="color-red">*</span></label>
                    <select required name="role" class="form-control select2">
                      <option selected disabled value="">Please select Role</option>
                      <option value="admin">ADMIN</option>
                      <option value="cashier">CASHIER</option>
                      <option value="parent">PARENT</option>
                    </select>
                  </div>
                </div>
              </div>
                </div>
                <div class="col-4">
                <div class="row">
                        <div class="col-12">
                        <div class="form-group">
                          <label for="Image" class="form-label">Profile Image</label>
                          <input accept="image/png, image/gif, image/jpeg" class="form-control" type="file" id="formFile" name="profile_image" onchange="preview()">
                      </div>
                        </div>
                        <div class="col-12">
                        <img id="frame" src="resources/default.jpg" class="img-fluid" style="border: 3px solid black; padding: 5px;" width="100%" height="150" />
                        <button onclick="clearImage()" type="button" class="btn btn-block btn-sm btn-primary mt-3">Clear</button>
                        </div>
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









      <div class="modal fade" id="modalUpdateUser">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h4 class="modal-title">Update User</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <div class="modal-body">
                <form class="generic_form_trigger" autocomplete="off" role="form" enctype="multipart/form-data" data-url="users">
                <input type="hidden" name="action" value="updateUser">
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



      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Default box -->
            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Action</th>
                    <th>Username / Email</th>
                    <th>Role</th>
                    <th>Fullname</th>
                    <th>Status</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach($users as $u):  ?>
                    <tr>
                      <td>
                        <form class="generic_form_trigger" data-url="users">
                          <input type="hidden" name="user_id" value="<?php echo($u["id"]); ?>">
                          <input type="hidden" name="action" value="reset_password">
                          <div class="btn-group btn-block">
                            <a href="#" data-id="<?php echo($u["id"]); ?>" data-toggle="modal" data-target="#modalUpdateUser" class="btn btn-warning btn-sm">Update</a>
                            <button class="btn btn-info btn-sm">Reset Pass</button>
                          </div>
                        </form>
                      </td>
                      <td><?php echo($u["username"]); ?></td>
                      <td><?php echo(strtoupper($u["role"])); ?></td>
                      <td><?php echo(strtoupper($u["fullname"])); ?></td>
                      <td><?php echo(strtoupper($u["active_remarks"])); ?></td>

                    </tr>
                  <?php endforeach; ?>
                  </tbody>
    
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
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
  <script>


    
$('#modalUpdateUser').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false});
        $.ajax({
            type : 'post',
            url : 'users', //Here you will fetch records 
            data: {
                user_id: rowid, action: "modalUpdateUser"
            },
            success : function(data){
                $('#modalUpdateUser .fetched-data').html(data);
                Swal.close();
            }
        });
     });


$('#example1').DataTable({
  ordering: false
    });
            function preview() {
                frame.src = URL.createObjectURL(event.target.files[0]);
            }
            function clearImage() {
                document.getElementById('formFile').value = null;
                frame.src = "resources/default.jpg";
            }
        </script>
  <?php require("layouts/footer.php") ?>