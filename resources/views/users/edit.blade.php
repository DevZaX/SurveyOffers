@extends('master')

@section('content')

<div class="row" id="app">
        <div  class="col">
          <div class="card shadow">
          	<div v-cloak v-show="!loading">
            <div class="card-header border-0">
            	
            	<div v-show="successMessage">
	            	<div  class="alert alert-success">
	            		@{{successMessage}}
	            	</div>
	            	<hr style="border: 0">
            	</div>

            </div>

            <div class="container">
                <p style="color: red;">@{{ message }}</p>
            	<h2>Edit profile</h2>
            	<div class="form-group">
            		<label>Name:</label>
            		<input type="text" class="form-control" v-model="user.name">
            		<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
            	</div>
            	<div class="form-group">
            		<label>Email:</label>
            		<input type="text" class="form-control" v-model="user.email">
            		<div style="color: red;" v-if="error.email && error.email.length>0">@{{error.email[0]}}</div>
            	</div>
            	<div class="form-group">
	            	<button class="btn btn-primary" @click="toggleEditPassword">Edit password</button>
	            </div>
            	<div v-show="editPassword">
	            	<div class="form-group">
	            		<label>Old password:</label>
	            		<input type="text" class="form-control" v-model="user.current_password">
	            		<div style="color: red;" v-if="error.current_password && error.current_password.length>0">@{{error.current_password[0]}}</div>
	            	</div>
	            	<div class="form-group">
	            		<label>New password:</label>
	            		<input type="text" class="form-control" v-model="user.password">
	            		<div style="color: red;" v-if="error.password && error.password.length>0">@{{error.password[0]}}</div>
	            	</div>
	            	<div class="form-group">
	            		<label>Confirm password:</label>
	            		<input type="text" class="form-control" v-model="user.password_confirmation">
	            		<div style="color: red;" v-if="error.confirmation_password && error.confirmation_password.length>0">@{{error.confirmation_password[0]}}</div>
	            	</div>
	            </div>
	            <div class="form-group">
	            	<button class="btn btn-primary" @click="updateUser()">Save changes</button>
	            </div>
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
	<script src="/js/editUser.js"></script>
@endsection