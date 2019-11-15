@extends('master')

@section('content')
	
	<div class="row" id="app">
		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
					</div>
					<div>
						<button class="btn btn-primary" @click="showCreateOfferModal">Create new offer</button>

						<!--create modal -->
						<div id="createOfferModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Create new offer</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-4">
												<div class="form-group">
													<label>Offer name:</label>
													<input type="text" class="form-control" v-model="offerToStore.offer_name">
													<div style="color: red;" v-if="error.offer_name && error.offer_name.length>0">@{{error.offer_name[0]}}</div>
												</div>
												<div class="form-group">
													<label>Category:</label>
													<input type="text" class="form-control" v-model="offerToStore.category">
													<div style="color: red;" v-if="error.category && error.category.length>0">@{{error.category[0]}}</div>
												</div>
												<div class="form-group">
													<label>URL:</label>
													<input type="text" class="form-control" v-model="offerToStore.url">
													<div style="color: red;" v-if="error.url && error.url.length>0">@{{error.url[0]}}</div>
												</div>
												<div class="form-group">
													<input style="visibility: hidden;" type="file" id="file" @change="uploadImage">
													<div style="color: red;" v-if="error.image_path && error.image_path.length>0">@{{error.image_path[0]}}</div>
													<button v-if="!uploadingImage" class="btn btn-primary" @click="chooseImage" style="display: block;">Add image</button>
													<hr style="border: 0">
													<img v-if="uploadingImage" src="/img/lg.walking-clock-preloader.gif" style="width: 100px">
													<img v-if="offerToStore.image_path" :src="'/storage/'+offerToStore.image_path" style="width: 100px" />
												</div>
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Number of products available:</label>
													<input type="text" class="form-control" v-model="offerToStore.products_available">
													<div style="color: red;" v-if="error.products_available && error.products_available.length>0">@{{error.products_available[0]}}</div>
												</div>
												<div class="form-group">
													<label>Market price:</label>
													<input type="text" class="form-control" v-model="offerToStore.market_price">
													<div style="color: red;" v-if="error.market_price && error.market_price.length>0">@{{error.market_price[0]}}</div>
												</div>
												<div class="form-group">
													<label>Today's price:</label>
													<input type="text" class="form-control" v-model="offerToStore.today_price">
													<div style="color: red;" v-if="error.today_price && error.today_price.length>0">@{{error.today_price[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of stars:</label>
													<input type="text" class="form-control" v-model="offerToStore.stars">
													<div style="color: red;" v-if="error.stars && error.stars.length>0">@{{error.stars[0]}}</div>
												</div>
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Currency:</label>
													<input type="text" class="form-control" v-model="offerToStore.currency">
													<div style="color: red;" v-if="error.currency && error.currency.length>0">@{{error.currency[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of users choose the product:</label>
													<input type="text" class="form-control" v-model="offerToStore.users_number">
													<div style="color: red;" v-if="error.users_number && error.users_number.length>0">@{{error.users_number[0]}}</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="storeOffer">Save changes</button>
									</div>
								</div>
							</div>
						</div>


						<!-- edit modal -->
						<div id="editOfferModal" class="modal" tabindex="-1" role="dialog">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									 <div class="modal-header">
									 	<h5 class="modal-title">Edit offer</h5>
									 	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									 	 	<span aria-hidden="true">&times;</span>
									 	</button>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-4">
												<div class="form-group">
													<label>Offer name:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.offer_name">
													<div style="color: red;" v-if="error.offer_name && error.offer_name.length>0">@{{error.offer_name[0]}}</div>
												</div>
												<div class="form-group">
													<label>Category:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.category">
													<div style="color: red;" v-if="error.category && error.category.length>0">@{{error.category[0]}}</div>
												</div>
												<div class="form-group">
													<label>URL:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.url">
													<div style="color: red;" v-if="error.url && error.url.length>0">@{{error.url[0]}}</div>
												</div>
												<div class="form-group">
													<input style="visibility: hidden;" type="file" id="file" @change="uploadImage">
													<div style="color: red;" v-if="error.image_path && error.image_path.length>0">@{{error.image_path[0]}}</div>
													<button v-if="!uploadingImage" class="btn btn-primary" @click="chooseImage" style="display: block;">Add image</button>
													<hr style="border: 0">
													<img v-if="uploadingImage" src="/img/lg.walking-clock-preloader.gif" style="width: 100px">
													<img v-if="offerToUpdate.image_path" :src="'/storage/'+offerToUpdate.image_path" style="width: 100px" />
												</div>
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Number of products available:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.products_available">
													<div style="color: red;" v-if="error.products_available && error.products_available.length>0">@{{error.products_available[0]}}</div>
												</div>
												<div class="form-group">
													<label>Market price:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.market_price">
													<div style="color: red;" v-if="error.market_price && error.market_price.length>0">@{{error.market_price[0]}}</div>
												</div>
												<div class="form-group">
													<label>Today's price:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.today_price">
													<div style="color: red;" v-if="error.today_price && error.today_price.length>0">@{{error.today_price[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of stars:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.stars">
													<div style="color: red;" v-if="error.stars && error.stars.length>0">@{{error.stars[0]}}</div>
												</div>
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Currency:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.currency">
													<div style="color: red;" v-if="error.currency && error.currency.length>0">@{{error.currency[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of users choose the product:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.users_number">
													<div style="color: red;" v-if="error.users_number && error.users_number.length>0">@{{error.users_number[0]}}</div>
												</div>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="button" class="btn btn-primary" @click="updateOffer">Save changes</button>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div v-if="successMessage">
							<div class="alert alert-success">
								@{{successMessage}}
							</div>
							<hr>
						</div>

						<div class="">
							<table  class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th scope="col">Offer name</th>
										<th scope="col">Status</th>
										<th scope="col">Category</th>
										<th scope="col">Url</th>
										<th scope="col">Created at</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="offer in offers">
										<td>@{{offer.offer_name}}</td>
										<td>@{{offer.status}}</td>
										<td>@{{offer.category}}</td>
										<td>@{{offer.url}}</td>
										<td>@{{offer.created_at}}</td>
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
													 <a class="dropdown-item" href="javascript:void(0)" @click="showEditOfferModal(offer)" >Edit</a>
													 <a class="dropdown-item" href="javascript:void(0)" @click="activateOffer(offer)">Activate</a>
													 <a class="dropdown-item" href="javascript:void(0)" @click="deactivateOffer(offer)">Deactivate</a>
													 <a class="dropdown-item" href="javascript:void(0)" @click="deleteOffer(offer)">Delete</a>
												</div>		
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
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
	<script>$("#offers").addClass("active");</script>
	<script src="/js/offers.js"></script>
@endsection