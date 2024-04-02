<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Config Manager </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container p-1 mt-2">
    <!-- Message -->
    <div id="message" class="alert " style="display: none"></div>

    {{-- <div class="btn-group">
      <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        Chose Config File </button>
      <div class="dropdown-menu">
        @foreach ($configFiles as $file)
          <a class="dropdown-item" href="#" onclick="getConfigData({{ $file['text'] }})"> {{ $file['text'] }}</a>
        @endforeach
      </div>
    </div> --}}

    <select class="dropdown" id="mySelect" name="configName">

      @foreach ($configFiles as $file)
        <option value="{{ $file['text'] }}"
          {{ $file['text'] == config('quickadmin.selected_config_file') ? 'selected' : '' }}>
          {{ $file['text'] }}
        </option>
      @endforeach
    </select>

    <button class="btn btn-success mb-1" data-toggle="modal" data-target="#addModal">Add Key</button>

    <table id="responseTable" class="table">
      <thead>
        <tr>
          <th>Key</th>
          <th>Value</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <!-- Data will be populated here -->
      </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Key</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form id="editForm">
              <div class="form-group">
                <label for="editKey">Key:</label>
                <input type="text" class="form-control" id="editKey" readonly>
              </div>
              <div class="form-group">
                <label for="editValue">Value:</label>
                <input type="text" class="form-control" id="editValue">
              </div>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal" id="deleteModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Delete Data</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <p id="deleteModalMessage">Are you sure you want to delete key: <span
                class="text-danger font-weight-bold"></span> ?</p>
            <form id="deleteForm">
              <input type="hidden" id="keydel" name=”key” value="hhhhh">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Add Modal -->
    <div class="modal" id="addModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add Data</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form id="addForm">
              <div class="form-group">
                <label for="newKey">Key:</label>
                <input type="text" class="form-control" id="newKey">
              </div>
              <div class="form-group">
                <label for="newValue">Value:</label>
                <input type="text" class="form-control" id="newValue">
              </div>
              <button type="submit" class="btn btn-success">Add</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script defer>
    $(document).ready(function() {

      function setupAjax() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      }

      function notification(res) {
        $("#message").removeClass('alert-success alert-danger')
          .addClass(res.success ? "alert-success" : "alert-danger")
          .text(res.message).show()
          .delay(6000).fadeOut();
      }

      function handleSuccess(res) {
        notification(res)
        populateTable(res)
      }

      function handleError(err) {
        $("#message").removeClass('alert-success alert-danger')
          .addClass("alert-danger")
          .text(err).show()
          .delay(10000).fadeOut();
      }

      function getConfigData(configName) {
        $.ajax({
          type: 'POST',
          url: `{{ route('configs.getdata') }}`,
          data: {
            configName: configName
          },
          success: handleSuccess,
          error: handleError
        });
      }

      function populateTable(response) {
        $("#tbody").empty();
        //console.log(response.data);
        $.each(response.data, function(key, value) {
          const row = `<tr>
          <td>${key}</td>
          <td>${value}</td>
          <td>
          <button class='btn btn-primary editButton' data-toggle='modal' data-target='#editModal' data-key='${key}'>Edit</button>
          <button class='btn btn-danger deleteButton' data-toggle='modal' data-target='#deleteModal' data-key='${key}'>Delete</button>
          </td>
          </tr>`;
          //console.log(row);
          $("#tbody").append(row);
        });

        $(".editButton").click(function() {
          const key = $(this).closest("tr").find("td:first").text();
          const val = $(this).closest("tr").find("td:eq(1)").text();
          $("#editKey").val(key);
          $("#editValue").val(val);
        });

        $(".deleteButton").click(function() {
          const key = $(this).closest("tr").find("td:first").text();
          $("#keydel").val(key);
          $("#deleteModalMessage span").text(key);
        });
      }

      function sendAjaxRequest(url, data, successCallback) {
        $.ajax({
          type: 'POST',
          url: url,
          data: data,
          success: successCallback,
          error: handleError
        });
      }

      $("#mySelect").change(function() {
        getConfigData($(this).val());
      });

      $("#addForm").submit(function(event) {
        event.preventDefault();
        const newKey = $("#newKey").val();
        const newValue = $("#newValue").val();
        const configName = $("#mySelect").val();
        sendAjaxRequest(
          "{{ route('configs.store') }}", {
            key: newKey,
            value: newValue,
            configName: configName
          },
          handleSuccess
        );

        $("#addModal").modal('hide');
      });

      $("#editForm").submit(function(event) {
        event.preventDefault();
        const key = $("#editKey").val();
        const newValue = $("#editValue").val();
        const configName = $("#mySelect").val();
        sendAjaxRequest("{{ route('configs.update') }}", {
            key: key,
            value: newValue,
            configName: configName
          },
          handleSuccess);

        $("#editModal").modal('hide');
      });

      $("#deleteForm").submit(function(event) {
        event.preventDefault();
        const key = $("#keydel").val();
        const configName = $("#mySelect").val();
        sendAjaxRequest("{{ route('configs.delete') }}", {
          key: key,
          configName: configName
        }, handleSuccess);

        $("#deleteModal").modal('hide');
      });

      // Initial setup
      setupAjax();
      getConfigData($("#mySelect").val());
    });
  </script>
</body>

</html>
