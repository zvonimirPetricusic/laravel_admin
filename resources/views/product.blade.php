@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="carouselContainer" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" id="carouselImages">

                </div>
                <a class="carousel-control-prev" href="#carouselContainer" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselContainer" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <div class="row">
      <div class="col-md-6">
        <div>
          <h1>Product Details</h1>
          <hr>
        </div>
        <div>
          <p id="product_description"></p>
          <h5>Category: <span id="product_category"></span></h5>
          <h3>Price: <span id="product_price"></span></h3>
        </div>
      </div>
    </div>
  </div>
  <hr>

  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body"> 
                  <form enctype="multipart/form-data" id="commentForm">
                    <div class="form-group">
                      <label for="name" class="col-form-label">Comment</label>
                      <textarea name="comment" id="comment" class="form-control" rows="5" placeholder="Please enter comment"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="comment">Comment</button>
                  </form>
                    <hr>
                  <div id="commentsContainer">

                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
<!-- JS -->
<script src="{{ asset('js/product.js') }}"></script>
@endsection
