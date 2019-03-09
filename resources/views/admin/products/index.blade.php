@extends('admin.app')

@section('body_title')
	<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
		<h1 class="h2">Products List</h1>
		<div class="btn-toolbar mb-2 mb-md-0">
			<a href="{{route('admin.product.create')}}" class="btn btn-sm btn-outline-secondary">
				Add Product
			</a>
		</div>
	</div>
@endsection

@section('breadcrumbs')
	<li class="breadcrumb-item">
		<a href="{{route('admin.dashboard')}}">Dashboard</a>
	</li>
	<li class="breadcrumb-item active" aria-current="page">Products</li>
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
					<th>Price</th>
					<th>Thumbnail</th>
					<th>Date Created</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				@if($products->count() > 0)
					@foreach($products as $key => $product)
						<tr>
							<td>{{ ++$key }}</td>
							<td>{{ $product->title }}</td>
							<td>{!! $product->description !!}</td>
							<td>{{ $product->slug }}</td>
							<td>
								@if($product->categories()->count() > 0)
									@foreach($product->categories as $children)
										{{$children->title}},
									@endforeach
								@else
									<strong>{{"product"}}</strong>
								@endif
							</td>
							<td>${{$product->price}}</td>
							<td>
								<img src="{{ asset('storage/app/'.$product->thumbnail) }}" alt="{{ $product->title }}" class="img-responsive" height="50"/>
							</td>
							@if($product->trashed())
								<td>{{ $product->deleted_at }}</td>
								<td>
									<a class="btn btn-info btn-sm" href="{{route('admin.product.recover',$product->id) }}">Restore</a> | 
									<a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{ $product->id }}')">Delete</a>
									<form id="delete-product-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->slug) }}" method="POST" style="display: none;">

										@method('DELETE')
										@csrf
									</form>
								</td>
							@else
							<td>{{$product->created_at}}</td>
							<td>
								<a class="btn btn-info btn-sm" href="{{ route('admin.product.edit',$product->slug) }}">Edit</a> | 
								<a id="trash-product-{{ $product->id }}" class="btn btn-warning btn-sm" href="{{ route('admin.product.remove',$product->slug) }}">Trash</a> | 
								<a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('product-{{ $product->id }}')">Delete</a>
								<form id="delete-product-{{ $product->id }}" action="{{ route('admin.product.destroy', $product->slug) }}" method="POST" style="display: none;">

									@method('DELETE')
									@csrf
								</form>
							</td>
							@endif
						</tr>
					@endforeach
				@else
				<tr>
					<td colspan="9" class="alert alert-info">No products Found..</td>
				</tr>
				@endif

			</tbody>

		</table>
	</div>
	<div class="row">
		<div class="col-md-12">
			{{$products->links()}}
		</div>
	</div>
@endsection