@extends('master')

@section('content')
	
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Domains</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateDomainModal">Create new Domain</button>

						<!--create modal -->
						<div id="createDomainModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new domain</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Domain name:</label>
											<input type="text" class="form-control" v-model="domainToStore.name">
											<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
										</div>
										<div class="form-group">
														<label>Group</label>
														<select class="form-control" v-model="domainToStore.group_id">
															<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
														</select>
														<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
													</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeDomain">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editDomainModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit domain</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										
										
												<div class="form-group">
													<label>Domain name:</label>
													<input type="text" class="form-control" v-model="domainToUpdate.name">
													<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
												</div>
												<div class="form-group">
														<label>Group</label>
														<select class="form-control" v-model="domainToUpdate.group_id">
															<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
														</select>
														<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
													</div>

													<div class="form-group">
														<label><input type="checkbox" v-model="domainToUpdate.isActive"> Active </label>
													</div>
											
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateDomain">Save changes</button>
									</div>
								</div>
							</div>
						</div>

						<hr style="border: 0">

						{{-- <div class="row container">
							<div class="col-8">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getDomains()" />
							</div>
						</div>
						
						
						<hr style="border: 0"> --}}

						<div v-if="successMessage">
							<div class="alert alert-success">
								@{{successMessage}}
							</div>
								<hr>
						</div>

							{{-- <nav style="margin-right: 32px" aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getDomains(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getDomains()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getDomains(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav>

						<hr style="border:0"> --}}

						<div class="">
							<table class="table align-items-center table-sm table-bordered table-striped">
								<thead class="thead-light">
									<tr>
										<th style="cursor: pointer;" @click="sort('domainName')">Domain name</th>
										<th scope="">Status</th>
										<th>Group</th>
										<th>Created at</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<!-- filter doamin name -->
										<td>
											<input type="text" v-model="domainName" @keyup="filterDomains">
										</td>
										<!-- filter domain status -->
										<td>
											<select v-model="domainStatus" @change="filterDomains">
												<option></option>
												<option value="1">Active</option>
												<option value="0">Inactive</option>
											</select>
										</td>
										<!-- filter domain group -->
										<td>
											<select v-model="domainGroupId" @change="filterDomains">
												<option></option>
												<option v-for="group in groups" :value="group.id">@{{group.name}}</option>
											</select>
										</td>
										<!-- filter domain created -->
										<td>
											<input type="date" v-model="domainCreated" @change="filterDomains">
										</td>
									</tr>
									<tr v-for="domain in domains">
										<td>@{{ domain.name }}</td>
										<td>@{{ domain.isActive ? "active" : "inactive" }}</td>
										<td>@{{ domain.group ? domain.group.name : "" }}</td>
										<td>@{{domain.created_at}}</td>
										<td>
											<div class="dropdown">
												<button 
													class="btn btn-primary dropdown-toggle" 
													type="button" id="dropdownMenuButton" 
													data-toggle="dropdown" 
													aria-haspopup="true" 
													aria-expanded="false" />
														Actions
												</button>
												<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
													<a class="dropdown-item" href="javascript:void(0)" @click="showEditDomainModal(domain)" >Edit</a>
													<a class="dropdown-item" href="javascript:void(0)" @click="deleteDomain(domain)">Delete</a>
												</div>		
											</div>
											
										</td>
									</tr>
									<tr v-if="domains.length==0">
										<td colspan="5">
											No offers found
										</td>
									</tr>
									<tr>
										<td colspan="4">
											<p>
												page @{{currentPage}} of @{{numberOfPages}}
 											</p>
											 <nav aria-label="...">
													<ul class="pagination justify-content-start mb-0">
														<li class="page-item">
															<a class="page-link" @click="page=1;getDomains()">
																<<
														 		<span class="sr-only">Previous</span>
															</a>
														 </li>
														 <li class="page-item" :class="{'disabled':page==1}">
														 	<a @click="getDomains(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
														 		<i class="fas fa-angle-left"></i>
														 		<span class="sr-only">Previous</span>
														 	</a>
														 </li>
														 
														 <li  
		v-for="pageNumber in pages.slice( Math.floor((currentPage-1)/5)*5 , Math.floor((currentPage+4)/5)*5 )" 
		class="page-item" :class="{'active':pageNumber==currentPage}">
										                    <a @click="page=pageNumber;getDomains()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
										                 </li>
										                
														 <li class="page-item" :class="{'disabled':page>=pages.length}">
														 	<a @click="getDomains(++page)" class="page-link" href="javascript:void(0)">
														 		<i class="fas fa-angle-right"></i>
														 		<span class="sr-only">Next</span>
														 	</a>
														 </li>
														  <li class="page-item">
															<a class="page-link" @click="page=lastPage;getDomains()">
																>>
														 		<span class="sr-only">Previous</span>
															</a>
														 </li>
													</ul>
												</nav> 
										</td>
										<td colspan="1">
											<select class="form-control" v-model="limit" @change="filterDomains">
												<option v-for="limit in limits">@{{limit}}</option>
											</select>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer py-4">
							
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
	<script>$("#domains").addClass("active");</script>
	<script>$("#configurationIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".configurationItems").toggle();</script>
	<script src="/js/limits.js"></script>
	<script src="/js/domains.js"></script>
@endsection