@foreach($comments as $theComments)
	@if (!is_null($theComments->user_id))
	@php $newUsers = $users->where('id',$theComments->user_id)->first(); @endphp
	<div id="commentsList" class="row cmt_id_{{$theComments->id}}">
		<div class="col-lg-11" style="padding-right: 0">
			<img class="rounded-circle" src="/storage/uploads/avatar_images/{{$newUsers->avatar}}" class="media-object" style="width:50px;height:50px;margin: 5px 20px 5px 0px;float:left">
			<p><span style="{{($newUsers->role == 'admin' ? 'color:red;' : '')}}">{{$newUsers->name}}</span> ({{$theComments->created_at}})<br><span style="font-size: 13px;">{{$theComments->comment}}</span><br></p>
		</div>
		@if (Auth::check() && Auth::user()->id == $theComments->user_id || Auth::check() && Auth::user()->role == 'admin')
		<div class="col-lg-1" style="padding-left: 0">
			<ul class="nav_btn user dropdown-toggle cmt" data-toggle="dropdown" href="#">
				<div class="dropdown-menu cmt">
		      		<li class="dropdown-item cmt" href="#">Sửa</li>
		      		<li class="dropdown-item cmt cmt_del_{{$theComments->id}}" href="#">Xóa</li>
			    </div>
			</ul>
		</div>
		@endif
	</div>
	@else
		<div id="commentsList" class="row cmt_id_{{$theComments->id}}">
		<div class="col-lg-11" style="padding-right: 0">
			<img class="rounded-circle" src="https://www.brandeps.com/icon-download/U/User-02.svg" class="media-object" style="width:50px;height:50px;margin: 5px 20px 5px 0px;float:left;background:white;">
			<p><span>Khách</span> ({{\Carbon\Carbon::parse($theComments->created_at)->format('h:m A (d/m/Y)')}})<br><span style="font-size: 13px;">{{$theComments->comment}}</span><br></p>
		</div>
		@if (Auth::check() && Auth::user()->id == $theComments->user_id || Auth::check() && Auth::user()->role == 'admin')
		<div class="col-lg-1" style="padding-left: 0">
			<ul class="nav_btn user dropdown-toggle cmt" data-toggle="dropdown" href="#">
				<div class="dropdown-menu cmt">
		      		<li class="dropdown-item cmt" href="#">Sửa</li>
		      		<li class="dropdown-item cmt cmt_del_{{$theComments->id}}" href="#">Xóa</li>
			    </div>
			</ul>
		</div>
		@endif
	</div>
	@endif
	<script>
		$('.cmt_del_{{$theComments->id}}').on('click',function(){
			$('.cmt_id_{{$theComments->id}}').fadeOut(500);
			setTimeout(function(){
				$('.cmt_id_{{$theComments->id}}').load('{{ action('User\AjaxController@deleteComment',['id'=> $theComments->id]) }}');
			},500);
		});
	</script>
@endforeach


