
<ul class="list-inline">
  @foreach($var->images as $image)
    <li data-toggle="modal" data-target="#myModal"><a href="#myGallery" data-slide-to="{{$loop->index}}"><img class="img-thumbnail" src="/storage/{{$image->path}}"><br>{{$image->name}}</a></li>
  @endforeach
<!--end of thumbnails-->
</ul>

<!--begin modal window-->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <div class="pull-left">Εικόνες {{$var->name}}</div>
        <button type="button" class="close" data-dismiss="modal" title="Close"> <span class="glyphicon glyphicon-remove"></span></button>
      </div>
      <div class="modal-body">

        <!--CAROUSEL CODE GOES HERE-->

        <!--begin carousel-->
        <div id="myGallery" class="carousel slide" data-interval="false">
          <div class="carousel-inner">
            @foreach($var->images as $image)
              <div class="item @if($loop->first) active @endif" > <img src="/storage/{{$image->path}}" alt="item{{$loop->index}}">

              </div>
            @endforeach

        <!--end carousel-inner-->
        </div>

<!--Begin Previous and Next buttons-->
        <a class="left carousel-control" href="#myGallery" role="button" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#myGallery" role="button" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span></a>
<!--end carousel--></div>




        <!--end modal-body-->
        
      </div>
      
      <div class="modal-footer">
          <div class="pull-left">
            <small>Photographs by <a href="#" target="new">Ola Stivos</a></small>
          </div>
          <button class="btn-sm close" type="button" data-dismiss="modal">Close</button>
<!--end modal-footer--></div>
<!--end modal-content--></div>
<!--end modal-dialoge--></div>
<!--end myModal-->></div>