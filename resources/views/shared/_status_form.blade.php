<form action="{{ route('statuses.store') }}" method="POST">
	@include('shared._errors')
	{{ csrf_field() }}
	<textarea class="form-control" rows="3" placeholder="进步了吗？………没有？那你还看我……" name="content">{{ old('content') }}</textarea>
	<button type="submit" class="btn btn-primary pull-right">发表</button>
</form>