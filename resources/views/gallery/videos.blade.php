<!-- Lista me videos pou anoigoun ta modals -->
<ul class="list-inline">
  @foreach($var->videos as $video)
  <li data-toggle="modal" data-target="#videoModal" data-theVideo="{{$video->path}}">
    <a href="#" style="max-height: 22vh; max-width: 22vw;">
      <div class="video-container" style="display: table; margin: 0px; border: solid 1px;">
        <iframe width="220" height="155" src="{{$video->path}}" style="display: block;">
        </iframe> 
        <div class="video-caption" style="display: table-caption; caption-side: bottom;text-align: center;">
          {{$video->name}}
        </div>
      </div>
    </a>
  </li>
  @endforeach
</ul>

<!-- Modal anoigei kai dexete data to video-->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <div>
                    <iframe width="100%" height="350" src=""></iframe>
                    {{$video->name}}
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script type="text/javascript">
  autoPlayYouTubeModal();

  //FUNCTION TO GET AND AUTO PLAY YOUTUBE VIDEO FROM DATATAG
  function autoPlayYouTubeModal() {
      var trigger = $("body").find('[data-toggle="modal"]');
      trigger.click(function () {
          var theModal = $(this).data("target"),
              videoSRC = $(this).attr("data-theVideo"),
              videoSRCauto = videoSRC + "?autoplay=1";
          $(theModal + ' iframe').attr('src', videoSRCauto);
          $(theModal + ' button.close').click(function () {
              $(theModal + ' iframe').attr('src', videoSRC);
          });
      });
  }
</script>

@endsection
