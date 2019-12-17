@extends('master')

@section('content')
	<input type="hidden" id="groupId" value="{{ auth()->user()->group ? auth()->user()->group->id : null }}">
	<input type="hidden" id="superAdmin" value="{{ auth()->user()->superAdmin }}">
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Templates</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateTemplateModal">Create new Template</button>

						<!--create modal -->
						<div id="createTemplateModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new template</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="form-group">
											<label>Template name:</label>
											<input type="text" class="form-control" v-model="templateToStore.name">
											<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
										</div>
										<div class="form-group">
											<label>Template Geo:</label>
											<select class="form-control" v-model="templateToStore.geo" @change="showThemes(1)"> 
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
										
										@if(auth()->user()->superAdmin)
											<div class="form-group">
												<label>Group</label>
												<select class="form-control" v-model="templateToStore.group_id">
													<option v-for="group in groups" :value="group.id">@{{group.name}}</option>
												</select>
												<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
											</div>
										@endif

										<div v-show="isThemesShowed" class="form-group">
											<label>Template theme</label>
											<select class="form-control" v-model="templateToStore.theme_id">
												<option v-for="theme in themes" :value="theme.id">@{{theme.name}}</option>
											</select>
											<div style="color: red;" v-if="error.theme_id && error.theme_id.length>0">
												@{{error.theme_id[0]}}
											</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeTemplate">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editTemplateModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit template</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										
										
												<div class="form-group">
													<label>Template name:</label>
													<input type="text" class="form-control" v-model="templateToUpdate.name">
													<div style="color: red;" v-if="error.name && error.name.length>0">@{{error.name[0]}}</div>
												</div>
												<div class="form-group">
													<label>Template geo:</label>
													<select class="form-control" v-model="templateToUpdate.geo" @change="showThemes(2)"> 
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
												@if( auth()->user()->superAdmin )
													<div class="form-group">
														<label>Group</label>
														<select class="form-control" v-model="templateToUpdate.group_id">
															<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
														</select>
														<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
													</div>
												@endif
											<div v-show="isThemesShowed" class="form-group">
											<label>Template theme</label>
											<select class="form-control" v-model="templateToUpdate.theme_id">
												<option v-for="theme in themes" :value="theme.id">@{{theme.name}}</option>
											</select>
											<div style="color: red;" v-if="error.theme_id && error.theme_id.length>0">
												@{{error.theme_id[0]}}
											</div>
										</div>
												<div class="form-group">
													<label><input type="checkbox" v-model="templateToUpdate.isActive"> Active</label>
												</div>
											
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateTemplate">Save changes</button>
									</div>
								</div>
							</div>
						</div>

						<!-- assign offers modal -->
						<div id="assignOffersModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Assign offers to @{{ selectedTemplate.name }} template</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<div>
											<div v-for="offer in selectedTemplateOffers" style="display: flex;flex-direction: row;">
												<div @click="detachOfferFromTemplate(offer)" style="background-color: #ccc;padding: 8px;border-radius: 8px;width:200px;margin-bottom: 8px;cursor: pointer;">
													@{{ offer.offer_name }}
												</div>
											</div>
										</div>
										<hr>
										<input class="form-control" v-model="filteredOffer" placeholder="Filter offer" @keyup="searchPage=1;searchOffer()">
										<hr style="border:0">
										<div>
											<table class="table table-bordered table-striped">
												<thead>
													<th>name</th>
													<th>geo</th>
													<th>source</th>
												</thead>
												<tbody>
													<tr style="cursor: pointer;" v-for="offer in offers" 
													@click="attachOfferToTemplate(offer)">
														<td>@{{ offer.offer_name }}</td>
														<td>@{{ offer.geo }}</td>
														<td>@{{ offer.source }}</td>
													</tr>
												</tbody>
											</table>
											<hr style="border:0">
											<button  @click="searchPage--;searchOffer(selectedTemplate)">prev</button>
											<button @click="searchPage++;searchOffer(selectedTemplate)">next</button>
										</div>
										
									</div>
								</div>
							</div>
						</div>

						<hr style="border: 0">

						<div class="row container">
							<div class="col-4">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getTemplates()" />
							</div>
								<div class="col-4">
								<label>Geo</label>
								<select class="form-control" v-model="geo" @change="page=1;getTemplates()">
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
							@if(auth()->user()->superAdmin)
							<div class="col-4">
								<div class="form-group">
									<label>Group</label>
									<select class="form-control" v-model="group_id" @change="page=1;getTemplates()">
										<option></option>
										<option v-for="group in groups" :value="group.id">@{{group.name}}</option>
									</select>
								</div>
							</div>
							@endif
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
								 	<a @click="getTemplates(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getTemplates()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getTemplates(++page)" class="page-link" href="javascript:void(0)">
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
										<th scope="col">Template name</th>
										<th scope="col">Template link</th>
										<th scope="col">Template geo</th>
										@if(auth()->user()->superAdmin)
										<th scope="col">Template group</th>
										@endif
										<th scope="col"> Status </th>
										<th scope="col">Created at</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="template in templates">
										<td>
											<a target="_blank" :href="template.domain">@{{ template.name}}</a>
										</td>
										<td>
											<input type="text" :value="template.domain" class="form-control">
										</td>
										<td>@{{ template.geo }}</td>
										@if(auth()->user()->superAdmin)
										<td>@{{ template.group ? template.group.name : "" }}</td>
										@endif
										<td>@{{ template.isActive ? "active" : "inactive" }}</td>
										<td>@{{ template.created_at }}</td>
										<td>
											<button class="btn btn-info" @click="showEditTemplateModal(template)"> Edit </button>
											<button class="btn btn-danger" @click="deleteTemplate(template)"> Delete </button>
											<button class="btn btn-warning" @click="showAssignOffersModal(template)"> Assign offers </button>
										</td>
									</tr>
									<tr v-if="templates.length==0">
										@if(auth()->user()->superAdmin)
										<td colspan="4">
											No templates found
										</td>
										@else
										<td colspan="3">
											No templates found
										</td>
										@endif
										
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				<div class="card-footer py-4">
						<nav aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getTemplates(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getTemplates()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getTemplates(++page)" class="page-link" href="javascript:void(0)">
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
	
	<script>$("#templates").addClass("active");</script>
	<script>$("#offersIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".offersItems").toggle();</script>
	<script src="/js/templates.js"></script>
@endsection