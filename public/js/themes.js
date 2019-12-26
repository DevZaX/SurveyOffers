var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		themes:[],
		themeToStore:{},
		successMessage:"",
		error:{},
		message:"",
		themeToUpdate:{},
		filter:"",
		page:1,
		uploadingImage:false,
		uploadImageError:"",
		themeToPreview:{},
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
		geo:"",
		status:"",
		themeName:"",
		themeStatus:"",
		themeCreated:"",
		themeGeo:"",
		limits:limits,
		limit:limits[0],
		sortBy:"id",
		sortType:"desc",
	},
	methods: {
		getThemes(){
			var url = "/api/getThemes?page="+this.page;
			url += "&themeName="+this.themeName;
			url += "&themeStatus="+this.themeStatus;
			url += "&themeCreated="+this.themeCreated;
			url += "&themeGeo="+this.themeGeo;
			url += "&limit="+this.limit;
			url += "&sortBy="+this.sortBy;
			url += "&sortType="+this.sortType;
			axios.get(url)
			.then((res)=>{
				this.themes = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateThemeModal(){
			this.emptyErrors();
			$("#createThemeModal").modal();
		},
		hideCreateThemeModal(){
			this.emptyErrors();
			$("#createThemeModal").modal("hide");
		},
		storeTheme(){
			this.emptyErrors();
			axios.post("/api/storeTheme",this.themeToStore)
			.then((res)=>{
				this.getThemes();
				this.hideCreateThemeModal();
				this.showSuccessMessage("Theme was created successfully");
				this.themeToStore = {};
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
		deleteTheme(theme){
			if(!confirm("delete theme ?")) return;
			axios.delete(`/api/deleteTheme/${theme.id}`)
			.then((res)=>{
				this.getThemes();
				this.showSuccessMessage("Theme was deleted successfully");
			})
		},
		showEditThemeModal(theme){
			this.emptyErrors();
			this.themeToUpdate = theme;
			$("#editThemeModal").modal();
		},
		hideEditThemeModal(){
			this.emptyErrors();
			$("#editThemeModal").modal("hide");
		},
		updateTheme(){
			this.emptyErrors();
			axios.put(`/api/themes/${this.themeToUpdate.id}`,this.themeToUpdate)
			.then((res)=>{
				this.getThemes();
				this.hideEditThemeModal();
				this.showSuccessMessage("Theme ws updated successfully");
				this.themeToUpdate = {};
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
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
				this.themeToStore.theme_preview = res.data;
				this.themeToUpdate.theme_preview = res.data;
				this.uploadingImage=false;
			})
			.catch((err)=>{
				this.uploadingImage=false;
				this.fillErrors(err);
			})
		},
		preview(theme)
		{
			this.themeToPreview = theme;
			this.showThemePreviewModal();
		},
		showThemePreviewModal()
		{
			$("#themePreviewModal").modal();
		},
		filterThemes()
		{
			this.page = 1;
			this.getThemes();
		},
		sort(string)
		{
			if(string="themeName")
			{
				this.sortBy = "name";
			}

			this.sortType = this.sortType == "asc" ? "desc" : "asc";

			this.filterThemes();
		}
	},
	created(){
		this.getThemes();
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