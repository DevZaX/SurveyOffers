var app = new Vue({
	el : "#app",
	data : {
		loading: true,
		groups:[],
		groupToStore:{},
		successMessage:"",
		error:{},
		message:"",
		groupToUpdate:{},
		filter:"",
		page:1,
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
		groupName:"",
		groupCreated:"",
		limits:limits,
		limit:limits[0],
		sortBy:"id",
		sortType:"desc",
	},
	methods: {
		getGroups(){
			var url = "/api/getGroups?page="+this.page;
			url += url+"&groupName="+this.groupName;
			url += url+"&groupCreated="+this.groupCreated;
			url += url + "&limit="+this.limit;
			url += url + "&sortBy="+this.sortBy;
			url += url + "&sortType="+this.sortType;

			axios.get(url)
			.then((res)=>{
				this.groups = res.data.data;
				this.perPage = res.data.perPage;
				this.numberOfPages = res.data.numberOfPages;
				this.currentPage = res.data.currentPage;
				this.lastPage = res.data.lastPage;
			})
		},
		showCreateGroupModal(){
			this.emptyErrors();
			$("#createGroupModal").modal();
		},
		hideCreateGroupModal(){
			this.emptyErrors();
			$("#createGroupModal").modal("hide");
		},
		storeGroup(){
			this.emptyErrors();
			axios.post("/api/storeGroup",this.groupToStore)
			.then((res)=>{
				this.getGroups();
				this.hideCreateGroupModal();
				this.showSuccessMessage("Group was created successfully");
				this.groupToStore = {};
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
		deleteGroup(group){
			if(!confirm("delete group ?")) return;
			axios.delete(`/api/deleteGroup/${group.id}`)
			.then((res)=>{
				this.getGroups();
				this.showSuccessMessage("Group was deleted successfully");
			})
		},
		showEditGroupModal(group){
			this.emptyErrors();
			this.groupToUpdate = group;
			$("#editGroupModal").modal();
		},
		hideEditGroupModal(){
			this.emptyErrors();
			$("#editGroupModal").modal("hide");
		},
		updateGroup(){
			this.emptyErrors();
			axios.put(`/api/groups/${this.groupToUpdate.id}`,this.groupToUpdate)
			.then((res)=>{
				this.getGroups();
				this.hideEditGroupModal();
				this.showSuccessMessage("Group ws updated successfully");
				this.groupToUpdate = {};
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		filterGroups()
		{
			this.page = 1;
			this.getGroups();
		},
		sort(string)
		{
			if(string=="groupName")
			{
				this.sortBy = "name";
			}

			this.sortType = this.sortType == "asc" ? "desc" : "asc";

			this.filterGroups();
		}
	},
	created(){
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