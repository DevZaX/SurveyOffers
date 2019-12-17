var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		templates:[],
		templateToStore:{},
		successMessage:"",
		error:{},
		message:"",
		templateToUpdate:{},
		filter:"",
		page:1,
		selectedTemplate:{},
		filteredOffer:"",
		offers:[],
		searchPage:1,
		selectedTemplateOffers:[],
		listOffers:[],
		domain:"",
		themes:[],
		isThemesShowed:false,
		allThemes:[],
		groups:[],
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
		geo:"",
		group_id:"",
	},
	methods: {
		getTemplates(){
			axios.get("/api/getTemplates?page="+this.page+"&filter="+this.filter+"&geo="+this.geo+"&group_id="+this.group_id)
			.then((res)=>{
				this.templates = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateTemplateModal(){
			this.emptyErrors();
			$("#createTemplateModal").modal();
		},
		hideCreateTemplateModal(){
			this.emptyErrors();
			$("#createTempalteModal").modal("hide");
		},
		storeTemplate(){
			this.emptyErrors();
			axios.post("/api/storeTemplate",this.templateToStore)
			.then((res)=>{
				this.getTemplates();
				this.hideCreateTemplateModal();
				this.showSuccessMessage("Template was created successfully");
				this.templateToStore = {};
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
		deleteTemplate(template){
			if(!confirm("delete template ?")) return;
			axios.delete(`/api/deleteTemplate/${template.id}`)
			.then((res)=>{
				this.getTemplates();
				this.showSuccessMessage("Template was deleted successfully");
			})
		},
		showEditTemplateModal(template){
			this.emptyErrors();
			this.templateToUpdate = template;
			$("#editTemplateModal").modal();
		},
		hideEditTemplateModal(){
			this.emptyErrors();
			$("#editTemplateModal").modal("hide");
		},
		updateTemplate(){
			this.emptyErrors();
			axios.put(`/api/templates/${this.templateToUpdate.id}`,this.templateToUpdate)
			.then((res)=>{
				this.getTemplates();
				this.hideEditTemplateModal();
				this.showSuccessMessage("Template ws updated successfully");
				this.templateToUpdate = {};
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		showAssignOffersModal(template)
		{
			this.selectedTemplate = template;
			this.templateOffers();
			$("#assignOffersModal").modal();
		},
		searchOffer()
		{
			if(this.searchPage<1) return;
			axios.post("api/allOffers?page="+this.searchPage,
				{
					filteredOffer:this.filteredOffer,
					listOffers:this.selectedTemplateOffers,
					geo:this.selectedTemplate.geo,
					group_id:this.selectedTemplate.group_id,
				}
			)
			.then((res)=>{
				this.offers = res.data.data;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		attachOfferToTemplate(offer)
		{
			axios.post("api/attachOfferToTemplate",{offer_id:offer.id,template_id:this.selectedTemplate.id})
			.then((res)=>{
				this.getTemplates();
				this.templateOffers(this.selectedTemplate);
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		detachOfferFromTemplate(offer)
		{
			axios.post("api/detachOfferFromTemplate",{offer_id:offer.id,template_id:this.selectedTemplate.id})
			.then((res)=>{
				this.getTemplates();
				this.templateOffers(this.selectedTemplate);
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		templateOffers()
		{
			axios.get("api/templateOffers/"+this.selectedTemplate.id)
			.then((res)=>{
				this.selectedTemplateOffers = res.data.data;
				this.searchOffer(this.selectedTemplate);
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		goToTemplate(template)
		{
			var a = document.createElement("a");
			a.href=this.domain.name+"/?g="+$("#groupId").val()+"&t="+template.geo;
			a.target = "_blank";
			document.body.appendChild(a);
			a.click();
		},
		getDomainByGroupId()
		{
			axios.get("api/getDomainByGroupId/"+$("#groupId").val())
			.then((res)=>{
				if(!res)
				{
					this.domain = null;
					return;
				}
				this.domain = res.data.data;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		domainValue(template)
		{
			if(!this.domain) return "";
			return this.domain.name+"/?g="+template.group_id+"&t="+template.geo+"&tid="+template.theme_id+"&tmp="+template.id+"&trk=[trk]&clk=[clk]";
		},
		getThemes(geo)
		{
			axios.get("api/getThemes/"+geo)
			.then((res)=>{
				this.themes = res.data.data;
				console.log(this.themes);
				if( this.themes.length > 0 ) this.isThemesShowed=true;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		showThemes(number)
		{
			if(number==1) this.getThemes(this.templateToStore.geo);
			if(number==2) this.getThemes(this.templateToUpdate.geo);
		},
		getAllThemes()
		{
			axios.get("api/getAllTheme")
			.then((res)=>{
				this.allThemes = res.data.data;
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		getGroups()
		{
			axios.get("api/AllGroups")
			.then((res)=>{
				this.groups = res.data.data;
			})
		},
	},
	created(){
		this.getTemplates();
		this.getDomainByGroupId();
		this.getGroups();
		if( $('#superAdmin').val() == 0 ) this.templateToStore.group_id = $("#groupId").val();
		this.loading=false;
	},
	computed:{
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