<!DOCTYPE html>
<html>
<head>
    <title>Short Link</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <input type="hidden" name="app_url" id="app_url" value="{{ ENV('APP_URL') }}">
</head>
<body>

<div class="container" style="margin-top: 10px;">
    <h1>Create Short Link</h1>

    <div class="card">
      <div class="card-header">
        <form method="POST" action="{{ route('generate.shorten.link.post') }}">
            @csrf
            <div class="input-group mb-3">
              <input type="text" name="link" class="form-control" placeholder="Enter URL" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-success" type="submit">CreateShort Link</button>
              </div>
            </div>
        </form>
      </div>
      <div class="card-body">

              @if (Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ Session::get('success') }}</p>
                </div>
            @endif
           
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
              </div><br />
            @endif

            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Short Link</th>
                        <th>URL</th>
                        <th># Of Redirect</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shortLinks as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td><a href="{{ route('shorten.link', $row->code) }}" class="user_redirect" data-id="{{ $row->id }}" target="_blank">{{ route('shorten.link', $row->code) }}</a></td>
                            <td>{{ $row->link }}</td>
                            <td>{{ $row->url_open_count }}
                        </tr>
                    @endforeach
                </tbody>
            </table>
      </div>
    </div>
    
</div>
 
</body>
</html>

<script>

  $(".user_redirect").click(function(event){
      event.preventDefault();

      let url_id = $(this).attr("data-id")
      let _token   = $('meta[name="csrf-token"]').attr('content');
      let app_url = $('#app_url').val();    
      $.ajax({
        url: app_url + "/save-user-redirect",
        type:"POST",
        data:{
          url_id:url_id,
          _token: _token
        },
        success:function(response){
          console.log(response);
          if(response) {
            
           window.open(response.url, 'name'); 
          }
        },
       });
  });
</script>