@extends('master')

@section('content')
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Themes</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						@can("index",\App\User::class)
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateThemeModal">Create new Theme</button>
						@endcan

						<!--create modal -->
						<div id="createThemeModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new theme</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Theme name:</label>
											<input type="text" class="form-control" v-model="themeToStore.name">
											<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
										</div>
										<div class="form-group">
											<label>Theme Geo:</label>
											<select class="form-control" v-model="themeToStore.geo"> 
														<option value="AT">AT</option>
														<option value="AU">AU</option>
														<option value="BE">BE</option>
														<option value="BR">BR</option>
														<option value="CA">CA</option>
														<option value="CH">CH</option>
														<option value="DE">DE</option>
														<option value="DK">DK</option>
														<option value="ES">ES</option>
														<option value="FI">FI</option>
														<option value="FR">FR</option>
														<option value="IE">IE</option>
														<option value="IT">IT</option>
														<option value="NL">NL</option>
														<option value="NO">NO</option>
														<option value="NZ">NZ</option>
														<option value="PL">PL</option>
														<option value="PT">PT</option>
														<option value="SE">SE</option>
														<option value="UK">UK</option>
														<option value="US">US</option>
													</select>
											<div style="color: red;" v-if="error.geo && error.geo.length>0">@{{error.geo[0]}}</div>
										</div>
										<div class="form-group">
													<input style="visibility: hidden;" type="file" id="file" @change="uploadImage">
													<div style="color: red;" v-if="error.image_path && error.image_path.length>0">@{{error.image_path[0]}}</div>
													<div style="color: red;" v-if="error.theme_preview && error.theme_preview.length>0">@{{error.theme_preview[0]}}</div>
													<button v-if="!uploadingImage" class="btn btn-primary" @click="chooseImage" style="display: block;">Add image</button>
													<hr style="border: 0">
													<img v-if="uploadingImage" src="/img/lg.walking-clock-preloader.gif" style="width: 100px">
													<img v-if="themeToStore.theme_preview" :src="'/storage/'+themeToStore.theme_preview" style="width: 100px" />
												</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeTheme">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editThemeModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit theme</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										
										
												<div class="form-group">
													<label>Theme name:</label>
													<input type="text" class="form-control" v-model="themeToUpdate.name">
													<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
												</div>
												<div class="form-group">
													<label>Theme geo:</label>
													<select class="form-control" v-model="themeToUpdate.geo"> 
														<option value="AT">AT</option>
														<option value="AU">AU</option>
														<option value="BE">BE</option>
														<option value="BR">BR</option>
														<option value="CA">CA</option>
														<option value="CH">CH</option>
														<option value="DE">DE</option>
														<option value="DK">DK</option>
														<option value="ES">ES</option>
														<option value="FI">FI</option>
														<option value="FR">FR</option>
														<option value="IE">IE</option>
														<option value="IT">IT</option>
														<option value="NL">NL</option>
														<option value="NO">NO</option>
														<option value="NZ">NZ</option>
														<option value="PL">PL</option>
														<option value="PT">PT</option>
														<option value="SE">SE</option>
														<option value="UK">UK</option>
														<option value="US">US</option>
													</select>
													<div style="color: red;" v-if="error.geo && error.geo.length>0">@{{error.geo[0]}}</div>
												</div>
												<div class="form-group">
													<input style="visibility: hidden;" type="file" id="file" @change="uploadImage">
													<div style="color: red;" v-if="error.theme_preview && error.theme_preview.length>0">@{{error.theme_preview[0]}}</div>
													<button v-if="!uploadingImage" class="btn btn-primary" @click="chooseImage" style="display: block;">Add image</button>
													<hr style="border: 0">
													<img v-if="uploadingImage" src="/img/lg.walking-clock-preloader.gif" style="width: 100px">
													<img v-if="themeToUpdate.theme_preview" :src="'/storage/'+themeToUpdate.theme_preview" style="width: 100px" />
												</div>
												<div class="form-group">
													<label><input type="checkbox" v-model="themeToUpdate.status"> Active</label>
												</div>
											
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateTheme">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- preview modal -->
						<div id="themePreviewModal" class="modal" tabindex="-1" role="dialog">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						        <img :src="'/storage/'+themeToPreview.theme_preview" style="max-width: 100%">
						      </div>
						    </div>
						  </div>
						</div>

						

						<hr style="border: 0">

						<div class="row container">
							<div class="col-4">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getThemes()" />
							</div>
							<div class="col-4">
								<label>Geo</label>
								<select class="form-control" v-model="geo" @change="page=1;getThemes()">
									<option></option>
									<option value="AT">AT</option>

														<option value="AU">AU</option>
														<option value="BE">BE</option>
														<option value="BR">BR</option>
														<option value="CA">CA</option>
														<option value="CH">CH</option>
														<option value="DE">DE</option>
														<option value="DK">DK</option>
														<option value="ES">ES</option>
														<option value="FI">FI</option>
														<option value="FR">FR</option>
														<option value="IE">IE</option>
														<option value="IT">IT</option>
														<option value="NL">NL</option>
														<option value="NO">NO</option>
														<option value="NZ">NZ</option>
														<option value="PL">PL</option>
														<option value="PT">PT</option>
														<option value="SE">SE</option>
														<option value="UK">UK</option>
														<option value="US">US</option>
								</select>
							</div>
							<div class="col-4">
								<label>Status</label>
								<select class="form-control" v-model="status" @change="page=1;getThemes()">
									<option value="">All</option>
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
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
								 	<a @click="getThemes(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getThemes()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getThemes(++page)" class="page-link" href="javascript:void(0)">
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
										<th scope="col">Theme name</th>
										<th scope="col">Theme geo</th>
										<th scope="col"> Status </th>
										<th scope="col">Created at</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="theme in themes">
										<td>
											@{{ theme.name}}
										</td>
										<td>@{{ theme.geo }}</td>
										<td>@{{ theme.status ? "active" : "inactive" }}</td>
										<td>@{{ theme.created_at }}</td>
										<td>
											@can("index",\App\User::class)
											<button class="btn btn-info" @click="showEditThemeModal(theme)"> Edit </button>
											@endcan
											@can("index",\App\User::class)
											<button class="btn btn-danger" @click="deleteTheme(theme)"> Delete </button>
											@endcan
											<button class="btn btn-warning" @click="preview(theme)"> Preview </button>
										</td>
									</tr>
									<tr v-if="themes.length==0">
										<td colspan="3">
											No themes found
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
								 	<a @click="getThemes(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getThemes()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getThemes(++page)" class="page-link" href="javascript:void(0)">
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
	<script>
		var tokens = @json( config("tokens") );
	</script>
	<script>$("#themes").addClass("active");</script>
	<script>$("#configurationIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".configurationItems").toggle();</script>
	<script src="/js/themes.js"></script>
@endsection