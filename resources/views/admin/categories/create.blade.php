@extends('admin.app')

@section('body_title')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Add / Edit Category</h1>
	</div>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item">
    	<a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
    	<a href="{{ route('admin.category.index') }}">Categories</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Add Category</li>
@endsection

@section('content')

	<form action="@if(isset($category)) {{ route('admin.category.update', $category->slug) }} @else {{ route('admin.category.store') }} @endif" method="post" accept-charset="utf-8">
		@csrf
		@if(isset($category))
			@method('PUT')
		@endif
		<div class="form-group row">
			<div class="col-sm-12">			
				<label class="form-control-label">Title : </label>
				<input type="text" id="txturl" name="title" class="form-control" value="{{ @$category->title }}">
				<p class="small">{{ url('/') }}/<span id="url">{{ @$category->slug }}</span></p>
				<input type="hidden" name="slug" id="slug" value="{{ @$category->slug }}">
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-12">			
				<label class="form-control-label">Description : </label>
				<textarea name="description" id="editor" class="form-control" cols="80" rows="10">{!! @$category->description !!}</textarea>
			</div>
		</div>

		<div class="form-group row">
			<div class="col-sm-12">			
				<label class="form-control-label">Select Category : </label>
				<select name="parent_id[]" id="parent_id" class="form-control" multiple>
					@php
						$ids = (isset($category->childrens) && $category->childrens->count() > 0) ? array_pluck($category->childrens, 'id') : null;
					@endphp
					@if(isset($categories))
						<option value="0">Top Level</option>
						@foreach($categories as $category)
							<option value="{{ $category->id }}" @if(!is_null($ids) && in_array($category->id, $ids)) {{ 'selected' }} @endif >{{ $category->title }}</option>
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
					const pretty_url = slugify($(this).val());
					$('#url').html(slugify(pretty_url));
					$('#slug').val(pretty_url);
				})

			$('#parent_id').select2({
				placeholder : "Select a Parent Category",
				allowClear : true,
				minimumResultsForSearch : Infinity
			});
		});
	</script>
@endsection