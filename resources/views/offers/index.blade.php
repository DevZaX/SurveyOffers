@extends('master')

@section('content')
	
	<div class="row" id="app">
		<input type="hidden" id="groupId" value="{{ auth()->user()->group_id }}">
		<!-- preview modal -->
		<div id="preview" class="modal" tabindex="-1" role="dialog">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						 <h5 class="modal-title">Preveiw</h5>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						 	<span aria-hidden="true">&times;</span>
						 </button>
					</div>
					<div class="modal-body">
						<div style="display: flex;">
							<div>
								<div><img :src="'/storage/'+offerToPreview.image_path" style="width: 200px"></div>
								<div style="margin-left: 48px;">
									<img v-for="i in range" src="/img/star-filled.png">
									<img v-for="n in 5-range" src="/img/star-empty.png">
								</div>
							</div>
							<div style="width: 400px">
								<ul style="list-style: none;">
									<li><b>@{{ offerToPreview.offer_name }}</b></li>
									<li>@{{ newText }}</li>
									<li>@{{ market_priceText }} : <span style="text-decoration: line-through;">@{{ offerToPreview.market_price }} @{{ offerToPreview.currency }}</span></li>
									<li><b>@{{ today_priceText }} : @{{ offerToPreview.today_price }} @{{ offerToPreview.currency }}</b></li>
									<li>@{{ shippingText }}: 0 @{{ offerToPreview.currency }}</li>
									<li>@{{ availableText }}:</li>
									<li style="color: red">(@{{ offerToPreview.products_available }})</li>
								</ul>
							</div>
							<div style="margin-top: 56px">
								<div><button class="btn" style="background-color: orange;color: white">@{{ buttonText }}</button></div>
								<div><p style="color: green;font-size: 14px">@{{offerToPreview.users_number}} @{{ usersText }}</p></div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<div class="col">
			<div class="card shadow">

				<div v-cloak v-show="!loading">
					<div class="card-header border-0">
						<h3>Offers</h3>
					</div>
					<div>
						<p v-if="message" style="color: red;">@{{ message }}</p>
						@can("store",\App\Offer::class)
						<button style="margin-left: 16px" class="btn btn-primary" @click="showCreateOfferModal">Create new offer</button>
						@endcan

						<!--create modal -->
						<div id="createOfferModal" class="modal" tabindex="-1" role="dialog">
							<div  class="modal-dialog modal-lg" role="document">
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
													<select class="form-control" v-model="offerToStore.category">
														<option v-for="category in categories" :value="category.name">@{{category.name}}</option>
													</select>
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
													<div style="color: red;" v-if="error.image && error.image.length>0">@{{error.image[0]}}</div>
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
													<select class="form-control" v-model="offerToStore.stars">
														<option value="1">1 Star</option>
														<option value="2">2 Stars</option>
														<option value="3">3 Stars</option>
														<option value="4">4 Stars</option>
														<option value="5">5 Stars</option>
													</select>
													<div style="color: red;" v-if="error.stars && error.stars.length>0">@{{error.stars[0]}}</div>
												</div>
												{{-- <div class="form-group">
													<label>Shipping price</label>
													<input type="text" class="form-control" v-model="offerToStore.shippingPrice">
													<div style="color: red;" v-if="error.shippingPrice && error.shippingPrice.length>0">@{{error.shippingPrice[0]}}</div>
												</div> --}}
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Currency:</label>
													<select class="form-control" v-model="offerToStore.currency">
														<option value="€">EUR</option>
														<option value="$">USD</option>
														<option value="£">POUND</option>
													</select>
													<div style="color: red;" v-if="error.currency && error.currency.length>0">@{{error.currency[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of users choose the product:</label>
													<input type="text" class="form-control" v-model="offerToStore.users_number">
													<div style="color: red;" v-if="error.users_number && error.users_number.length>0">@{{error.users_number[0]}}</div>
												</div>
												@if( auth()->user()->superAdmin )
													<div class="form-group">
														<label>Group</label>
														<select class="form-control" v-model="offerToStore.group_id">
															<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
														</select>
														<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
													</div>
												@endif
												<div class="form-group">
													<label>Source:</label>
													<input type="text" class="form-control" v-model="offerToStore.source">
													<div style="color: red;" v-if="error.source && error.source.length>0">@{{error.source[0]}}</div>
												</div>
												<div class="form-group" >
													<label>Geo:</label>
													<select class="form-control" v-model="offerToStore.geo"> 
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
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<div style="margin-right: auto;"><label><input type="checkbox" @change="toggleStayOnThisPage"> Stay on this page after click save changes</label></div>
										<div><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div>
										<div><button type="button" class="btn btn-primary" @click="storeOffer">Save changes</button></div>
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
													<select class="form-control" v-model="offerToUpdate.category">
														<option v-for="category in categories" :value="category.name">@{{category.name}}</option>
													</select>
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
													<select class="form-control" v-model="offerToUpdate.stars">
														<option value="1">1 Star</option>
														<option value="2">2 Stars</option>
														<option value="3">3 Stars</option>
														<option value="4">4 Stars</option>
														<option value="5">5 Stars</option>
													</select>
													<div style="color: red;" v-if="error.stars && error.stars.length>0">@{{error.stars[0]}}</div>
												</div>
											{{-- 	<div class="form-group">
													<label>Shipping price</label>
													<input type="text" class="form-control" v-model="offerToUpdate.shippingPrice">
													<div style="color: red;" v-if="error.shippingPrice && error.shippingPrice.length>0">@{{error.shippingPrice[0]}}</div>
												</div> --}}
											</div>
											<div class="col-4">
												<div class="form-group">
													<label>Currency:</label>
													<select class="form-control" v-model="offerToUpdate.currency">
														<option value="€">EUR</option>
														<option value="$">USD</option>
														<option value="£">POUND</option>
													</select>
													<div style="color: red;" v-if="error.currency && error.currency.length>0">@{{error.currency[0]}}</div>
												</div>
												<div class="form-group">
													<label>Number of users choose the product:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.users_number">
													<div style="color: red;" v-if="error.users_number && error.users_number.length>0">@{{error.users_number[0]}}</div>
												</div>
												@if( auth()->user()->superAdmin )
													<div class="form-group">
														<label>Group</label>
														<select class="form-control" v-model="offerToUpdate.group_id">
															<option v-for="group in groups" :value="group.id">@{{ group.name }}</option>
														</select>
														<div style="color: red;" v-if="error.group_id && error.group_id.length>0">@{{error.group_id[0]}}</div>
													</div>
												@endif
												<div class="form-group">
													<label>Source:</label>
													<input type="text" class="form-control" v-model="offerToUpdate.source">
													<div style="color: red;" v-if="error.source && error.source.length>0">@{{error.source[0]}}</div>
												</div>
												<div class="form-group" >
													<label>Geo:</label>
													<select class="form-control" v-model="offerToUpdate.geo"> 
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

						<hr style="border: 0">

						<div class="row container">
							<div class="col-3">
								<label>Filter</label>
								<input type="text" class="form-control" placeholder="Filter" v-model="filter" @keyup="page=1;getOffers()" />
							</div>
							<div class="col-3">
								<label>Status</label>
								<select class="form-control" v-model="status" @change="page=1;getOffers()">
									<option></option>
									<option value="1">Active</option>
									<option value="0">Not active</option>
								</select>
							</div>
							<div class="col-3">
								<label>Geo</label>
								<select class="form-control" v-model="geo" @change="page=1;getOffers()">
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
							<div class="col-3">
								<label>Group</label>
								<select class="form-control" v-model="group_id" @change="page=1;getOffers()">
									<option></option>
									<option v-for="group in groups" :value="group.id">@{{group.name}}</option>
								</select>
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

						<div class="">
							<div style="display: flex;justify-content: flex-end;margin-right: 32px">
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
													 <a class="dropdown-item" href="javascript:void(0)" @click="doAction('activate')">Activate</a>
													 <a class="dropdown-item" href="javascript:void(0)" @click="doAction('deactivate')">Deactivate</a>
												</div>		
											</div>
										</div>
										<hr style="border: 0">
										<nav style="margin-right: 32px" aria-label="...">
							<ul class="pagination justify-content-end mb-0">
								 <li class="page-item" :class="{'disabled':page==1}">
								 	<a @click="getOffers(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getOffers()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getOffers(++page)" class="page-link" href="javascript:void(0)">
								 		<i class="fas fa-angle-right"></i>
								 		<span class="sr-only">Next</span>
								 	</a>
								 </li>
							</ul>
						</nav>
						<hr style="border:0">
							<table  class="table align-items-center table-flush">
								<thead class="thead-light">
									<tr>
										<th scope="col">Offer name</th>
										<th scope="col">Status</th>
										<th scope="col">Category</th>
										<th scope="col">Created </th>
										@if( auth()->user()->superAdmin )
											<th scope="col">Group</th>
										@endif
										<th scope="col">Geo</th>
										<th scope="col">Source</th>
										<th scope="col">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="offer in offers">
										<td>
											<input type="checkbox" @change="checkBoxClicked($event,offer.id)">
											<label>@{{ offer.offer_name }}</label>
										</td>
										<td>@{{offer.status ? "active" : "inactive"}}</td>
										<td>@{{offer.category}}</td>
										<td>@{{offer.created_at}}</td>
										@if( auth()->user()->superAdmin )
											<td>@{{offer.group.name}}</td>
										@endif
										<td>@{{offer.geo}}</td>
										<td>@{{offer.source}}</td>
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
													@can("update",\App\Offer::class)
													 <a class="dropdown-item" href="javascript:void(0)" @click="showEditOfferModal(offer)" >Edit</a>
													 @endcan
													 <a class="dropdown-item" href="javascript:void(0)" @click="activateOffer(offer)">Activate</a>
													 <a class="dropdown-item" href="javascript:void(0)" @click="deactivateOffer(offer)">Deactivate</a>
													 @can("destroy",\App\Offer::class)
													 <a class="dropdown-item" href="javascript:void(0)" @click="deleteOffer(offer)">Delete</a>
													 @endcan
													 <a class="dropdown-item" href="javascript:void(0)" @click="showPreview(offer)">Preview</a>
												</div>		
											</div>
										</td>
									</tr>
									<tr v-if="offers.length==0">
										@if( auth()->user()->superAdmin )
											<td colspan="7">
												No offers found
											</td>
										@endif
										@if( !auth()->user()->superAdmin )
											<td colspan="6">
												No offers found
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
								 	<a @click="getOffers(--page)" class="page-link" href="javascript:void(0)" tabindex="-1">
								 		<i class="fas fa-angle-left"></i>
								 		<span class="sr-only">Previous</span>
								 	</a>
								 </li>
								 <li v-for="pageNumber in pages.slice(0,lastPage)" class="page-item" :class="{'active':pageNumber==currentPage}">
				                    <a @click="page=pageNumber;getOffers()" class="page-link" href="javascript:void(0)">@{{pageNumber}}</a>
				                 </li>
								 <li class="page-item" :class="{'disabled':page>=pages.length}">
								 	<a @click="getOffers(++page)" class="page-link" href="javascript:void(0)">
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
		var lang = @json( config("lang") );
	</script>
	<script>$("#offers").addClass("active");</script>
	<script>$("#offersIcon").addClass("ni-bold-down").removeClass("ni-bold-right");</script>
	<script>$(".offersItems").toggle();</script>
	<script src="/js/offers.js"></script>
@endsection