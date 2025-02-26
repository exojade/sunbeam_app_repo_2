<script src="AdminLTE_new/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- <script src="AdminLTE_new/dist/js/demo.js"></script> -->
<script src="AdminLTE_new/plugins/sweetalert2/sweetalert2.min.js"></script>

<script>
$(document).on('submit', '.generic_form_trigger', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this)[0];
    var formData = new FormData(form);
    var promptmessage = "";
    var prompttitle = "";
    if(typeof($(this).data('title')) != "undefined" ) {
      promptmessage = $(this).data('message');
      prompttitle = $(this).data('title');
    }
    else{
      promptmessage = '';
      prompttitle = 'Are you sure?';
    }


    
    var url = $(this).data('url');

    Swal.fire({
        title: prompttitle,
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
        text: promptmessage,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
        
    }).then((result) => {
        if (result.value) {
            Swal.fire({ title: 'Please wait...', 
                
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
  },imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false });
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: formData,
                success: function(results) {
                    var o = jQuery.parseJSON(results);
                    console.log(o);
                    if (o.result === "success") {
                        swal.close();
                        Swal.fire({
                          title: o.title,
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
                            text: o.message,
                            icon: "success"
                        }).then(function () {
                          if(typeof(o.newlink) != "undefined" && o.newlink !== null) {
                          if(o.newlink == "newlink"){
                            console.log(o);
                            if(o.link == "refresh")
                            window.location.reload();
                            else if(o.link == "not_refresh")
                              console.log("");
                            else
                              window.open(o.link, '_blank');
                              // window.location.replace(o.link, "_blank");
                          }
                      }
                      else{
                        if(o.link == "refresh")
                        window.location.reload();
                        else if(o.link == "not_refresh")
                          console.log("");
                        else
                          window.location.replace(o.link);

                      }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: o.message,
                            type: "error"
                        });
                        console.log(results);
                    }
                },
                error: function(results) {
                    console.log(results);
                    Swal.fire("Error!", "Unexpected error occured!", "error");
                }
            });
        }
    });
});



$(document).on('submit', '.generic_form_no_trigger', function(e) {
    e.preventDefault(); // Prevent the default form submission

    var form = $(this)[0];
    var formData = new FormData(form);
    var promptmessage = "";
    var prompttitle = "";
    if(typeof($(this).data('title')) != "undefined" ) {
      promptmessage = $(this).data('message');
      prompttitle = $(this).data('title');
    }
    else{
      promptmessage = '';
      prompttitle = 'Are you sure?';
    }


    
    var url = $(this).data('url');

    Swal.fire({ title: 'Please wait...', 
                
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
  },imageUrl: 'AdminLTE_new/dist/img/loader.gif', showConfirmButton: false });
            $.ajax({
                type: 'post',
                url: url,
                processData: false,
                contentType: false,
                data: formData,
                success: function(results) {
                    var o = jQuery.parseJSON(results);
                    console.log(o);
                    if (o.result === "success") {
                        swal.close();
                        Swal.fire({
                            title: o.title,
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
                            text: o.message,
                            icon: "success"
                        }).then(function () {
                          if(typeof(o.newlink) != "undefined" && o.newlink !== null) {
                          if(o.newlink == "newlink"){
                            console.log(o);
                            if(o.link == "refresh")
                            window.location.reload();
                            else if(o.link == "not_refresh")
                              console.log("");
                            else
                              window.open(o.link, '_blank');
                              // window.location.replace(o.link, "_blank");
                          }
                      }
                      else{
                        if(o.link == "refresh")
                        window.location.reload();
                        else if(o.link == "not_refresh")
                          console.log("");
                        else
                          window.location.replace(o.link);

                      }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: o.message,
                            type: "error"
                        });
                        console.log(results);
                    }
                },
                error: function(results) {
                    console.log(results);
                    Swal.fire("Error!", "Unexpected error occured!", "error");
                }
            });



    
});






    $('.generic_form_pdf').submit(function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    Swal.fire({
        title: 'Please wait...',
        imageUrl: 'AdminLTE_new/dist/img/loader.gif',
        showConfirmButton: false
    });
    $.ajax({
        type: 'post',
        url: url,
        data: $(this).serialize(),
        success: function(results) {
            var o = jQuery.parseJSON(results);
            o = o.info["0"];
            console.log(o);
            if (o.result === "success") {
                Swal.close();
                var fileName = o.path;
                $("#dialog").dialog({
                    modal: true,
                    title: fileName,
                    width: 1200,
                    height: "auto",
                    resizable: false,
                    draggable: false,
                    closeOnEscape: true,
                    dialogClass: 'fixed-dialog',
                    buttons: {
                        Close: function() {
                            $(this).dialog('close');
                        },
                        "Open Link": function() {
                            window.open(o.path);
                        },
                    },
                    open: function() {
                        var object = "<object data=\"" + o.path + "\" type=\"application/pdf\" width=\"1200px\" height=\"500px\">";
                        object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                        object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                        object += "</object>";
                        object = object.replace(/{FileName}/g, "Files/" + fileName);
                        $("#dialog").html(object);
                    }
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: o.message,
                    type: "error"
                });
                console.log(results);
            }
        },
    });
});



