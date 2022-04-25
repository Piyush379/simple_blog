<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
      <br><br> 
      <div class="container">
      <form  action="register" method="POST" enctype="multipart/form-data">
@csrf
<div class="mb-3">
  <label class="form-label">Name</label>
  <input type="text" name="name" class="form-control" >
  <span  style="color:red;">@error('name'){{$message}}@enderror</span><br>

</div>

<div class="mb-3">
  <label  class="form-label">Email address</label>
  <input type="email" name="email" class="form-control"  aria-describedby="emailHelp">
  <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  <span  style="color:red;">@error('email'){{$message}}@enderror</span><br>

</div>

<div class="mb-3">
  <label class="form-label">Password</label>
  <input type="password" name="password" class="form-control">
  <span  style="color:red;">@error('password'){{$message}}@enderror</span>
</div>

<div class="mb-3">
  <label class="form-label">Profile pic</label>
  <input type="file" name="pic" class="form-control" ></input>
  <span  style="color:red;">@error('pic'){{$message}}@enderror</span><br>

</div>

<button type="submit" class="btn btn-primary">Submit</button><br><br>
Already user <a href="login">login</a>

</form>
      </div>


  

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>