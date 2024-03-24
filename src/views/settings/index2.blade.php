<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Config Manager </title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <div class="container p-1">
    <!-- Message -->
    <div id="message" class="alert alert-success d-none"></div>

    <select id="mySelect">

      @foreach($options as $option)
      <option value="{{ $option['text'] }}" {{ $option['text']==config('quickadmin.selected_config_file')? 'selected':'' }}>
        {{ $option['text']}}
      </option>
      @endforeach
    </select>

    <button class="btn btn-success" data-toggle="modal" data-target="#addModal">Add</button>

    <table id="responseTable" class="table">
      <thead>
        <tr>
          <th>Key</th>
          <th>Value</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Data will be populated here -->
      </tbody>
    </table>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Data</h4>
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
            <p id="deleteModalMessage"></p>
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
  <script>
    /**
    $(document).ready(function() {

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });


    function getConfigData(configName) {
    $.ajax({
    type: 'POST',
    url: "{{  route('naser')  }}",
    data: {
    option: configName
    },
    success: function(response) {
    //alert(response.message)
    //console.log(response);
    populateTable(response.data);
    },
    error: function(error) {
    console.error('Error:', error);
    }
    });
    }

    function populateTable(response) {

    $("#responseTable tbody").empty();

    $.each(response, function(key, value) {
    var row = "<tr>" +
    "<td>" + key + "</td>" +
    "<td>" + value + "</td>" +
    "<td>" +
    "<button class='btn btn-primary editButton' data-toggle='modal' data-target='#editModal' data-key='" + key +"' >Edit</button> " +
    "<button class='btn btn-danger deleteButton' data-toggle='modal' data-target='#deleteModal' data-key='"+ key +"' >Delete</button>" +
    "</td>" +
    "</tr>";
    $("#responseTable tbody").append(row);
    });

    $(".editButton").click(function() {
    var key = $(this).closest("tr").find("td:first").text();
    // Populate edit modal form with data
    $("#editKey").val(key);
    $("#editValue").val(response[key]);
    });

    $(".deleteButton").click(function() {
    var key = $(this).closest("tr").find("td:first").text();
    // Populate delete modal message with data
    $("input[name='key']").val(key);
    $("#deleteModalMessage").text("Are you sure you want to delete key: " + key + "?");
    });
    }

    getConfigData($("#mySelect").val())

    $("#mySelect").change(function() {
    getConfigData($(this).val());
    });

    $("#editForm").submit(function(event) {
    event.preventDefault();
    var key = $("#editKey").val();
    var newValue = $("#editValue").val();

    // Implement your logic to update the data on the server
    // This is a placeholder; replace it with your actual update logic
    // After updating, update the table data without reloading the page
    // Assuming your backend returns the updated data
    $.ajax({
    type: 'POST',
    url: "{{ route('naser.update') }}",
    data: {
    key: key, value: newValue
    },
    success: function(updatedResponse) {
    populateTable(updatedResponse);
    },
    error: function(error) {
    console.error('Error:', error);
    }
    });

    // Close the modal
    $("#editModal").modal('hide');
    });

    $("#deleteForm").submit(function(event) {
    event.preventDefault();
    var key = $("input[name='key']").val();
    var message = $("#message");
    // Implement your logic to delete the data on the server
    // This is a placeholder; replace it with your actual delete logic
    // After deleting, update the table data without reloading the page
    // Assuming your backend returns the updated data
    $.ajax({
    type: 'POST',
    url: "{{ route('naser.delete') }}",
    data: {
    key: key
    },
    success: function(updatedResponse) {
    message.toggleClass(" d-none d-block ").text(updatedResponse.message);
    //console.log
    // populateTable(updatedResponse);
    },
    error: function(error) {
    console.error('Error:', error);
    }
    });

    // Close the modal
    $("#deleteModal").modal('hide');
    });

    $("#addForm").submit(function(event) {
    event.preventDefault();
    var newKey = $("#newKey").val();
    var newValue = $("#newValue").val();

    // Implement your logic to add the new data on the server
    // This is a placeholder; replace it with your actual add logic
    // After adding, update the table data without reloading the page
    $.ajax({
    type: 'POST',
    url: "{{ route('naser.store')}}",
    data: {
    key: newKey, value: newValue
    },
    success: function(updatedResponse) {
    populateTable(updatedResponse);
    },
    error: function(error) {
    console.error('Error:', error);
    }
    });

    // Close the modal
    $("#addModal").modal('hide');
    });
    });
    **/
    $(document).ready(function() {

      const csrfToken = $('meta[name="csrf-token"]').attr('content');

      function setupAjax() {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': csrfToken
          }
        });
      }

      function getConfigData(configName) {
        $.ajax({
          type: 'POST',
          url: `{{ route('naser') }}`,
          data: {
            option: configName
          },
          success: populateTable,
          error: handleAjaxError
        });
      }

      function populateTable(response) {
        $("#responseTable tbody").empty();

        $.each(response.data, function(key, value) {
          const row = `<tr>
          <td>${key}</td>
          <td>${value}</td>
          <td>
          <button class='btn btn-primary editButton' data-toggle='modal' data-target='#editModal' data-key='${key}'>Edit</button>
          <button class='btn btn-danger deleteButton' data-toggle='modal' data-target='#deleteModal' data-key='${key}'>Delete</button>
          </td>
          </tr>`;
          $("#responseTable tbody").append(row);
        });

        $(".editButton").click(function() {
          const key = $(this).closest("tr").find("td:first").text();
          $("#editKey").val(key);
          $("#editValue").val(response[key]);
        });

        $(".deleteButton").click(function() {
          const key = $(this).closest("tr").find("td:first").text();
          $("#keydel").val(key);
          $("#deleteModalMessage").text(`Are you sure you want to delete key: ${key}?`);
        });
      }

      function handleAjaxError(error) {
        console.error('Error:', error);
      }

      function sendAjaxRequest(url, data, successCallback) {
        $.ajax({
          type: 'POST',
          url: url,
          data: data,
          success: successCallback,
          error: handleAjaxError
        });
      }

      $("#mySelect").change(function() {
        getConfigData($(this).val());
      });

      $("#editForm").submit(function(event) {
        event.preventDefault();
        const key = $("#editKey").val();
        const newValue = $("#editValue").val();

        sendAjaxRequest("{{ route('naser.update') }}", {
          key: key, value: newValue
        }, populateTable);

        $("#editModal").modal('hide');
      });

      $("#deleteForm").submit(function(event) {
        event.preventDefault();
        const key = $("#keydel").val();

        sendAjaxRequest("{{ route('naser.delete') }}", {
          key: key
        }, function(updatedResponse) {
          $("#message").toggleClass("d-none d-block").text(updatedResponse.message);
        });

        $("#deleteModal").modal('hide');
      });

      $("#addForm").submit(function(event) {
        event.preventDefault();
        const newKey = $("#newKey").val();
        const newValue = $("#newValue").val();

        sendAjaxRequest(
          "{{ route('naser.store') }}",
          {
            key: newKey, value: newValue
          },
          populateTable
        );

        $("#addModal").modal('hide');
      });

      // Initial setup
      setupAjax();
      getConfigData($("#mySelect").val());
    });

  </script>
</body>
</html>