@include('layouts.header')

<div class="container">
    <div class="row justify-content-center mb-3">

    <div class="col-md-12 col-md-offset-0">
        <h3 class="text-center">
          Questionnaire <?php echo $_GET['questionnaire_id']; ?> : <?php echo $Questionnaire = isset($Questionnaire->questionnaire_name) ? $Questionnaire->questionnaire_name : null; ?>
        </h3>
        <br />
        <?php
          $types = ['textarea','string','option','number','date','time','datetime']
         ?>

        @foreach($Questions as $record)

        <div class="panel panel-default">
            <div class="panel-heading">
                <ul>
                  <li><i class="fa fa-file-text-o"></i> Question  {{ $record->id }} : {{ $record->question_text }} </li>
                </ul>
            </div>

            <div class="panel-body">
                <form action="{{ route('Replies.store') }}" method="POST">
                  <?php
                    switch ($record->question_type) {
                      case 'textarea':
                   ?>
                   <textarea cols=120 rows=5 name="reply_text" class="form-control">
                     <?php
                      echo ($Replies[$record->id]) ? nl2br($Replies[$record->id]) : null;
                      ?>
                   </textarea>
                  <?php
                      break;
                   ?>
                  <?php
                      case 'string':
                   ?>
                   <input name="reply_text" type="text" class="form-control" value="<?php
                    echo ($Replies[$record->id]) ? print_r($Replies[$record->id]) : null;
                    ?>" />
                  <?php
                      break;
                   ?>
                  <?php
                      case 'option':
                      $selected = ($Replies[$record->id]) ? trim($Replies[$record->id]) : null;
                      $selects = (count($Options[$question_id]) > 0) ? $Options[$question_id] : array();
                   ?>
                   <select name="reply_text">
                     <option></option>
                     <?php
                      foreach ($selects as $sel) {
                      ?>
                      <option value="<?php echo $sel; ?>" <?php if ($selected == $sel) echo 'selected'; ?> > <?php echo $sel; ?></option>
                     <?php
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
                    echo ($Replies[$record->id]) ? trim($Replies[$record->id]) : null;
                    ?>" />
                  <?php
                      break;
                   ?>
                  <?php
                      case 'date':
                   ?>
                   <input name="reply_text" type="date" class="form-control" value="<?php
                    echo ($Replies[$record->id]) ? date('Y-m-d', strtotime($Replies[$record->id])) : null;
                    ?>" />
                  <?php
                      break;
                   ?>
                  <?php
                      case 'time':
                   ?>
                   <input name="reply_text" type="time" class="form-control" value="<?php
                    echo ($Replies[$record->id]) ? date('H:i:s', strtotime($Replies[$record->id])) : null;
                    ?>" />
                  <?php
                      break;
                   ?>
                  <?php
                      case 'datetime':
                   ?>
                   <input name="reply_text" type="datetime" class="form-control" value="<?php
                    echo ($Replies[$record->id]) ? date('Y-m-d H:i:s', strtotime($Replies[$record->id])) : null;
                    ?>" />
                  <?php
                      break;
                   ?>
                  <?php
                      default:
                   ?>
                  <div class="canvas__container">
                    <canvas id="cnvs" class="canvas__canvas" name="reply_text"></canvas>
                    <img id="mirror" class="canvas__mirror" />
                  </div>
                  <?php
                      break;
                   ?>
                  <?php
                    }
                   ?>
                  <input type="hidden" class="form-control" name="question_id" value="{{ $record->id }}" />
                  @csrf
                  <input type="submit" class="btn btn-success" name="submit" value="Save" />
                </form>
            </div><!-- /.panel-body -->
        </div><!-- /.panel panel-default -->
        @endforeach

    </div><!-- /.col-md-12 -->

  </div>
</div>

@include('layouts.footer')
