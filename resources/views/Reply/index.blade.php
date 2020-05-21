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

              @foreach($Questions as $record)

              <?php
                $question_id = isset($record->id) ? $record->id : null;
                $question_type = isset($record->question_type) ? $record->question_type : null;
                $reply_text = null;
                foreach ($Replies as $rec) {
                  if ($rec['question_id'] == $question_id) {
                    $reply_text = isset($rec['reply_text']) ? $rec['reply_text'] : null;
                  }
                }
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
                         <textarea cols=120 rows=5 name="reply_text" class="form-control" <?php if ($reply_text) echo 'readonly' ?> >
                           <?php
                            echo ($reply_text) ? htmlspecialchars($reply_text) : null;
                            ?>
                         </textarea>
                        <?php
                            break;
                         ?>
                        <?php
                            case 'string':
                         ?>
                         <input name="reply_text" type="text" class="form-control" value="<?php
                          echo ($reply_text) ? $reply_text : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'option':
                         ?>
                         <select name="reply_text" class="form-control" <?php if ($reply_text) echo 'disabled' ?> >
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
                        <?php
                            break;
                         ?>
                        <?php
                            case 'number':
                         ?>
                         <input name="reply_text" type="number" class="form-control" value="<?php
                          echo ($reply_text) ? trim($reply_text) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'date':
                         ?>
                         <input name="reply_text" type="date" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'time':
                         ?>
                         <input name="reply_text" type="time" class="form-control" value="<?php
                          echo ($reply_text) ? date('H:i:s', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'datetime':
                         ?>
                         <input name="reply_text" type="datetime" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d H:i:s', strtotime($reply_text)) : null;
                          ?>" <?php if ($reply_text) echo 'readonly' ?> />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'canvas':
                         ?>
                        <div id="signature">
                          <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas><br />
                        </div>
                        <div id="drawing">
                          <input type='button' id='reply_draw' value='Confirm Drawing' class="btn btn-primary" style="margin-top:5px; margin-bottom:5px;"><br />
                        </div>
                        <textarea id='reply_text' name="reply_text">{{ isset($reply_text) ? $reply_text : null }}</textarea><br />
                        <img src='' id='reply_sign' style='display: none;' />
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
                        <div style="both:clear"></div><br />
                        <input type="hidden" class="form-control" id="question_id" name="question_id" value="{{ $question_id }}" />
                        @csrf
                        <button type="submit" name="submit" class="btn btn-success pull-left" id="save" style="<?php if ($reply_text) echo 'display:none' ?>" >
                            <i class="fa fa-save"></i> Save
                        </button>
                      </form>
                  </div><!-- /.panel-body -->
              </div><!-- /.panel panel-default -->

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

        <?php
          // foreach ($Questions as $record) {
          //   $question_id = isset($record->id) ? $record->id : null;
         ?>

        var signatureImg = $('#reply_text').val();
        if (signatureImg){
            $('#reply_sign').show();
            $('#reply_sign').attr('src', signatureImg);
        }

        var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
        $('#reply_draw').click(function() {
            var data = signaturePad.toDataURL('image/png');
            $('#reply_text').val(data);
            $('#reply_draw').hide();
            $('#reply_sign').show();
            $('#reply_sign').attr('src', data);
        });

        <?php
          // }
         ?>
    })
 </script>

@include('layouts.footer')
