@include('layouts.header')

<div class="container">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-sm-6">
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('Questionnaires.index') }}">Questionnaires</a></li>
              <li class="breadcrumb-item active">Questions</li> Page
            </ol>
          </div>
        </div>

        <div class="row justify-content-center mb-3">
          <div class="col-md-12 col-md-offset-0">
              <div>
                <a href="#" class="add-modal">
                  <button type="submit" class="btn btn-warning pull-right">
                    <span class="glyphicon glyphicon-pencil"></span> Add a record
                  </button>
                </a>
              </div>
              <div style="both:clear;"></div><br /><br />
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <ul>
                          <li><i class="fa fa-file-text-o"></i> All the current Records in Questionnaire <?php echo $_GET['questionnaire_id']; ?></li>
                      </ul>
                  </div>

                  <div class="panel-body">
                          <table class="table table-striped table-bordered table-hover" id="recordTable" style="visibility: hidden;">
                              <thead>
                                  <tr>
                                      <th valign="middle">#</th>
                                      <th>Question_Text</th>
                                      <th>Date</th>
                                      <th>Type</th>
                                      <th>Actions</th>
                                  </tr>
                                  {{ csrf_field() }}
                              </thead>
                              <tbody>
                                  @foreach($Questions as $indexKey => $record)
                                      <tr class="item{{ $record->id }}">
                                          <td class="col1" width=60>{{ $indexKey + 1 }}</td>
                                          <td>{{ $record->question_text }}</td>
                                          <td width=100>{{ $record->question_date }}</td>
                                          <td>{{ $record->question_type }}</td>
                                          <td width=180>
                                            <form action="{{ route('Options.index') }}" method="GET" style="display: block;">
                                              <button class="show-modal btn btn-sm btn-success" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-text="{{ $record->question_text }}" data-date="{{ $record->question_date }}" data-type="{{ $record->question_type }}">
                                              <span class="glyphicon glyphicon-eye-open"></span></button>
                                              <button class="edit-modal btn btn-sm btn-info" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-text="{{ $record->question_text }}" data-date="{{ $record->question_date }}" data-type="{{ $record->question_type }}">
                                              <span class="glyphicon glyphicon-edit"></span></button>
                                              <button class="delete-modal btn btn-sm btn-danger" onclick="event.preventDefault();" data-id="{{ $record->id }}" data-text="{{ $record->question_text }}" data-date="{{ $record->question_date }}" data-type="{{ $record->question_type }}">
                                              <span class="glyphicon glyphicon-trash"></span></button>
                                              <?php if ($record->question_type == 'option') { ?>
                                              <button class="btn btn-sm btn-success">
                                              <span class='glyphicon glyphicon-th-list'></span></button>
                                              <input type="hidden" class="form-control" name="question_id" value="{{ $record->id }}" />
                                              <input type="hidden" class="form-control" name="questionnaire_id" value="{{ $questionnaire_id }}" />
                                              <?php } ?>
                                            </form>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                  </div><!-- /.panel-body -->
              </div><!-- /.panel panel-default -->
          </div><!-- /.col-md-12 -->

          <?php
            $types = ['textarea','string','option','number','date','time','datetime','canvas'];
           ?>

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
                                  <label class="control-label col-sm-2" for="parent">Parent#:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="id_add" name="questionnaire_id" value="<?php echo $_GET['questionnaire_id'] ?>" readonly />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="text">Text:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="text_add" autofocus />
                                      <small>Min: 2, Max: 250, only text</small>
                                      <p class="errorName text-center alert alert-danger hidden"></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="date">Date:</label>
                                  <div class="col-sm-10">
                                      <input type="date" class="form-control" id="date_add" />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="type">Type:</label>
                                  <div class="col-sm-10">
                                      <select name="question_type" class="form-control" id="type_add">
                                        <option></option>
                                        <?php
                                         foreach ($types as $key) {
                                         ?>
                                         <option value="<?php echo $key; ?>" > <?php echo $key; ?></option>
                                        <?php
                                         }
                                         ?>
                                      </select>
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
                                  <label class="control-label col-sm-2" for="text">Text:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="text_show" disabled />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="date">Date:</label>
                                  <div class="col-sm-10">
                                      <input type="date" class="form-control" id="date_show" disabled />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="type">Type:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="type_show" disabled />
                                  </div>
                              </div>
                          </form>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-warning" data-dismiss="modal">
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
                                  <label class="control-label col-sm-2" for="text">Text:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="text_edit" autofocus />
                                      <p class="errorName text-center alert alert-danger hidden"></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="date">Date:</label>
                                  <div class="col-sm-10">
                                      <input type="date" class="form-control" id="date_edit" />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="type">Type:</label>
                                  <div class="col-sm-10">
                                      <input type="hidden" class="form-control" id="option" />
                                      <select name="question_type" class="form-control" id="type_edit">
                                        <option></option>
                                        <?php
                                         foreach ($types as $key) {
                                         ?>
                                         <option value="<?php echo $key; ?>" > <?php echo $key; ?></option>
                                        <?php
                                         }
                                         ?>
                                      </select>
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
                                  <label class="control-label col-sm-2" for="text">Text:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="text_delete" disabled />
                                      <p class="errorName text-center alert alert-danger hidden"></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="date">Date:</label>
                                  <div class="col-sm-10">
                                      <input type="date" class="form-control" id="date_delete" disabled />
                                  </div>
                              </div>
                              <div class="form-group">
                                  <label class="control-label col-sm-2" for="type">Type:</label>
                                  <div class="col-sm-10">
                                      <input type="text" class="form-control" id="type_delete" disabled />
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

