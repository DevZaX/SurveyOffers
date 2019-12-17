@extends('master')

@section('content')
	
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Categories</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateCategoryModal">Create new Category</button>

						<!--create modal -->
						<div id="createCategoryModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new category</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Category name:</label>
											<input type="text" class="form-control" v-model="categoryToStore.name">
											<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeCategory">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editCategoryModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit category</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										
									
										
												<div class="form-group">
													<label>Category name:</label>
													<input type="text" class="form-control" v-model="categoryToUpdate.name">
													<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
												</div>

												<div class="form-group">
													<input type="checkbox" v-model="categoryToUpdate.status"> <label>Active</label>
												</div>
							
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateCategory">Save changes</button>
									</div>
								</div>
							</div>
						</div>

						<hr style="border: 0">

						<div class="row container">
							<div class="col-8">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getCategories()" />
							</div>
						</div>
						
						
						<hr style="border: 0">

						<div v-if="successMessage">
							<div class="alert alert-success">
								@{{successMessage}}
							</div>
							<hr>
						</div>

						<nav style="margin-right: 32px" aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getCategories(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getCategories()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getCategories(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav>

						<hr style="border:0">

						<div class="">
							<table  class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th scope="col">Category name</th>
										<th scope="col">Status</th>
										<th scope="col">Created at</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="category in categories">
										<td>@{{ category.name }}</td>
										<td>@{{ category.status ? "active" : "inactive" }}</td>
										<td>@{{ category.created_at}}</td>
										<td>
											<button class="btn btn-info" @click="showEditCategoryModal(category)"> Edit </button>
											<button class="btn btn-danger" @click="deleteCategory(category)"> Delete </button>
										</td>
									</tr>
									<tr v-if="categories.length==0">
										<td colspan="3">
											No offers found
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer py-4">
					<div class="card-footer py-4">
						<nav aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getCategories(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getCategories()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getCategories(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav>
					</div>
				</div>

				<div v-show="loading" style="text-align: center;">
					<img src="/img/lg.walking-clock-preloader.gif">
				</div>

			</div>
		</div>
	</div>

@endsection


@section('js')
	<script>$("#categories").addClass("active");</script>
	<script>$("#offersIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".offersItems").toggle();</script>
	<script src="/js/categories.js"></script>
@endsection