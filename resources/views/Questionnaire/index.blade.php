@include('layouts.header')

<div class="container">
    <div class="row justify-content-center mb-3">

    <div class="col-md-12 col-md-offset-0">
      <?php if ( Auth::user()->type == 'author' || Auth::user()->type == 'admin' ) { ?>
        <h3 class="text-center">Manage Questionnaires</h3>
      <?php } else { ?>
        <h3 class="text-center">View Questionnaires</h3>
      <?php } ?>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <ul>
                    <li><i class="fa fa-file-text-o"></i> All the current Records</li>
                      <?php if (Auth::user()->type == 'author' || Auth::user()->type == 'admin') { ?>
                        <a href="#" class="add-modal"><li><button class="btn btn-sm btn-danger">
                        <span class="glyphicon glyphicon-pencil"></span> Add a record</button></li></a>
                      <?php } ?>
                    <a href="{{ route('home') }}" class="home-modal"><li><button class="home-modal btn btn-sm btn-info">
                    <span class="glyphicon glyphicon-log-out"></span> Home</button></li></a>
                </ul>
            </div>

            <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="recordTable" style="visibility: hidden;">
                        <thead>
                            <tr>
                                <th valign="middle">#</th>
                                <th>Name</th>
                                <th>Date_Start</th>
                                <th>Date_End</th>
                                <?php if ( Auth::user()->type == 'author' || Auth::user()->type == 'admin' ) { ?>
                                  <th>Published?</th>
                                  <th>Last_Updated</th>
                                <?php } ?>
                                <th>Actions</th>
                            </tr>
                            {{ csrf_field() }}
                        </thead>
                        <tbody>
                            @foreach($Questionnaires as $indexKey => $record)
                                <tr class="item{{$record->id}} @if($record->is_published) warning @endif">
                                    <td class="col1" width=60>{{ $indexKey + 1 }}</td>
                                    <td>{{ $record->questionnaire_name }}</td>
                                    <td width=100>{{ $record->questionnaire_date_start }}</td>
                                    <td width=100>{{ $record->questionnaire_date_end }}</td>
                                    <?php if ( Auth::user()->type == 'author' || Auth::user()->type == 'admin' ) { ?>
                                      <td class="text-center">
                                        <?php
                                          $is_published = isset($record->is_published) ? $record->is_published : null;
                                         ?>
                                        <input type="checkbox" class="published" id="" data-id="{{ $record->id }}" @if ($is_published) checked @endif >
                                      </td>
                                      <td width=120>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $record->updated_at)->diffForHumans() }}</td>
                                    <?php } ?>
                                    <td width=180>

                                      <?php if ( Auth::user()->type == 'author' || Auth::user()->type == 'admin' )  { ?>

                                        <form action="{{ route('Questions.index') }}" method="GET" style="display: block;">
                                          <button class="show-modal btn btn-sm btn-success" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-name="{{ $record->questionnaire_name }}" data-date_start="{{ $record->questionnaire_date_start }}" data-date_end="{{ $record->questionnaire_date_end }}">
                                          <span class="glyphicon glyphicon-eye-open"></span></button>
                                          <button class="edit-modal btn btn-sm btn-info" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-name="{{ $record->questionnaire_name }}" data-date_start="{{ $record->questionnaire_date_start }}" data-date_end="{{ $record->questionnaire_date_end }}">
                                          <span class="glyphicon glyphicon-edit"></span></button>
                                          <button class="delete-modal btn btn-sm btn-danger" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-name="{{ $record->questionnaire_name }}" data-date_start="{{ $record->questionnaire_date_start }}" data-date_end="{{ $record->questionnaire_date_end }}">
                                          <span class="glyphicon glyphicon-trash"></span></button>
                                          <button class="btn btn-sm btn-success" type="submit">
                                          <span class='glyphicon glyphicon-th-list'></span></button>
                                          <input type="hidden" class="form-control" name="questionnaire_id" value="{{ $record->id }}" />
                                        </form>

                                      <?php } else { ?>

                                        <form action="{{ route('Replies.index') }}" method="GET" style="display: block;">
                                          <button class="btn btn-success" type="submit">
                                            <span class='glyphicon glyphicon-th'></span> Reply
                                          </button>
                                          <input type="hidden" class="form-control" name="questionnaire_id" value="{{$record->id}}" />
                                        </form>

                                      <?php } ?>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-default -->
    </div><!-- /.col-md-8 -->

    <!-- Modal form to add a record -->
    <div id="addModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_add" autofocus />
                                <small>Min: 2, Max: 250, only text</small>
                                <p class="errorName text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_start">Start_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_start_add" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_end">End_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_end_add" />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success add" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-check'></span> Add
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to show a record -->
    <div id="showModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_show" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_show" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_start">Start_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_start_show" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_end">End_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_end_show" disabled />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" onclick="event.preventDefault();" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to edit a form -->
    <div id="editModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_edit" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_edit" autofocus />
                                <p class="errorName text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_start">Start_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_start_edit" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_end">End_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_end_edit" />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Edit
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal form to delete a form -->
    <div id="deleteModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure you want to delete the following record?</h3>
                    <br />
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="id_delete" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name_delete" disabled />
                                <p class="errorName text-center alert alert-danger hidden"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_start">Start_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_start_delete" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="date_end">End_At:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="date_end_delete" disabled />
                            </div>
                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                        </button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                            <span class='glyphicon glyphicon-remove'></span> Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

