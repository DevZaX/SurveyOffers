var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		categories:[],
		categoryToStore:{},
		successMessage:"",
		error:{},
		message:"",
		categoryToUpdate:{},
		filter:"",
		page:1,
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
	},
	methods: {
		getCategories(){
			axios.get("/api/getCategories?page="+this.page+"&filter="+this.filter)
			.then((res)=>{
				this.categories = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateCategoryModal(){
			this.emptyErrors();
			$("#createCategoryModal").modal();
		},
		hideCreateCategoryModal(){
			this.emptyErrors();
			$("#createCategoryModal").modal("hide");
		},
		storeCategory(){
			this.emptyErrors();
			axios.post("/api/storeCategory",this.categoryToStore)
			.then((res)=>{
				this.getCategories();
				this.hideCreateCategoryModal();
				this.showSuccessMessage("Category was created successfully");
				this.categoryToStore = {};
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
		deleteCategory(category){
			if(!confirm("delete category ?")) return;
			axios.delete(`/api/deleteCategory/${category.id}`)
			.then((res)=>{
				this.getCategories();
				this.showSuccessMessage("Category was deleted successfully");
			})
		},
		showEditCategoryModal(category){
			this.emptyErrors();
			this.categoryToUpdate = category;
			$("#editCategoryModal").modal();
		},
		hideEditCategoryModal(){
			this.emptyErrors();
			$("#editCategoryModal").modal("hide");
		},
		updateCategory(){
			this.emptyErrors();
			axios.put(`/api/categories/${this.categoryToUpdate.id}`,this.categoryToUpdate)
			.then((res)=>{
				this.getCategories();
				this.hideEditCategoryModal();
				this.showSuccessMessage("Category ws updated successfully");
				this.categoryToUpdate = {};
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
	},
	created(){
		this.getCategories();
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