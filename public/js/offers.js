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
		offerToPreview:{stars:4},
		categories:[],
		stayOnThisPage:false,
		newText:"",
		market_priceText:"",
		today_priceText:"",
		shippingText:"",
		availableText:"",
		usersText:"",
		buttonText:"",
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
		geo:"",
		group_id:"",
		groups:[],
	},
	methods: {
		getOffers(){
			axios.get("/api/getOffers?page="+this.page+"&filter="+this.filter+"&status="+this.status+"&geo="+this.geo+"&group_id="+this.group_id)
			.then((res)=>{
				this.offers = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateOfferModal(){
			this.offerToStore = {};
			this.offerToStore.group_id = $("#groupId").val();
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
				this.offerToUpdate.image_path = res.data;
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
				this.showSuccessMessage("Offer was created successfully");
				this.offerToStore = {};
				if(!this.stayOnThisPage) this.hideCreateOfferModal();
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
			this.offerToUpdate = {};
			this.offerToUpdate.group_id = $("#groupId").val();
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
			axios.get("api/AllGroups")
			.then((res)=>{
				this.groups = res.data.data;
			})
		},
		showPreview(offer)
		{
			this.offerToPreview = this.offers.find((o)=>(o.id===offer.id));
			var geo = offer.geo;
			var ar = Object.keys(lang).find((key)=>(key===geo));
			if(!ar)
			{
				alert("fix the language dictionary");
				return;
			}
			console.log(lang[ar]);
			this.availableText = lang[ar].availableText;
			this.buttonText = lang[ar].buttonText;
			this.market_priceText = lang[ar].market_priceText;
			this.newText = lang[ar].newText;
			this.shippingText = lang[ar].shippingText;
			this.today_priceText = lang[ar].today_priceText;
			this.usersText = lang[ar].usersText;
			$('#preview').modal();
		},
		getCategories()
		{
			axios.get("api/AllCategories")
			.then((res)=>{
				this.categories = res.data.data;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		toggleStayOnThisPage()
		{
			this.stayOnThisPage = !this.stayOnThisPage;
		},
		getGroups()
		{
			axios.get("api/AllGroups")
			.then((res)=>{
				this.groups = res.data.data;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		}
	
	},
	created(){
		this.getOffers();
		this.getGroups();
		this.getCategories();
		this.loading=false;
	},
	computed:{
		range:function(){
			return this.offerToPreview.stars;
		},
		pages:function(){
			var ar = [];
			for(var i=1;i<=this.numberOfPages;i++)
			{
				ar.push(i);
			}
			return ar;
		}
	}
})