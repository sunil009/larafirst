@extends('admin.app')

@section('body_title')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Category</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<a href="{{route('admin.category.create')}}" class="btn btn-sm btn-outline-secondary">
				Add Category
			</a>
		</div>
	</div>
@endsection

@section('breadcrumbs')
    <li class="breadcrumb-item">
    	<a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Categories</li>
@endsection

@section('content')
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
								<a href="{{ route('admin.category.edit', $category->id) }}" class="btn btn-info btn-sm">Edit</a> | 
								<a href="javascript:;" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $category->id }}')">Delete</a>
								<form action="{{ route('admin.category.destroy', $category->id) }}" id="delete-category-{{ $category->id }}" method="POST" style="display: none;">
									@csrf
									@method('DELETE')
								</form>
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
		<div class="row">
			<div class="col-md-12">
				{{ $categories->links() }}
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		function confirmDelete(id) {
			var choice = confirm("Are you sure, You want to Delete this record?");
			if(choice) {
				// alert("delete-category-" + id);
				$("#delete-category-" + id).submit();
			}
		}
	</script>
@endsection