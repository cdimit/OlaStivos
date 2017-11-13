<ul>
	@foreach($var->links as $link)
	 	<li>
	  		<a href="{{$link->path}}">{{$link->name}}</a>
		</li>
	@endforeach
</ul> 
