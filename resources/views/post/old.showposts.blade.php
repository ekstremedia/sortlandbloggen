@extends('layouts.app')

@section('content')

<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <form method="post" action="{{url('postSubmit')}}" accept-charset="UTF-8">
        <input name="_token" type="hidden" value="{{ csrf_token() }}">
        <input name="post_id" type="hidden" value="">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="Post title" required>
                            <small id="helpId" class="form-text text-muted">Title of your post</small>
                        </div>
                        <div class="form-group">
                            <label for="post">Post</label>
                            <textarea placeholder="Post body" class="form-control" name="post" id="post" rows="3" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-12">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit"><i class="fas fa-plus"></i> New post</button>
    </div>
    <div class="col-6 pt-1">
        <table class="table table-striped table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Title</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td scope="row">{{ $post->title }}</td>
                    <td>{{ $post->created_at }}</td>
                    <td> <div class="dropdown open">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                    Action
                                </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" href="#">Edit</button>
                            <button class="dropdown-item" href="#">Delete</button>
                        </div>
                    </div> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@section('scripts')
<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM

    });

    $(document).ready(function() {
  /**
   * for showing edit item popup
   */

  $(document).on('click', "#edit-item", function() {
    $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

    var options = {
      'backdrop': 'static'
    };
    $('#edit-modal').modal(options)
  })

  // on modal show
  $('#edit-modal').on('show.bs.modal', function() {
    var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
    var row = el.closest(".data-row");

    // get the data
    var id = el.data('item-id');
    var name = row.children(".name").text();
    var description = row.children(".description").text();

    // fill the data in the input fields
    $("#modal-input-id").val(id);
    $("#modal-input-name").val(name);
    $("#modal-input-description").val(description);

  })

  // on modal hide
  $('#edit-modal').on('hide.bs.modal', function() {
    $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
    $("#edit-form").trigger("reset");
  })
})

</script>
@stop

@endsection