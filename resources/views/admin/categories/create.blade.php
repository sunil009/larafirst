@extends('admin.app')
@section('content')

<form action="{{ route('admin.category.store') }}" method="post" accept-charset="utf-8">
	@csrf
	<div class="form-group row">
		<div class="col-sm-12">
			@if ($errors->any())
			    <div class="alert alert-danger">
			        <ul style="margin-bottom: 0">
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
			@endif

			@if(session()->has('message'))
				<div class="alert alert-success">
					{{ session('message') }}
				</div>
			@endif
		</div>
		<div class="col-sm-12">			
			<label class="form-control-label">Title : </label>
			<input type="text" id="txturl" name="title" class="form-control">
			<p class="small">{{ url('/') }}/<span id="url"></span></p>
			<input type="hidden" name="slug" id="slug" value="">
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-12">			
			<label class="form-control-label">Description : </label>
			<textarea name="description" id="editor" class="form-control" cols="80" rows="10"></textarea>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-12">			
			<label class="form-control-label">Select Category : </label>
			<select name="parent_id[]" id="parent_id" class="form-control" multiple>
				@if($categories)
					<option value="0">Top Level</option>
					@foreach($categories as $category)
						<option value="{{ $category->id }}">{{ $category->title }}</option>
					@endforeach
				@endif
			</select>
		</div>
	</div>

	<div class="form-group row">
		<div class="col-sm-12">			
			<input type="submit" name="submit" class="btn-btn-primary" value="Add Category">
		</div>
	</div>
</form>

@endsection

@section('scripts')
	<script type="text/javascript">
		$(function(){

			ClassicEditor
			    .create( document.querySelector( '#editor' ), {
			    	toolbar: ['Heading', 'Link', 'bold', 'italic', 'bulletedList', 'numveredList', 'blockQuote', 'undo', 'redo'],
			    })
			    .then( editor => {
			        window.editor = editor;
			    } )
			    .catch( err => {
			        console.error( err.stack );
			    } );
			
			$('#txturl').on('keyup', function(){
				var url = slugify($(this).val());
				// alert("Url : -" + $(this).val() + " | Slug " + url);
				$('#url').html(url);
				$('#slug').val(url);
			});

			$('#parent_id').select2({
				placeholder : "Select a Parent Category",
				allowClear : true,
				minimumResultsForSearch : Infinity
			});
		});
	</script>
@endsection