<!-- Bootstrap JavaScript -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>

<!-- toastr notifications -->
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- icheck checkboxes -->
<script type="text/javascript" src="{{ asset('icheck/icheck.min.js') }}"></script>

<!-- signature pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

<!-- Delay table load until everything else is loaded -->
<script>
    $(window).load(function(){
        $('#recordTable').removeAttr('style');
    })
</script>

<script>
    $(document).ready(function(){
        $('.published').iCheck({
            checkboxClass: 'icheckbox_square-yellow',
            radioClass: 'iradio_square-yellow',
            increaseArea: '20%'
        });
        $('.published').on('ifClicked', function(event){
            id = $(this).data('id');
            $.ajax({
                type: 'POST',
                url: "{{ URL::route('changeStatus') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'id': id
                },
                success: function(data) {
                    // empty
                },
            });
        });
        $('.published').on('ifToggled', function(event) {
            $(this).closest('tr').toggleClass('warning');
        });
    });
</script>

<!-- AJAX CRUD operations -->

<script type="text/javascript">
    // add a new record
    $(document).on('click', '.add-modal', function() {
        // Empty input fields
        $('#name_add')      .val('');
        $('#date_start_add').val('');
        $('#date_end_add')  .val('');
        $('.modal-title')   .text('Add');
        $('#addModal')      .modal('show');
    });
    $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'POST',
            url: 'Questionnaires',
            data: {
                '_token'                   : $('input[name=_token]').val(),
                'questionnaire_name'       : $('#name_add').val(),
                'questionnaire_date_start' : $('#date_start_add').val(),
                'questionnaire_date_end'   : $('#date_end_add').val(),
            },
            success: function(data) {
                $('.errorName').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#addModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 15000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }
                } else {
                    toastr.success('Successfully added record!', 'Success Alert', {timeOut: 15000});
                    $('#recordTable').prepend(
                    +                            '' + "<tr class='item"
                    + data.id                       + "'><td class='col1'>"
                    + data.id                       + "</td><td>"
                    + data.questionnaire_name       + "</td><td>"
                    + data.questionnaire_date_start + "</td><td>"
                    + data.questionnaire_date_end   + "</td><td class='text-center'>"
                    +                            '' + "<input type='checkbox' class='new_published' data-id='"
                    + data.id                       + "'></td><td>Just now!</td><td>"
                    +                            '' + "<button class='show-modal btn btn-sm btn-success' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'>"
                    +                            '' + "<span class='glyphicon glyphicon-eye-open'></span></button> "
                    +                            '' + "<button class='edit-modal btn btn-sm btn-info' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'>"
                    +                            '' + "<span class='glyphicon glyphicon-edit'></span></button> "
                    +                            '' + "<button class='delete-modal btn btn-sm btn-danger' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'>"
                    +                            '' + "<span class='glyphicon glyphicon-trash'></span></button> "
                    +                            '' + "</td></tr>"
                    );

                    $('.new_published').iCheck({
                        checkboxClass: 'icheckbox_square-yellow',
                        radioClass: 'iradio_square-yellow',
                        increaseArea: '20%'
                    });
                    $('.new_published').on('ifToggled', function(event){
                        $(this).closest('tr').toggleClass('warning');
                    });
                    $('.new_published').on('ifChanged', function(event){
                        id = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::route('changeStatus') }}",
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': id
                            },
                            success: function(data) {
                                // empty
                            },
                        });
                    });
                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            },
        });
    });

    // Show a record
    $(document).on('click', '.show-modal', function() {
        $('.modal-title')    .text('Show');
        $('#id_show')        .val($(this).data('id'));
        $('#name_show')      .val($(this).data('name'));
        $('#date_start_show').val($(this).data('date_start'));
        $('#date_end_show')  .val($(this).data('date_end'));
        $('#showModal')      .modal('show');
    });

    // Edit a record
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title')    .text('Edit');
        $('#id_edit')        .val($(this).data('id'));
        $('#name_edit')      .val($(this).data('name'));
        $('#date_start_edit').val($(this).data('date_start'));
        $('#date_end_edit')  .val($(this).data('date_end'));
        id = $('#id_edit')   .val();
        $('#editModal')      .modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'PUT',
            url: 'Questionnaires/' + id,
            data: {
                '_token'                   : $('input[name=_token]').val(),
                'id'                       : $("#id_edit").val(),
                'questionnaire_name'       : $('#name_edit').val(),
                'questionnaire_date_start' : $('#date_start_edit').val(),
                'questionnaire_date_end'   : $('#date_end_edit').val(),
            },
            success: function(data) {
                $('.errorName').addClass('hidden');

                if ((data.errors)) {
                    setTimeout(function () {
                        $('#editModal').modal('show');
                        toastr.error('Validation error!', 'Error Alert', {timeOut: 15000});
                    }, 500);

                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }
                } else {
                    toastr.success('Successfully updated Record!', 'Success Alert', {timeOut: 15000});
                    $('.item' + data.id).replaceWith(
                    +                            '' + "<tr class='item"
                    + data.id                       + "'><td class='col1'>"
                    + data.id                       + "</td><td>"
                    + data.questionnaire_name       + "</td><td>"
                    + data.questionnaire_date_start + "</td><td>"
                    + data.questionnaire_date_end   + "</td><td class='text-center'>"
                    +                            '' + "<input type='checkbox' class='edit_published' data-id='"
                    + data.id                       + "'></td><td>Right now!</td><td>"
                    +                            '' + "<button class='show-modal btn btn-sm btn-success' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'><span class='glyphicon glyphicon-eye-open'></span></button> "
                    +                            '' + "<button class='edit-modal btn btn-sm btn-info' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'><span class='glyphicon glyphicon-edit'></span></button> "
                    +                            '' + "<button class='delete-modal btn btn-sm btn-danger' onclick='event.preventDefault();' data-id='"
                    + data.id                       + "' data-name='"
                    + data.questionnaire_name       + "' data-date_start='"
                    + data.questionnaire_date_start + "' data-date_end='"
                    + data.questionnaire_date_end   + "'><span class='glyphicon glyphicon-trash'></span></button> "
                    +                            '' + "</td></tr>"
                    );

                    if (data.is_published) {
                        $('.edit_published').prop('checked', true);
                        $('.edit_published').closest('tr').addClass('warning');
                    }
                    $('.edit_published').iCheck({
                        checkboxClass: 'icheckbox_square-yellow',
                        radioClass: 'iradio_square-yellow',
                        increaseArea: '20%'
                    });
                    $('.edit_published').on('ifToggled', function(event) {
                        $(this).closest('tr').toggleClass('warning');
                    });
                    $('.edit_published').on('ifChanged', function(event){
                        id = $(this).data('id');
                        $.ajax({
                            type: 'POST',
                            url: "{{ URL::route('changeStatus') }}",
                            data: {
                                '_token': $('input[name=_token]').val(),
                                'id': id
                            },
                            success: function(data) {
                                // empty
                            },
                        });
                    });
                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            }
        });
    });

    // delete a record
    $(document).on('click', '.delete-modal', function() {
        $('.modal-title')      .text('Delete');
        $('#id_delete')        .val($(this).data('id'));
        $('#name_delete')      .val($(this).data('name'));
        $('#date_start_delete').val($(this).data('date_start'));
        $('#date_end_delete')  .val($(this).data('date_end'));
        $('#deleteModal')      .modal('show');
        id = $('#id_delete')   .val();
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'DELETE',
            url: 'Questionnaires/' + id,
            data: {
                '_token': $('input[name=_token]').val(),
            },
            success: function(data) {
                toastr.success('Successfully deleted Record!', 'Success Alert', {timeOut: 15000});
                $('.item' + data['id']).remove();
                $('.col1').each(function (index) {
                    $(this).html(index+1);
                });
            }
        });
    });
</script>

@include('layouts.footer')
