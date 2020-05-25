@include('layouts.header')

<div class="container">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-xs-0  col-sm-3 col-md-6">
          </div>
          <div class="col-xs-12 col-sm-9 col-md-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item"><a href="Questionnaires">Questionnaires</a></li>
              <li class="breadcrumb-item active">Reply Page</li>
            </ol>
          </div>
        </div>

        <div class="row justify-content-center mb-3">
          <div class="col-md-12 col-md-offset-0">
              <h4 class="text-left">
                <?php echo $Questionnaire = isset($Questionnaire->questionnaire_name) ? $Questionnaire->questionnaire_name : null; ?>
              </h4>
              <br />
              <?php
                $question_count = isset($Questions) ? count($Questions) : 0;
                $question_reply = isset($Replies  ) ? count($Replies  ) : 0;
                $current_number = 0;
               ?>
               <input type="hidden" class="form-control" id="question_count" name="question_count" value="{{ $question_count }}" />
               <input type="hidden" class="form-control" id="question_reply" name="question_reply" value="{{ $question_reply }}" />

              @foreach($Questions as $record)

              <?php
                $current_number++;
                $question_id = isset($record->id) ? $record->id : null;
                $question_type = isset($record->question_type) ? $record->question_type : null;
                $reply_text = null;
                foreach ($Replies as $rec) {
                  if ($rec['question_id'] == $question_id) {
                    $reply_text = isset($rec['reply_text']) ? $rec['reply_text'] : null;
                  }
                }
               ?>
              <input type="hidden" class="form-control" id="current_number" name="current_number" value="{{ $current_number }}" />

              <?php
                if ( ($question_count == $question_reply) || ($question_reply + 1 == $current_number) ) {
               ?>
              <div class="panel panel-default">
                  <div class="panel-heading">
                      <ul>
                          <li><i class="fa fa-file-text-o"></i> Question {{ $record->id }} : {{ $record->question_text }} </li>
                      </ul>
                  </div>

                  <div class="panel-body">
                      <form action="{{ route('Replies.store') }}" method="POST">
                        <?php
                          switch ($question_type) {
                            case 'textarea':
                         ?>
                         <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                         <textarea cols=120 rows=5 name="reply_text" class="form-control" <?php if ($reply_text) echo 'readonly' ?> required >
                           <?php
                            echo ($reply_text) ? htmlspecialchars($reply_text) : null;
                            ?>
                         </textarea>
                         </div>
                         <br />
                         <br />
                         <br />
                         <br />
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'string':
                         ?>
                         <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                         <input name="reply_text" type="text" class="form-control" value="<?php
                          echo ($reply_text) ? $reply_text : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required placeholder="Text" />
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'option':
                         ?>
                         <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                         <select name="reply_text" class="form-control" <?php if ($reply_text) echo 'disabled' ?> required >
                           <option></option>
                           <?php
                            foreach ($Options as $key) {
                              if ($key['question_id'] == $record->id) {
                            ?>
                            <option value="<?php echo $key['option_text']; ?>" <?php if ($reply_text == $key['option_text']) echo 'selected'; ?> > <?php echo $key['option_text']; ?></option>
                           <?php
                              }
                            }
                            ?>
                         </select>
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'number':
                         ?>
                         <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                         <input name="reply_text" type="number" class="form-control" value="<?php
                          echo ($reply_text) ? trim($reply_text) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required placeholder="Number" />
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'date':
                         ?>
                         <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                         <input name="reply_date" type="date" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required />
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'time':
                         ?>
                         <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                         <input name="reply_time" type="time" class="form-control" value="<?php
                          echo ($reply_text) ? date('H:i:s', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required />
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'datetime':
                         ?>
                         <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                         <input name="reply_date" type="date" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required />
                         </div>
                         <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                         <input name="reply_time" type="time" class="form-control" value="<?php
                          echo ($reply_text) ? date('H:i:s', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> required />
                         </div>
                         <br />
                         <br />
                         <br />
                         <div id="signature" style="display:none">
                           <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                         </div>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'canvas':
                         ?>
                        <div id="signature" style="<?php if ($reply_text) echo 'display:none' ?>">
                          <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                          <br />
                        </div>
                        <textarea id='reply_text' class="reply_text" style='display: none;' name="reply_text" required >{{ isset($reply_text) ? $reply_text : null }}</textarea>
                        <img src='' id='reply_sign' class="reply_sign" style='display: none;' />
                        <br />
                        <input type='button' id='reply_draw' value='Confirm Drawing' class="btn btn-primary" style="float:left; margin-right:5px; margin-bottom:5px; <?php if ($reply_text) echo 'display:none' ?>">
                        <input type='button' id='reset_draw' value='Reset Drawing' class="btn btn-default" style="float:left; margin-right:5px; margin-bottom:5px; <?php if ($reply_text) echo 'display:none' ?>">
                        <?php
                            break;
                         ?>
                        <?php
                            default:
                         ?>
                        <?php
                            break;
                         ?>
                        <?php
                          }
                         ?>

                        <input type="hidden" class="form-control" id="question_id" name="question_id" value="{{ $question_id }}" />
                        @csrf
                        <button type="submit" name="submit" class="btn btn-success pull-left" id="reply_save" style="<?php if ($reply_text) echo 'display:none' ?>" >
                            <i class="fa fa-save"></i> Save
                        </button>
                      </form>
                  </div><!-- /.panel-body -->
              </div><!-- /.panel panel-default -->

              <?php
                }
               ?>

              @endforeach

          </div><!-- /.col-md-12 -->
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

<script>
    $(document).ready(function() {

        $('#reset_draw').click(function() {
            location.reload();
        });

        var Question_count  = $('#question_count').val();
        var Question_reply  = $('#question_reply').val();
        var Current_number  = $('#current_number').val();

        if (Question_count == Question_reply) {

            $(".reply_text").each(function(index, value) {
                var signatureImg = $(this).closest('textarea').val();

                if (signatureImg){
                    $(this).next().show();
                    $(this).next().attr('src', signatureImg);
                }
            });

        } else {

            var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
            var signatureBtn = $('#reply_draw').val();
            var signatureImg = $('#reply_text').val();

            if (signatureBtn){
                $('#reply_draw').show();
                $('#reply_save').hide();
                $('#reply_text').hide();
            }

            if (signatureImg){
                $('#reply_sign').show();
                $('#reply_sign').attr('src', signatureImg);
            }

            $('#reply_draw').click(function() {
                var data = signaturePad.toDataURL('image/png');
                $('#reply_text').val(data);
                $('#signature') .hide();
                $('#reply_draw').hide();
                $('#reply_save').show();
                $('#reply_text').hide();
                $('#reply_sign').show();
                $('#reply_sign').attr('src', data);
            });

        }

    })
 </script>

@include('layouts.footer')
