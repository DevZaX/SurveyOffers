var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		offers:[],
		offerToStore:{},
		uploadingImage:false,
		successMessage:"",
		error:{},
		message:"",
		offerToUpdate:{},
	},
	methods: {
		getOffers(){
			axios.get("/api/getOffers")
			.then((res)=>{
				this.offers = res.data;
			})
		},
		showCreateOfferModal(){
			this.emptyErrors();
			$("#createOfferModal").modal();
		},
		hideCreateOfferModal(){
			this.emptyErrors();
			$("#createOfferModal").modal("hide");
		},
		chooseImage(){
			$("#file").click();
		},
		uploadImage($event){
			this.uploadingImage=true;
			var formData = new FormData();
			formData.append("image",$event.target.files[0]);
			axios.post("/api/uploadImage",formData)
			.then((res)=>{
				console.log(res);
				this.offerToStore.image_path = res.data;
				this.uploadingImage=false;
			})
		},
		storeOffer(){
			this.emptyErrors();
			axios.post("/api/storeOffer",this.offerToStore)
			.then((res)=>{
				this.getOffers();
				this.hideCreateOfferModal();
				this.showSuccessMessage("Offer was created successfully")
			})
			.catch((err)=>{
				console.log(err);
				this.fillErrors(err);
			})
		},
		fillErrors(err){
			if(err.response){
				this.error= err.response.data.errors;
				this.message = err.response.data.message;
			}
		},
		emptyErrors(){
			this.error = {};
			this.message = "";
		},
		showSuccessMessage(message){
			this.successMessage = message;
			setTimeout(()=>{
				this.successMessage = "";
			},1500);
		},
		deleteOffer(offer){
			if(!confirm("delete offer ?")) return;
			axios.delete(`/api/deleteOffer/${offer.id}`)
			.then((res)=>{
				this.getOffers();
				this.showSuccessMessage("Offer was deleted successfully");
			})
		},
		activateOffer(offer){
			axios.put(`/api/offers/${offer.id}`,{status:1})
			.then((res)=>{
				this.getOffers();
				this.showSuccessMessage("Offer ws activated successfully");
			})
		},
		deactivateOffer(offer){
			axios.put(`/api/offers/${offer.id}`,{status:0})
			.then((res)=>{
				this.getOffers();
				this.showSuccessMessage("Offer ws deactivated successfully");
			})
		},
		showEditOfferModal(offer){
			this.emptyErrors();
			this.offerToUpdate = offer;
			$("#editOfferModal").modal();
		},
		hideEditOfferModal(){
			this.emptyErrors();
			$("#editOfferModal").modal("hide");
		},
		updateOffer(){
			this.emptyErrors();
			axios.put(`/api/offers/${this.offerToUpdate.id}`,this.offerToUpdate)
			.then((res)=>{
				this.getOffers();
				this.hideEditOfferModal();
				this.showSuccessMessage("Offer ws updated successfully");
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		}
	},
	created(){
		this.getOffers();
		this.loading=false;
	}
})