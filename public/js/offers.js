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
		uploadImageError:"",
		filter:"",
		page:1,
		selectedOffers:[],
		status:"",
		groups:[],
	},
	methods: {
		getOffers(){
			axios.get("/api/getOffers?page="+this.page+"&filter="+this.filter+"&status="+this.status)
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
			.catch((err)=>{
				this.uploadingImage=false;
				this.fillErrors(err);
			})
		},
		storeOffer(){
			this.emptyErrors();
			axios.post("/api/storeOffer",this.offerToStore)
			.then((res)=>{
				this.getOffers();
				this.hideCreateOfferModal();
				this.showSuccessMessage("Offer was created successfully");
				this.offerToStore = {};
			})
			.catch((err)=>{
				console.log(err);
				this.fillErrors(err);
			})
		},
		fillErrors(err){
			if(err.response.data.message) this.message = err.response.data.message;
			if(err.response.data.errors) this.error= err.response.data.errors;
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
				this.offerToUpdate = {};
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		checkBoxClicked($event,id)
		{
			if($event.target.checked)
			{
				this.selectedOffers.push(id);
			}
			else
			{
				this.selectedOffers = this.selectedOffers.filter((item)=>(item!=id));
			}
		},
		doAction(action)
		{
			this.emptyErrors();
			axios.post("api/action/"+action,this.selectedOffers)
			.then((res)=>{
				console.log(res);
				this.showSuccessMessage("Success");
				this.getOffers();
			}).catch((err)=>{
				this.fillErrors();
			})
		},
		getGroups()
		{
			axios.get("api/offers/groups")
			.then((res)=>{
				this.groups = res.data.data;
			})
		}
	},
	created(){
		this.getOffers();
		this.getGroups();
		this.loading=false;
	}
})