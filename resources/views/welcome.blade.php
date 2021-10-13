<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>YOLytics</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="/css/app.css">
        <!-- Styles -->
        <style>
          
        </style>
    </head>
    <body>


<div class="container">


    <div class="row">
        <div class="col-7 mt-5">

            <img  src="{{asset('img/mainp2.png')}}" alt="" width="570" height="540">
        
        </div>


        <div class="col-5 mt-5">

            <img src="{{asset('img/unnamed.png')}}" alt="" width="460" height="140">
            <br>
            <br>
            <br><h4>Get insights of any Instagram profile<br> in the world, in seconds</h4>

            <p>Enter an Instagram username to find out its engagement rate,<br>
                top content, average likes, frequency of posts and many more</p>

            <form action="/instagram" method="GET" enctype="multipart/form-data">
            @csrf
            

            <br>
            <br>
            <div class="form-row align-items-center">
             
              <div class="col-8">
                <label class="sr-only" for="inlineFormInputGroup">Instagram Username</label>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                  </div>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Instagram Username">
                </div>
              </div>
              
              <div class="col-auto">
                <button type="submit" class="btn btn-outline-dark mb-2">Search</button>
              </div>
              @if (session('status'))
            
                 <p style="color: red">{{ session('status') }}</p> 
            
         @endif
              
            </div>
          </form>

     
        
        
        </div>


       


      </div>
    
    

    </div>
    <img class="float-right" style="margin-top: 70px" src="{{asset('img/logo3.jpeg')}}" width="80" height="80">

    </body>
</html>