<!-- AJAX CRUD operations -->

<script type="text/javascript">
    // add a new record
    $(document).on('click', '.add-modal', function() {
        // Empty input fields
        $('#text_add')       .val('');
        $('#date_add')       .val('');
        $('#type_add')       .val('');
        $('.modal-title')    .text('Add');
        $('#addModal')       .modal('show');
    });
    $('.modal-footer').on('click', '.add', function() {
        $.ajax({
            type: 'POST',
            url: 'Questions',
            data: {
                '_token'             : $('input[name=_token]').val(),
                'question_text'      : $('#text_add').val(),
                'question_date'      : $('#date_add').val(),
                'question_type'      : $('#type_add').val(),
                'questionnaire_id'   : $('#id_add').val(),
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
                    +                       '' + "<tr class='item"
                    + data.id                  + "'><td class='col1'>"
                    + data.id                  + "</td><td>"
                    + data.question_text       + "</td><td>"
                    + data.question_date       + "</td><td>"
                    + data.question_type       + "</td><td>"
                    +                       '' + "<button class='show-modal btn btn-sm btn-success' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'>"
                    +                       '' + "<span class='glyphicon glyphicon-eye-open'></span></button> "
                    +                       '' + "<button class='edit-modal btn btn-sm btn-info' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'>"
                    +                       '' + "<span class='glyphicon glyphicon-edit'></span></button> "
                    +                       '' + "<button class='delete-modal btn btn-sm btn-danger' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'>"
                    +                       '' + "<span class='glyphicon glyphicon-trash'></span></button> "
                    +                       '' + "</td></tr>"
                    );

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
        $('#text_show')      .val($(this).data('text'));
        $('#date_show')      .val($(this).data('date'));
        $('#type_show')      .val($(this).data('type'));
        $('#showModal')      .modal('show');
    });

    // Edit a record
    $(document).on('click', '.edit-modal', function() {
        $('.modal-title')    .text('Edit');
        $('#id_edit')        .val($(this).data('id'));
        $('#text_edit')      .val($(this).data('text'));
        $('#date_edit')      .val($(this).data('date'));
        $('#selected')       .val($(this).data('type'));
        option = $('#option').val();
        $("#type_edit")      .val(option).change();
        id = $('#id_edit')   .val();
        $('#editModal')      .modal('show');
    });
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'PUT',
            url: 'Questions/' + id,
            data: {
                '_token'             : $('input[name=_token]').val(),
                'id'                 : $("#id_edit").val(),
                'question_text'      : $('#text_edit').val(),
                'question_date'      : $('#date_edit').val(),
                'question_type'      : $('#type_edit').val(),
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
                    +                       '' + "<tr class='item"
                    + data.id                  + "'><td class='col1'>"
                    + data.id                  + "</td><td>"
                    + data.question_text       + "</td><td>"
                    + data.question_date       + "</td><td>"
                    + data.question_type       + "</td><td>"
                    +                       '' + "<button class='show-modal btn btn-sm btn-success' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'><span class='glyphicon glyphicon-eye-open'></span></button> "
                    +                       '' + "<button class='edit-modal btn btn-sm btn-info' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'><span class='glyphicon glyphicon-edit'></span></button> "
                    +                       '' + "<button class='delete-modal btn btn-sm btn-danger' onclick='event.preventDefault();' data-id='"
                    + data.id                  + "' data-text='"
                    + data.question_text       + "' data-date='"
                    + data.question_date       + "' data-type='"
                    + data.question_type       + "'><span class='glyphicon glyphicon-trash'></span></button> "
                    +                       '' + "</td></tr>"
                    );

                    $('.col1').each(function (index) {
                        $(this).html(index+1);
                    });
                }
            }
        });
    });

    // delete a record
    $(document).on('click', '.delete-modal', function() {
        $('.modal-title')    .text('Delete');
        $('#id_delete')      .val($(this).data('id'));
        $('#text_delete')    .val($(this).data('text'));
        $('#date_delete')    .val($(this).data('date'));
        $('#type_delete')    .val($(this).data('type'));
        $('#deleteModal')    .modal('show');
        id = $('#id_delete') .val();
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'DELETE',
            url: 'Questions/' + id,
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
