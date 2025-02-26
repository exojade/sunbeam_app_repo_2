<link rel="stylesheet" href="AdminLTE_new/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="AdminLTE_new/plugins/summernote/summernote-bs4.min.css">



<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <!-- <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          <h1>School Announcement</h1>
          </div>
         <div class="col-sm-6">
            <a href="#" data-toggle="modal" class="btn btn-primary float-right" data-target="#newAnnouncement">New Annoucement</a>
          </div>
        </div>
      </div> -->
    </section>


    <div class="modal fade" id="newAnnouncement">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h4 class="modal-title">New Announcement</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
  
              <form class="generic_form_trigger" role="form" enctype="multipart/form-data" data-url="announcement">
                <input type="hidden" name="action" value="addAnnouncement">
                <input type="hidden" name="school_year" value="<?php echo($school_year[0]["syid"]); ?>">
                <input type="hidden" name="from_sender" value="<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>">


              <textarea id="summernote" name="announcement">
                 
              </textarea>
              

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
                  </form>
          </div>
        </div>
      </div>

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
        <div class="col-12">

        <div class="card">
              <div class="card-header bg-info">
                <h3 class="card-title">School Announcement</h3>
              </div>
              <div class="card-body">
              <table id="ajaxDatatable" style="width: 100%;">
                  <thead>
                  <tr>
                    <th></th>
                  </tr>
                  </thead>
                </table>
              </div>
        </div>

        </div>

        <div class="col-12">
        <div class="card">
              <div class="card-header bg-primary">
                <h3 class="card-title">Section Announcement</h3>
              </div>
              <div class="card-body">
              <table id="ajaxDatatable2" style="width: 100%;">
                  <thead>
                  <tr>
                    <th></th>
                  </tr>
                  </thead>
                </table>
              </div>
        </div>

        </div>
      </div>
    
      
</div>
  </section>
  </div>
  <br>
  <br>

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
  <script src="AdminLTE_new/plugins/summernote/summernote-bs4.min.js"></script>
  <script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>
  <script>


$('#summernote').summernote({
  minHeight: 200
});

var datatable = 
            $('#ajaxDatatable').DataTable({
                "searching": false,
                "pageLength": 10,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": true,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'paging': true,
        // 'searching': false, // Disable searching if unnecessary
        'info': false, // Disable table info text
        'ordering': false,
                'serverMethod': 'post',
                'ajax': {
                    'url':'announcement',
                     'type': "POST",
                     "data": function (data){
                        data.action = "announcementList";
                     }
                },
                dom: '<"top"fpl>rt<"bottom"p><"clear">',
                initComplete: function () {
            // Add float-right to pagination controls
            $('.dataTables_paginate').addClass('float-right');

            // Add float-left to the length menu
            $('#ajaxDatatable_length').addClass('float-left');
        },
                columns: [
            {
                data: 'announcementText',
                render: function (data) {
                    return data; // Render the timeline HTML directly
                },
                orderable: false
            }
        ],
        // createdRow: function (row, data, dataIndex) {
        //     // Inject the HTML directly into the container
        //     $('#ajaxDatatable').append(data.announcementText);
        // },
        // paging: true,
        // searching: false,
        // info: false,
        // ordering: false,
        // destroy: true,
            });


            var datatable = 
            $('#ajaxDatatable2').DataTable({
                "searching": false,
                "pageLength": 10,
                language: {
                    searchPlaceholder: "Search Teacher's Name"
                },
                "bLengthChange": true,
                "ordering": false,
                'processing': true,
                'serverSide': true,
                'paging': true,
        // 'searching': false, // Disable searching if unnecessary
        'info': false, // Disable table info text
        'ordering': false,
                'serverMethod': 'post',
                'ajax': {
                    'url':'announcement',
                     'type': "POST",
                     "data": function (data){
                        data.action = "announcementListParent";
                        data.parent = "<?php echo($_SESSION["sunbeam_app"]["userid"]); ?>";
                     }
                },
                dom: '<"top"fpl>rt<"bottom"p><"clear">',
                initComplete: function () {
            // Add float-right to pagination controls
            $('.dataTables_paginate').addClass('float-right');

            // Add float-left to the length menu
            $('#ajaxDatatable_length').addClass('float-left');
        },
                columns: [
            {
                data: 'announcementText',
                render: function (data) {
                    return data; // Render the timeline HTML directly
                },
                orderable: false
            }
        ],
        // createdRow: function (row, data, dataIndex) {
        //     // Inject the HTML directly into the container
        //     $('#ajaxDatatable').append(data.announcementText);
        // },
        // paging: true,
        // searching: false,
        // info: false,
        // ordering: false,
        // destroy: true,
            });
            $('.selectFilter').on('change', function() {
              var student_id = $('#studentSelect').val() || "";
              datatable.ajax.url('enrollment?action=enrollmentList&student_id='+student_id).load();
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