var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		domains:[],
		domainToStore:{},
		successMessage:"",
		error:{},
		message:"",
		domainToUpdate:{},
		filter:"",
		page:1,
		groups:[],
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
		limits:limits,
		limit:limits[0],
		domainName:"",
		domainStatus:"",
		domainGroupId:"",
		domainCreated:"",
		sortBy:"id",
		sortType:"desc",
	},
	methods: {
		getDomains(){
			var url = "/api/getDomains?page="+this.page;
			url += "&domainName="+this.domainName;
			url += "&domainStatus="+this.domainStatus;
			url += "&domainGroupId="+this.domainGroupId;
			url += "&domainCreated="+this.domainCreated;
			url += "&limit="+this.limit;
			url += "&sortBy="+this.sortBy;
			url += "&sortType="+this.sortType;
			axios.get(url)
			.then((res)=>{
				this.domains = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateDomainModal(){
			this.emptyErrors();
			$("#createDomainModal").modal();
		},
		hideCreateDomainModal(){
			this.emptyErrors();
			$("#createDomainModal").modal("hide");
		},
		storeDomain(){
			this.emptyErrors();
			axios.post("/api/storeDomain",this.domainToStore)
			.then((res)=>{
				this.getDomains();
				this.hideCreateDomainModal();
				this.showSuccessMessage("Domain was created successfully");
				this.domainToStore = {};
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
		deleteDomain(group){
			if(!confirm("delete domain ?")) return;
			axios.delete(`/api/deleteDomain/${group.id}`)
			.then((res)=>{
				this.getDomains();
				this.showSuccessMessage("Domain was deleted successfully");
			})
		},
		showEditDomainModal(group){
			this.emptyErrors();
			this.domainToUpdate = group;
			$("#editDomainModal").modal();
		},
		hideEditDomainModal(){
			this.emptyErrors();
			$("#editDomainModal").modal("hide");
		},
		updateDomain(){
			this.emptyErrors();
			axios.put(`/api/domains/${this.domainToUpdate.id}`,this.domainToUpdate)
			.then((res)=>{
				this.getDomains();
				this.hideEditDomainModal();
				this.showSuccessMessage("Domain ws updated successfully");
				this.domainToUpdate = {};
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
		filterDomains()
		{
			this.page = 1;
			this.getDomains();
		},
		sort(string)
		{
			if(string=="domainName")
			{
				this.sortBy = "name";
			}
			this.sortType = this.sortType == "asc" ? "desc" : "asc";
			this.filterDomains();
		}
	},
	created(){
		this.getDomains();
		this.getGroups();
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