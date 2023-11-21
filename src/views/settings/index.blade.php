<!DOCTYPE html>
<html>
<head>
    <title>Config Keys</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <div class="container p-1">
        @if(config('quickadmin.add_config_key'))
        <button type="button" class="btn btn-primary m-1"
            data-toggle="modal"
            data-target="#settings_add"

            data-action="{{ route('settings.store') }}"
            data-method="PUT">Add New Key</button>
        @endif

        @isset($message)
        @foreach ($message as $key=>$value)
        <div class="alert alert-{{  $key == 'success' ? 'success':'danger' }}">
            {{ $value }}
        </div>
        @endforeach
        @endisset

        <select class="form-select" aria-label="">
            @foreach($options as $option)
            <option value="{{ $option['value']}}">
          {{ $option['text']}}
          </option>
            @endforeach
        </select>

        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($settings as $key=>$value)
                <tr>
                    @php
                    $ss = explode('.', $key);
                    @endphp
                    <td>{{ array_pop($ss) }}</td>
                    <td>{{ $value }}</td>
                    <td>


                        <button type="button" class="btn btn-primary btn-sm"
                            data-toggle="modal"
                            data-target="#settings_edit"
                            data-key="{{$key}}"
                            data-val=" {{$value}}"
                            data-action="{{ route('settings.update', $key) }}"
                            data-method="PUT">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm"
                            data-toggle="modal"
                            data-target="#settings_delete"
                            data-key="{{$key}}"
                            data-val=" {{$value}}"
                            data-action="{{ route('settings.destroy', $key) }}"
                            data-method="DELETE">Delete</button>


                    </td>
                </tr>
                @empty
                <tr><td colspan="3">Not Available Data</td></tr>
                @endforelse
            </tbody>
        </table>



        <div class="modal fade" id="settings_edit" tabindex="-1" role="dialog" aria-labelledby="settings ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form" method="POST">
                        @csrf
                        <input type="hidden" id="method" name="_method" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="value" class="col-form-label" id="l-key"></label>
                                <input type="text" class="form-control" id="key" name="value">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="settings_add" tabindex="-1" role="dialog" aria-labelledby="settings ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="value" class="col-form-label" id="l-key">Key:</label>
                                <input type="text" class="form-control" id="key" name="key">
                            </div>
                            <div class="form-group">
                                <label for="value" class="col-form-label" id="l-value">Value</label>
                                <input type="text" class="form-control" id="key" name="value">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="settings_delete" tabindex="-1" role="dialog" aria-labelledby="settings ModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form id="form" method="POST">
                        @csrf
                        <input type="hidden" id="method" name="_method" value="">
                        {{-- <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        --}}
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="value" class="col-form-label text-primary"> Are you sure to delete <span class="l-delete text-danger font-weight-bold"></span> ?</label>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>

        $('#settings_add').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var key = button.data('key');
            var value = button.data('val');
            var action = button.data('action');
            var method = button.data('method');

            var modal = $(this);
            modal.find('#l-key').text(key);
            modal.find('#key').val(value);
            modal.find('#form').prop("action", action);
            modal.find('#method').val(method);

            modal.find('.modal-title').text("Edit Config");
        });

        $('#settings_edit').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var key = button.data('key');
            var value = button.data('val');
            var action = button.data('action');
            var method = button.data('method');

            var modal = $(this);
            modal.find('#l-key').text(key);
            modal.find('#key').val(value);
            modal.find('#form').prop("action", action);
            modal.find('#method').val(method);

            modal.find('.modal-title').text("Edit Config");
        });

        $('#settings_delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var key = button.data('key');
            var value = button.data('val');
            var action = button.data('action');
            var method = button.data('method');

            var modal = $(this);
            modal.find('.l-delete').text(key);
            modal.find('#key').val(value);
            modal.find('#form').prop("action", action);
            modal.find('#method').val(method);

            modal.find('.modal-title').text("Edit Config");
        });

    </script>

</body>
</html>