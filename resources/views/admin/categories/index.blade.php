@php
	use App\Product;
@endphp

@extends('admin.app')
@section('content')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Category</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<a href="{{ route('admin.category.create') }}">
				<button type="button" class="btn btn-sm btn-outline-secondary">
					Add Category
				</button>
			</a>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-sm">
			<thead>
				<tr>
					<th>#</th>
					<th>Title</th>
					<th>Description</th>
					<th>Slug</th>
					<th>Categories</th>
					<th>Date Created</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if ($categories)
					@foreach ($categories as $key => $category)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $category->title }}</td>
							<td>{!! $category->description !!}</td>
							<td>{{ $category->slug }}</td>
							<td>
								@if ($category->childrens()->count() > 0)
									@foreach ($category->childrens as $children)
										{{ $children->title }},
									@endforeach
								@else 
									<strong>{{ "Parent Category" }}</strong>
								@endif
							</td>
							<td>{{ $category->created_at }}</td>
							<td>
								<a href="#" class="btn btn-info btn-sm">Edit</a> | 
								<a href="#" class="btn btn-danger btn-sm">Delete</a>
							</td>
						</tr>
					@endforeach
				@else 
					<tr>
						<td colspan="6">No Categories Found...!</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
@endsection