$('.generic_form_pdf_dropping').submit(function(e) {
    e.preventDefault();
    var url = $(this).data('url');
    
    // Prompt user for OPERATOR and ADDRESS using SweetAlert
    Swal.fire({
        title: "Enter Operator and Address",
        html:
          '<input required style="width: 83% !important;" id="operator" class="swal2-input" placeholder="Operator">' +
          '<input required style="width: 83% !important;" id="address" class="swal2-input" placeholder="Address">',
        focusConfirm: false,
        preConfirm: () => {
            return {
                operator: $('#operator').val(),
                address: $('#address').val()
            };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            var operator = result.value.operator;
            var address = result.value.address;
            Swal.fire({
                title: 'Please wait...',
                imageUrl: 'AdminLTE_new/dist/img/loader.gif',
                showConfirmButton: false
            });
            // Add OPERATOR and ADDRESS to form data
            $.ajax({
                type: 'post',
                url: url,
                data: $(this).serialize() + '&operator=' + operator + '&address=' + address,
                success: function(results) {
                    var o = jQuery.parseJSON(results);
                    o = o.info["0"];
                    console.log(o);
                    if (o.result === "success") {
                        Swal.close();
                        var fileName = o.path;
                        $("#dialog").dialog({
                            modal: true,
                            title: fileName,
                            width: 1200,
                            height: "auto",
                            resizable: false,
                            draggable: false,
                            closeOnEscape: true,
                            dialogClass: 'fixed-dialog',
                            buttons: {
                                Close: function() {
                                    $(this).dialog('close');
                                },
                                "Open Link": function() {
                                    window.open(o.path);
                                },
                            },
                            open: function() {
                                var object = "<object data=\"" + o.path + "\" type=\"application/pdf\" width=\"1200px\" height=\"500px\">";
                                object += "If you are unable to view file, you can download from <a href = \"{FileName}\">here</a>";
                                object += " or download <a target = \"_blank\" href = \"http://get.adobe.com/reader/\">Adobe PDF Reader</a> to view the file.";
                                object += "</object>";
                                object = object.replace(/{FileName}/g, "Files/" + fileName);
                                $("#dialog").html(object);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: o.message,
                            icon: "error",
                        });
                        console.log(results);
                    }
                },
            });
        }
    });
});











    $('.generic_form_files_trigger').submit(function(e) {
  var form = $(this)[0];
	var formData = new FormData(form);
    e.preventDefault();
    console.log(formData);
  var url = $(this).data('url');
  console.log(url);
  Swal.fire({
  title: 'Do you want to save the changes?',
  showCancelButton: true,
  confirmButtonText: 'Save',
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      Swal.fire({title: 'Please wait...', imageUrl: 'AdminLTE/dist/img/loader.gif', showConfirmButton: false});
      $.ajax({
                type: 'post',
                url: url,
                data: formData,
                processData: false,
    	contentType: false,
                success: function (results) {
                var o = jQuery.parseJSON(results);
                console.log(o);
                if(o.result === "success") {
                    Swal.close();
                    Swal.fire({title: "Submit success",
                    text: o.message,
                    type:"success"})
                    .then(function () {
                    window.location.replace(o.link);
                    });
                }
                else {
                    Swal.fire({
                    title: "Error!",
                    text: o.message,
                    type:"error"
                    });
                    console.log(results);
                }
                },
                error: function(results) {
                console.log(results);
                swal("Error!", "Unexpected error occur!", "error");
                }
            });
    } else if (result.isDenied) {
    
    }
  })
    });

</script>



<footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    </div>
    <strong>Copyright &copy; <?php echo(date("Y")); ?> Sunbeam Christian School of Panabo | Registrar Management Information System
  </footer>
    <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>
</body>
</html>