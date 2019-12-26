@extends('master')

@section('content')
<div class="row" id="app">
        <div  class="col">
          <div class="card shadow">
          	<div v-cloak v-show="!loading">
            <div class="card-header border-0">
            	<p style="color: red;">@{{ message }}</p>
            	 <h3 class="mb-0">Users</h3>
            	 <hr style="border: 0">
            	<button class="btn btn-primary" @click="showCreateUserModal">Create new user</button>
            	<div id="createUserModal"  class="modal" tabindex="-1" role="dialog">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">Create new user</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        <form>
				        	@csrf
				        	<div class="form-group">
				        		<label>Name:</label>
				        		<input type="text" name="name" class="form-control" v-model="userToStore.name">
				        		<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
				        	</div>
				        	<div class="form-group">
				        		<label>Email:</label>
				        		<input type="text" name="email" class="form-control" v-model="userToStore.email">
				        		<div style="color: red;" v-if="error.email && error.email.length>0">@{{error.email[0]}}</div>
				        	</div>
				        	<div class="form-group">
				        		<label>Password:</label>
				        		<input type="text" name="password" class="form-control" v-model="userToStore.password">
				        		<div style="color: red;" v-if="error.password && error.password.length>0">@{{error.password[0]}}</div>
				        	</div>
					        <div class="form-group">
					        	<label>Group:</label>
					        	<select class="form-control" v-model="userToStore.group_id">
					        		<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
					        	</select>
					        	<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
					        </div>
				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" @click="storeUser"> Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>
					<div id="editUserModal"  class="modal" tabindex="-1" role="dialog">
				  <div class="modal-dialog modal-lg" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title">Edit user</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				      	<p v-if="message" style="color: red">@{{message}}</p>
				        <form>
				        	<div class="form-group">
				        		<label>Name:</label>
				        		<input type="text" name="name" class="form-control" v-model="userToUpdate.name">
				        		<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
				        	</div>
				        	<div class="form-group">
				        		<label>Email:</label>
				        		<input type="text" name="email" class="form-control" v-model="userToUpdate.email">
				        		<div style="color: red;" v-if="error.email && error.email.length>0">@{{error.email[0]}}</div>
				        	</div>
				        	<div class="form-group">
				        		<label>Group:</label>
				        		<select class="form-control" v-model="userToUpdate.group_id">
				        			<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
				        		</select>
				        		<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
				        	</div>
				        	<button type="button" class="btn btn-primary" @click="toggleEditPassword">Edit password</button>
				        	<div class="form-group" v-show="editPassword">
				        		<label>New password:</label>
				        		<input type="text" name="password" class="form-control" v-model="userToUpdate.password">
				        		<div style="color: red;" v-if="error.password && error.password.length>0">@{{error.password[0]}}</div>
				        	</div>
				        </form>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary" @click="updateUser"> Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>
            	<hr style="border: 0">
            	<div v-show="successMessage">
	            	<div  class="alert alert-success">
	            		@{{successMessage}}
	            	</div>
	            	<hr style="border: 0">
            	</div>

            	{{-- <input type="text" class="form-control" style="margin-left: 16px;width: 95%" placeholder="Filter" v-model="filter" @keyup="page=1;getUsers()"> --}}
				<hr style="border: 0">

				{{-- <nav style="margin-right: 16px" aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getUsers(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getUsers()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getUsers(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav> --}}

				
            	
             
            </div>
            <div class="table-responsive" style="overflow-y: auto;">
              <table  class="table align-items-center table-sm table-bordered table-striped">
                <thead class="thead-light">
                  <tr>
                    <th style="cursor: pointer;" @click="sort('userName')">Name</th>
                    <th>Email</th>
                    <th>Created at</th>
                    <th>Group</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>

                	<tr>
                		<!-- filter user name -->
                		<td>
                			<input type="text" v-model="userName" @keyup="filterUsers">
                		</td>
                		<!-- filter user email -->
                		<td>
                			<input type="text" v-model="userEmail" @keyup="filterUsers">
                		</td>
                		<!-- filter user created -->
                		<td>
                			<input type="date" v-model="userCreated" @change="filterUsers">
                		</td>
                		<!-- filter user group -->
                		<td>
                			<select v-model="userGroupId" @change="filterUsers">
                				<option v-for="group in groups" :value="group.id">@{{group.name}}</option>
                			</select>
                		</td>
                	</tr>
                	
                  <tr v-for="user in users">
                   
                   <td>@{{user.name}}</td>
                   <td>@{{user.email}}</td>
                   <td>@{{user.created_at}}</td>
                   <td>@{{user.group ? user.group.name : ''}}</td>
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
								<a class="dropdown-item" href="javascript:void(0)" @click="showEditUserModal(user)" >Edit</a>
								<a class="dropdown-item" href="javascript:void(0)" @click="deleteUser(user)">Delete</a>
							</div>		
						</div>
                   	</td>
          
                  </tr>

                  <tr v-if="users.length==0">
                  	<td colspan="5">No users found</td>
                  </tr>
                  
                  <tr>

                  	<td colspan="4">
                  		<p>
												page @{{currentPage}} of @{{numberOfPages}}
 											</p>
											 <nav aria-label="...">
													<ul class="pagination justify-content-start mb-0">
														<li class="page-item">
															<a class="page-link" @click="page=1;getUsers()">
																<<
														 		<span class="sr-only">Previous</span>
															</a>
														 </li>
														 <li class="page-item" :class="{'disabled':page==1}">
														 	<a @click="getUsers(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
														 		<i class="fas fa-angle-left"></i>
														 		<span class="sr-only">Previous</span>
														 	</a>
														 </li>
														 
														 <li  
		v-for="pageNumber in pages.slice( Math.floor((currentPage-1)/5)*5 , Math.floor((currentPage+4)/5)*5 )" 
		class="page-item" :class="{'active':pageNumber==currentPage}">
										                    <a @click="page=pageNumber;getUsers()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
										                 </li>
										                
														 <li class="page-item" :class="{'disabled':page>=pages.length}">
														 	<a @click="getUsers(++page)" class="page-link" href="javascript:void(0)">
														 		<i class="fas fa-angle-right"></i>
														 		<span class="sr-only">Next</span>
														 	</a>
														 </li>
														  <li class="page-item">
															<a class="page-link" @click="page=lastPage;getUsers()">
																>>
														 		<span class="sr-only">Previous</span>
															</a>
														 </li>
													</ul>
												</nav> 
                  	</td>
					
					<td colspan="1">
						<select class="form-control" v-model="limit" @change="filterUsers">
							<option v-for="limit in limits">@{{limit}}</option>
						</select>
					</td>

                  </tr>
                
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
            {{-- <nav  aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getUsers(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getUsers()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getUsers(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav> --}}
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
	<script>$("#users").addClass("active");</script>
	<script>$("#permissionIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".permissionItems").toggle();</script>
	<script src="/js/limits.js"></script>
	<script src="/js/users.js"></script>
@endsection