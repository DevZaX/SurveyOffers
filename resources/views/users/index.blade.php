@extends('master')

@section('content')

<div class="row" id="app">
        <div  class="col">
          <div class="card shadow">
          	<div v-cloak v-show="!loading">
            <div class="card-header border-0">
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
				      	<p  v-if="message" style="color: red">@{{message}}</p>
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
            	<hr>
            	<div v-show="successMessage">
	            	<div  class="alert alert-success">
	            		@{{successMessage}}
	            	</div>
	            	<hr>
            	</div>
            	
              <h3 class="mb-0">Users</h3>
            </div>
            <div class="table-responsive">
              <table  class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                	
                  <tr v-for="user in users">
                   
                   <td>@{{user.name}}</td>
                   <td>@{{user.created_at}}</td>
                   <td>
                   			<button class="btn btn-info" @click="showEditUserModal(user)">Edit</button>
                   			<button class="btn btn-danger" @click="deleteUser(user)">Delete</button>
                   	</td>
          
                  </tr>

                  <tr v-if="users.length==0">
                  	<td colspan="3">No users found</td>
                  </tr>
                  
                  
                
                </tbody>
              </table>
            </div>
            <div class="card-footer py-4">
              <nav aria-label="...">
                <ul class="pagination justify-content-end mb-0">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">
                      <i class="fas fa-angle-left"></i>
                      <span class="sr-only">Previous</span>
                    </a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">
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
	<script>$("#users").addClass("active");</script>
	<script src="/js/users.js"></script>
@endsection