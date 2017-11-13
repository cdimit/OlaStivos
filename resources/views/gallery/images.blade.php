<ul class="list-inline">
  @foreach($var->images as $image)
    <li data-toggle="modal" data-target="#myModal">
      <a href="#myGallery" data-slide-to="{{$loop->index}}">
        <div class="image-container" style="display: table; margin: 0px; border: solid 1px;">
          <img class="img-thumbnail" src="/storage/{{$image->path}}" style="max-height: 22vh; max-width: 22vw; display: block;">
          <div class="image-caption" style="display: table-caption; caption-side: bottom;text-align: center;">{{$image->name}}</div>
        </div>

      </a>
    </li>
  @endforeach
<!--end of thumbnails-->
</ul>

<!--begin modal window-->
<div class="modal fade" id="myModal">
  <div class="modal-dialog" style="max-width: 80%; width: auto; height: auto; margin-top: 50px;">
    <div class="modal-content" style="  height: auto; min-height: 100%; border-radius: 0; background-color: rgba(250, 250, 250, 0.6);">

      <div class="modal-header" style="background-color:rgba(250, 250, 250, 0.7);">
        <div class="pull-left" >Εικόνες {{$var->name}}</div>
        <button type="button" class="close" data-dismiss="modal" title="Close"> <span class="glyphicon glyphicon-remove"></span></button>
      </div> 
      <div class="modal-body">

        <!--CAROUSEL CODE GOES HERE-->

        <!--begin carousel-->
        <div id="myGallery" class="carousel slide" data-interval="false">
          <div class="carousel-inner">
            @foreach($var->images as $image)
              <div class="item @if($loop->first) active @endif conte" >
                <img src="/storage/{{$image->path}}" alt="item{{$loop->index}}" style="margin: auto;">
              </div>
            @endforeach
        </div>
        <!--end carousel-inner-->


        <!--Begin Previous and Next buttons-->
        <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myGallery" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
        <!--end carousel--></div>




        <!--end modal-body-->
        
      </div>
      
      <div class="modal-footer" style="background-color:rgba(250, 250, 250, 0.7);">
          <div class="pull-left">
            <small>Photographs by <a href="#" target="new">Ola Stivos</a></small>
          </div>
          <button class="btn-sm close" type="button" data-dismiss="modal">Close</button>
<!--end modal-footer--></div>
<!--end modal-content--></div>
<!--end modal-dialoge--></div>
<!--end myModal-->></div>
