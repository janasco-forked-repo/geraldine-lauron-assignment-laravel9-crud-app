<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Geraldine Lauron - CRUD App Laravel 10 & Ajax</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' />
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
  <style type="text/css">
      
               body {
              margin: 0;
              padding: 0;
            }
            .bg-video-wrap {
              position: relative;
              overflow: hidden;
              width: 100%;
              height: 100vh;
              background: url(https://designsupply-web.com/samplecontent/vender/codepen/20181014.png) no-repeat center center/cover;
            }
            video {
              min-width: 100%;
              min-height: 100vh;
              z-index: 1;
            }
            .overlay {
              width: 100%;
              height: 100vh;
              position: absolute;
              top: 0;
              left: 0;
              background-image: linear-gradient(45deg, rgba(0,0,0,.3) 50%, rgba(0,0,0,.7) 50%);
              background-size: 3px 3px;
              z-index: 2;
            }
            h1 {
              text-align: center;
              color: #fff;
              position: absolute;
              top: 0;
              bottom: 0;
              left: 0;
              right: 0;
              margin: auto;
              z-index: 3;
              max-width: 400px;
              width: 100%;
              height: 50px;
            }


  </style>
</head>
{{-- add new hat modal start --}}
<div class="modal fade" id="addHatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Hat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_hat_form" enctype="multipart/form-data">
        @csrf
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="hat_name">Hat Name</label>
            <input type="text" name="hat_name" class="form-control" placeholder="Hat Name" required>
          </div>
          <div class="my-2">
            <label for="hat_desc">Hat Description</label>
            <input type="text" name="hat_desc" class="form-control" placeholder="Hat Description" required>
          </div>
          <div class="my-2">
            <label for="hat_link">Hat Link</label>
            <input type="text" name="hat_link" class="form-control" placeholder="Hat Link" required>
          </div>
          <div class="my-2">
            <label for="hat_image">Select Hat Image</label>
            <input type="file" name="hat_image" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_hat_btn" class="btn btn-primary">Add Hat</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new hat modal end --}}

{{-- edit hat modal start --}}
<div class="modal fade" id="editHatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Hat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_hat_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="update_hat_id" id="update_hat_id">
        <input type="hidden" name="update_hat_image" id="update_hat_image">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="hat_name">Hat Name</label>
            <input type="text" name="hat_name" id="hat_name" class="form-control" placeholder="Hat Name" required>
          </div>
          <div class="my-2">
            <label for="hat_desc">Hat Description</label>
            <input type="text" name="hat_desc" id="hat_desc" class="form-control" placeholder="Hat Description" required>
          </div>
          <div class="my-2">
            <label for="hat_link">Hat Link</label>
            <input type="text" name="hat_link" id="hat_link" class="form-control" placeholder="Hat Link" required>
          </div>
          <div class="my-2">
            <label for="hat_image">Select Hat Image</label>
            <input type="file" name="hat_image" class="form-control">
          </div>
          <div class="mt-2" id="hat_image">

          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_hat_btn" class="btn btn-success">Update Hat</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit hat modal end --}}

{{-- view hat modal start --}}
<div class="modal fade" id="viewHatModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">View Hat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="view_hat_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="view_hat_id" id="view_hat_id">
        <input type="hidden" name="view_hat_image" id="view_hat_image">
        <div class="modal-body p-4 bg-light">
          <div class="my-2">
            <label for="hat_image">Select Hat Image</label>
            <input type="file" name="hat_image" class="form-control">
          </div>
          <div class="mt-2" id="hat_image">

          </div>
          <div class="my-2">
            <label for="hat_name">Hat Name</label>
            <input type="text" name="hat_name" id="hat_name" class="form-control" placeholder="Hat Name" required>
          </div>
          <div class="my-2">
            <label for="hat_desc">Hat Description</label>
            <input type="text" name="hat_desc" id="hat_desc" class="form-control" placeholder="Hat Description" required>
          </div>
          <div class="my-2">
            <label for="hat_link">Hat Link</label>
            <input type="text" name="hat_link" id="hat_link" class="form-control" placeholder="Hat Link" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- view hat modal end --}}

<body class="bg-light">

    <div class="bg-video-wrap">
        <video src="https://designsupply-web.com/samplecontent/vender/codepen/20181014.mp4" loop muted autoplay> </video>
        <div class="overlay">

                <br> 
                <div class="text-center">
                    <h3 class="text-light">Hats Style List</h3>
                    <h3 class="text-light">@Geraldine Lauron </h3>
                    <h3 class="text-light">CRUD App Laravel-10 & Ajax</h3>
                </div> 
                  <div class="container">
                    <div class="row my-5">
                      <div class="col-lg-12">
                        <div class="card shadow">
                          <div class="card-header bg-danger d-flex justify-content-between align-items-center" style="background-color: var(--bs-pink)!important;">
                            <h3 class="text-light">Manage Hats</h3>
                            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addHatModal"><i
                                class="bi-plus-circle me-2"></i>Add New Hat</button>
                          </div>
                          <div class="card-body" id="show_all_hats">
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                <div class="text-center"> 
                    <h3 class="text-light">Subject: Interactive Programming and Technologies (IPT1)</h3>
                    <h3 class="text-light">@Geraldine Lauron</h3>
                </div>

                  <br>
                  <br>

       </div>
    </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {

      // add new hat ajax request
      $("#add_hat_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#add_hat_btn").text('Adding...');
        $.ajax({
          url: '{{ route('create') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Hat Added Successfully!',
                'success'
              )
              fetchAllHats();
            }
            $("#add_hat_btn").text('Add Hat');
            $("#add_hat_form")[0].reset();
            $("#addHatModal").modal('hide');
          }
        });
      });

      // edit hat ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('edit') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#hat_name").val(response.hat_name);
            $("#hat_desc").val(response.hat_desc);
            $("#hat_link").val(response.hat_link);
            $("#hat_image").html(
              `<img src="storage/images/${response.hat_image}" width="100" class="img-fluid img-thumbnail">`);
            $("#update_hat_id").val(response.id);
            $("#update_hat_image").val(response.hat_image);
          }
        });
      });

      // view hat ajax request
      $(document).on('click', '.viewIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: '{{ route('view') }}',
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
            $("#hat_name").val(response.hat_name);
            $("#hat_desc").val(response.hat_desc);
            $("#hat_link").val(response.hat_link);
            $("#hat_image").html(
              `<img src="storage/images/${response.hat_image}" width="100" class="img-fluid img-thumbnail">`);
            $("#view_hat_id").val(response.id);
            $("#view_hat_image").val(response.hat_image);
          }
        });
      });

      // update hat ajax request
      $("#edit_hat_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_hat_btn").text('Updating...');
        $.ajax({
          url: '{{ route('update') }}',
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Hat Updated Successfully!',
                'success'
              )
              fetchAllHats();
            }
            $("#edit_hat_btn").text('Update Hat');
            $("#edit_hat_form")[0].reset();
            $("#editHatModal").modal('hide');
          }
        });
      });

      // delete hat ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?\n DELETE this Hat?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '{{ route('delete') }}',
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your Hats has been deleted.',
                  'success'
                )
                fetchAllHats();
              }
            });
          }
        })
      });

      // fetch all hats ajax request
      fetchAllHats();

      function fetchAllHats() {
        $.ajax({
          url: '{{ route('read') }}',
          method: 'get',
          success: function(response) {
            $("#show_all_hats").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
</body>

</html>