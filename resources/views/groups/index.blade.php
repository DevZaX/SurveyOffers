@extends('master')

@section('content')
	
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Groups</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateGroupModal">Create new Group</button>

						<!--create modal -->
						<div id="createGroupModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new group</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Group name:</label>
											<input type="text" class="form-control" v-model="groupToStore.name">
											<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeGroup">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editGroupModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit group</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										
										<div class="row">
											<div class="col-4">
												<div class="form-group">
													<label>Group name:</label>
													<input type="text" class="form-control" v-model="groupToUpdate.name">
													<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateGroup">Save changes</button>
									</div>
								</div>
							</div>
						</div>

						<hr style="border: 0">

						<div class="row container">
							<div class="col-8">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getGroups()" />
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
								 	<a @click="getGroups(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getGroups()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getGroups(++page)" class="page-link" href="javascript:void(0)">
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
										<th scope="col">Group name</th>
										<th scope="col">Created at</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="group in groups">
										<td>@{{ group.name }}</td>
										<td>@{{group.created_at}}</td>
										<td>
											<button class="btn btn-info" @click="showEditGroupModal(group)"> Edit </button>
											<button class="btn btn-danger" @click="deleteGroup(group)"> Delete </button>
										</td>
									</tr>
									<tr v-if="groups.length==0">
										<td colspan="3">
											No offers found
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer py-4">
							<nav  aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getGroups(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getGroups()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getGroups(++page)" class="page-link" href="javascript:void(0)">
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
	<script>$("#groups").addClass("active");</script>
	<script>$("#permissionIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".permissionItems").toggle();</script>
	<script src="/js/groups.js"></script>
@endsection