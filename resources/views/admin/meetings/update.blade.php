<form action="{{url('meetings/create')}}" method="POST">
	@csrf
	<input type="text" name="topic" placeholder="Topic" />
	<input type="text" name="start_time" placeholder="start_time" />
	<input type="text" name="duration" placeholder="duration" />
	<input type="text" name="agenda" placeholder="agenda" />
	<input type="text" name="host_video" placeholder="host" value="1" />
	<input type="text" name="participant_video" placeholder="host" value="1" />
	<input type="submit" value="Submit">

</form>