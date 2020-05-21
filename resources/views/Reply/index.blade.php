@include('layouts.header')

<div class="container">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reply Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="home">Home</a></li>
              <li class="breadcrumb-item"><a href="Questionnaires">Questionnaires</a></li>
              <li class="breadcrumb-item active">Reply Page</li>
            </ol>
          </div>
        </div>

        <div class="row justify-content-center mb-3">
          <div class="col-md-12 col-md-offset-0">
              <h3 class="text-center">
                Questionnaire <?php echo $_GET['questionnaire_id']; ?> : <?php echo $Questionnaire = isset($Questionnaire->questionnaire_name) ? $Questionnaire->questionnaire_name : null; ?>
              </h3>
              <br />
              <?php
                $types = ['textarea','string','option','number','date','time','datetime'];
               ?>

              @foreach($Questions as $record)

              <?php
                $reply_text = null;
                foreach ($Replies as $rec) {
                  if ($rec['question_id'] == $record->id) {
                    $reply_text = isset($rec['reply_text']) ? $rec['reply_text'] : null;
                  }
                }
               ?>

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
                          ?>" />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'option':
                         ?>
                         <select name="reply_text" class="form-control">
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
                          ?>" />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'date':
                         ?>
                         <input name="reply_text" type="date" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d', strtotime($reply_text)) : null;
                          ?>" />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'time':
                         ?>
                         <input name="reply_text" type="time" class="form-control" value="<?php
                          echo ($reply_text) ? date('H:i:s', strtotime($reply_text)) : null;
                          ?>" />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'datetime':
                         ?>
                         <input name="reply_text" type="datetime" class="form-control" value="<?php
                          echo ($reply_text) ? date('Y-m-d H:i:s', strtotime($reply_text)) : null;
                          ?>" />
                        <?php
                            break;
                         ?>
                        <?php
                            case 'canvas':
                         ?>
                        <style>
                        #signature{
                         width: 300px; height: 200px;
                         border: 1px solid black;
                        }
                        </style>

                        <!-- Signature -->
                        <div id="signature" style=''>
                         <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas>
                        </div><br/>

                        <input type='button' id='click' value='preview'><br/>
                        <textarea id='output'></textarea><br/>

                        <!-- Preview image -->
                        <img src='' id='sign_prev' style='display: none;' />

                        <center>
                            <canvas id="image" style="max-width:100%; border:1px solid #000000;">
                            </canvas>
                            <canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas>
                        </center>

                        <a href="#" id="resetbtn" class="btn btn-success" style="width:125px; height:34px;">
                            Reset
                        </a>
                        <a href="#" id="noisebtn" class="btn btn-primary" style="width:125px; height:34px;">
                            Noise
                        </a>
                        <button type="submit" class="btn btn-warning pull-right" id="save_image">
                            <i class="fa fa-save"></i> Save Changes
                        </button>
                        <?php
                            break;
                         ?>
                        <?php
                            default:
                         ?>
                        <center>
                          <div class="canvas__container">
                            <canvas id="cnvs" class="canvas__canvas" name="reply_text" style="max-width:100%; border:1px solid #000000;"></canvas>
                            <img id="mirror" class="canvas__mirror" />
                          </div>
                        </center>
                        <?php
                            break;
                         ?>
                        <?php
                          }
                         ?>
                        <div style="both:clear"></div><br />
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
     var signaturePad = new SignaturePad(document.getElementById('signature-pad'));

     $('#click').click(function(){
      var data = signaturePad.toDataURL('image/png');
      $('#output').val(data);

      $("#sign_prev").show();
      $("#sign_prev").attr("src",data);
      // Open image in the browser
      //window.open(data);
     });
    })
 </script>

<script>

    $(document).on('click', '#save_image', function() {
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
        var canvas = document.getElementById('signature-pad');
        var dataURL = canvas.toDataURL();
        $.ajax({
          type: "POST",
          url: "/saveImage",
          data: {
              imgBase64: dataURL
          }
        }).done(function(data) {
            console.log('Image saved');

            // Do here whatever you want.
        });
    });

    $(function() {
        var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
        var canvas = document.getElementById('signature-pad');
        var ctx = canvas.getContext('2d');
        var img = new Image();
        img.crossOrigin = '';
        img.src = '{{ url(dirname(public_path()) . '/' . basename(public_path())) }}';
        img.onload = function() {
            canvas.width = img.width;
            canvas.height = img.height;
            ctx.drawImage(img, 0, 0, img.width, img.height);
        }
        var $reset = $('#resetbtn');
        var $noise = $('#noisebtn');
        $reset.on('click', function(e) {
            e.preventDefault();
            $('input[type=range]').val(0);
            Caman('#image', img, function() {
                this.revert(false);
                this.render();
            });
        });
        $noise.on('click', function(e) {
            e.preventDefault();
            Caman('#image', img, function() {
                    this.noise(10).render();
                });
        });

    });

</script>

@include('layouts.footer')
