<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
	<a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{ route('admin.dashboard') }}">Company name</a>
	<input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
	<ul class="navbar-nav px-3">
		<li class="nav-item text-nowrap">
			<a class="nav-link" href="{{ route('logout') }}"
			onclick="event.preventDefault();
			document.getElementById('logout-form').submit();">
			Sign out</a>
			<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</li>
	</ul>
</nav>

<nav class="col-md-2 d-none d-md-block bg-light sidebar">
	<div class="sidebar-sticky">
		<ul class="nav flex-column">
			<li class="nav-item">
				<a class="nav-link @if(request()->url() == route('admin.dashboard')) {{ 'active' }} @endif" href="{{ url('admin/dashboard') }}">
					<span data-feather="home"></span>
					Dashboard <span class="sr-only">(current)</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file"></span>
					Orders
				</a>
			</li>
			{{-- <li class="nav-item">
				<a class="nav-link @if(request()->url() == route('admin.product.index')) {{ 'active' }}  @endif" href="{{ route('admin.product.index') }}">
					<span data-feather="shopping-cart"></span>
					Products
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link @if(request()->url() == route('admin.category.index')) {{ 'active' }} @endif" href="{{ route('admin.category.index') }}">
					<span data-feather="bar-chart-2"></span>
					Categories
				</a>
			</li> --}}
			<li class="nav-item dropdown">
				<a id="productDropdown" class="nav-link @if(request()->url() == route('admin.product.index')) {{'active'}} @endif  dropdown-toggle" href="javascript:;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span data-feather="shopping-cart"></span>
					Products
				</a>
				<div class="dropdown-menu" aria-labelledby="productDropdown">
					<a class="dropdown-item" href="{{route('admin.product.create')}}">Add Product</a>
					<a class="dropdown-item" href="{{route('admin.product.index')}}">All Products</a>
					<a class="dropdown-item" href="{{route('admin.product.trash')}}">Trashed Products</a>
				</div>
			</li>

			<li class="nav-item dropdown @if(Request::segment(2) == "category") {{ 'open' }} @endif">
				<a id="categoryDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span data-feather="bar-chart-2"></span>
					Categories
				</a>
				<div class="dropdown-menu" aria-labelledby="categoryDropdown">
					<a class="dropdown-item @if(request()->url() == route('admin.category.create')) {{ 'dropdown-active' }} @endif" href="{{route('admin.category.create')}}">Add Category</a>
					<a class="dropdown-item @if(request()->url() == route('admin.category.index')) {{ 'dropdown-active' }} @endif" href="{{route('admin.category.index')}}">All Categories</a>
					<a class="dropdown-item @if(request()->url() == route('admin.category.trash')) {{ 'dropdown-active' }} @endif" href="{{route('admin.category.trash')}}">Trashed Categories</a>
				</div>				
			</li>

			<li class="nav-item">
				<a class="nav-link  @if(request()->url() == route('admin.profile.index')) {{'active'}} @else {{''}} @endif" href="{{route('admin.profile.index')}}">
					<span data-feather="users"></span>
					Customers
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="layers"></span>
					Integrations
				</a>
			</li>
		</ul>

		<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
			<span>Saved reports</span>
			<a class="d-flex align-items-center text-muted" href="#">
				<span data-feather="plus-circle"></span>
			</a>
		</h6>
		<ul class="nav flex-column mb-2">
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text"></span>
					Current month
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text"></span>
					Last quarter
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text"></span>
					Social engagement
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">
					<span data-feather="file-text"></span>
					Year-end sale
				</a>
			</li>
		</ul>
	</div>
</nav>