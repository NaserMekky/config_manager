<!DOCTYPE html>
<html>
<head>
    <title>Create  Mudul</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h2>Create Mudul </h2>
    <form action="{{  route('quick.store') }}" method="POST" >
        @csrf

        <div class="form-group">
            <label for="model_name"> Model Name:</label>
            <input type="text" class="form-control" id="model_name" name="model_name">
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
