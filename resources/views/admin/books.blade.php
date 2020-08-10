@extends('layouts.dashboard_layout')
@section('content-header')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Books </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">books</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
 <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Books view</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                  <i class="fas fa-minus"></i></button>
              </div>
            </div>
        <form id="book_form" method="POST" action="{{route('add-book')}}">
            @csrf
            <div class="card-body">
              <div class="form-group">
                
                <label for="name">Name of book</label>
              <input type="text" name="name" id="name" class="form-control"/>
                        
              </div>

              <div class="form-group">
                
                <label for="author">Author</label>
              <input type="text" name="author" id="author" class="form-control"/>
                        
              </div>

              <div class="form-group">
                
                <label for="price">Price</label>
              <input type="text" name="price" id="price" class="form-control"/>
                        
              </div>

                <div class="form-group">
                
                <label for="price">Cover image</label>
              <input type="file" name="image" id="image"/>
                        
              </div>

               <div class="form-group">
                
                <label for="price">Book (pdf)</label>
              <input type="file" name="book" id="book"/>
                        
              </div>

              
                    
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="upload">Upload book</button>
              </div>
            </div>
          </form> 
            
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
       </div>
        <!-- /.row -->

          <div class="row">
           <div class="col-md-12">
            <div class="card">
            <div class="card-header">
              <h3 class="card-title">Books</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="table-responsive">
                 <table id="books_table" class="table_data table-bordered table-striped">
                <thead>
                <tr>
                  <th>id</th>
                  <th>Name</th>
                  <th>Author</th>
                  <th>Price</th>
                  <th>Image</th>
                  <th>Added on</th>
                  <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($books as $book)
                <tr>
                 <td>{{$book->id}}</td>
                <td>{{$book->name}}</td>
                <td>{{$book->author}}</td>
                <td>{{$book->price}}</td>
                <td><img src="{{asset('storage/'.$book->image)}}" width="40"/></td>
                  <td>{{$book->created_at}}</td>
                  <td> <button class="edit-book btn btn-primary" data-url="{{ route('get.book', ['book' => $book->id ]) }}">Edit book</button></td>
                </tr>      
                @empty
                    <p>No books found</p>
                @endforelse   
     
                </tfoot>
              </table>
              </div>
             
            </div>
            <!-- /.card-body -->
          </div>       
        </div> 
            
        </div>
        <!-- /.row -->

      </div><!-- /.container-fluid -->
@endsection

@section('script')
<script>
$(document).ready(function() {
    //handle book upload here
    $("#upload").click(function(e) {
        e.preventDefault();
        //var name = $(this).attr('data-id');
        const name = $("#name").val();
        const author = $("#author").val();
        const price = $("#price").val();
        if(name == ""){
          errorDisplay("Please enter the name of the book");
          return;
        }

        if(price == ""){
          errorDisplay("Please enter the price of the book");
          return;
        }

        if(author == ""){
          errorDisplay("Please enter the author of the book");
          return;
        }
        var fd = new FormData();
        var files = $('#image')[0].files[0];
        var book = $('#book')[0].files[0];
        //var files = $('input[type="file" id="payment_proof"]')[0].files;
        fd.append('image', files);
        fd.append('book', book);
        const myForm = $('form#book_form');
        //get other data inside the form
        var other_data = myForm.serializeArray();
          
        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
         swal({
                title: "Are you sure you want to upload this book?",
                text: "Users will be able to see, and attempt to buy this immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $('#upload').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            //let receiever = response.data.receiver;
                            successNoty(`Book was uploaded successfully`);
                            //$('#content-container').load(`${location.href} #content-container`);
                        })
                        .fail(failJson)
                        .always(() => $('#upload').html('Upload book'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });
        
    })


$(document).on('click', '.edit-book', function(e) {
    e.preventDefault();

    $(this).html('loading ...');
    $('#emptyModal').modal('show');
    $('#_empty_modal_content').html('loading ...');

    const url = $(this).data('url');

    $.get(url)
        .done((response) => {
            editBook(response.data);
        })
        .fail(failJson)
        .always(() => $(this).html('Edit'));
});

$(document).on('click', '#update-book', function(e) {
     e.preventDefault();
        let name = $("#name_update").val();
        let author = $("#author_update").val();
        let price = $("#price_update").val();
        if(name == ""){
          errorDisplay("Please enter the name of the book");
          return;
        }

        if(price == ""){
          errorDisplay("Please enter the price of the book");
          return;
        }

        if(author == ""){
          errorDisplay("Please enter the author of the book");
          return;
        }
        var fd = new FormData();
        var files = $('#image_update')[0].files[0];
        var book = $('#book_update')[0].files[0];
        if(files != ""){
          fd.append('image', files);
        }
        if(book != ""){
         fd.append('book', book);
        }
        
        const myForm = $('form#edit-book-form');
        //get other data inside the form
        var other_data = myForm.serializeArray();
          
        $.each(other_data, function(key, input) {
            fd.append(input.name, input.value);
        });
         swal({
                title: "Are you sure you want to update this book?",
                text: "Users will be able to see changes immediately",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((will) => {
                if (will) {
                    //user accepted starts here
                    $('#upload').html('Sending...');
                    $.ajax({
                            url: myForm.attr('action'),
                            data: fd,
                            type: 'POST',
                            contentType: false,
                            processData: false,
                        })
                        .done((response) => {
                            successNoty(`Book was updated successfully`);
                            //$('#content-container').load(`${location.href} #content-container`);
                        })
                        .fail(failJson)
                        .always(() => $('#upload').html('Upload proof'));
                    //use accepted ends here
                } else {
                    swal("Your action has been cancelled!");
                }
            });
        
    })

   
});

const editBook = (data) => {
    const form = $('#_empty_modal_content');
    form.html('');
    form.append(`
    <div class="card">
            <div class="card-header">
              <h3 class="card-title">Edit ${data.name}</h3>
            </div>
    <div class="card-body">
    <form id="edit-book-form" action="{{route('update-book')}}">@csrf <div class="card-body">
              <input type="hidden" name="id" value="${data.id}"/>
             <div class="form-group">
                  <label for="question">Book Name</label>
                <input name="name" class="form-control" value="${data.name}" id="name_update"/>        
              </div>

              <div class="form-group">
                 <label for="type">Author</label>
                <input text name="author" class="form-control" value="${data.author}" id="author_update"/>
              
              </div> 
              
              <div class="form-group">
                 <label for="type">Price</label>
                <input type="number" name="price" class="form-control" value="${data.price}"  id="price_update"/>        
              </div>
              
              <div class="form-group">
                 <label for="type">Cover image</label>
                <input type="file" name="image" class="form-control" id="image_update"/>
              
              </div>

               <div class="form-group">
                 <label for="type">Book file</label>
                <input type="file" name="book" class="form-control" id="book_update"/>
              
              </div>
              
              <div class="form-group">
                <button class="btn btn-primary btn-lg" id="update-book">Save</button>
              </div>
            </div>
          </form>
     </div>
    </div>       
    `);
};
</script>
@endsection