<ul>
	@foreach($var->links as $link)
	 	<li>
	  		<a href="{{$link->path}}" target="_blank">{{$link->name}}</a>
		</li>
	@endforeach
</ul>
