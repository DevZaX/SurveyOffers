var app = new Vue({
	el : "#app",
	data : {
		users:[],
		userToStore:{id:null,name:"",email:"",password:""},
		error:{},
		message:"",
		editPassword:false,
		userToUpdate:{id:null,name:"",email:""},
		successMessage:"",
		loading:true,
		page:1,
		filter:"",
		groups:[],
		perPage:"",
		numberOfPages:0,
		currentPage:"",
		lastPage:0,
	},
	methods:{
		getUsers(){
			axios.get("/api/users?page="+this.page+"&filter="+this.filter).then((res)=>
				{
					console.log(res);
					this.users=res.data.data;
					this.perPage = res.data.perPage;
					this.numberOfPages = res.data.numberOfPages;
					this.currentPage = res.data.currentPage;
					this.lastPage = res.data.lastPage;
				});
		},
		storeUser(){
			this.emptyErrors();
			axios.post("/api/users",this.userToStore)
			.then((res)=>{this.getUsers();this.hideCreateUserModal();this.showSuccessMessage("User was created successfully");this.userToStore={id:null,name:"",email:"",password:""}})
			.catch((err)=>{this.fillErrors(err);});
		},
		showCreateUserModal(){
			$("#createUserModal").modal();
		},
		hideCreateUserModal(){
			this.emptyErrors();
			$("#createUserModal").modal("hide");
		},
		fillErrors(err){
			if(err.response.data.errors) this.error = err.response.data.errors;
			if(err.response.data.message) this.message = err.response.data.message;
		},
		emptyErrors(){
			this.error = {};
			this.message = "";
		},
		showEditUserModal(user){
			this.userToUpdate.id=user.id;
			this.userToUpdate.name = user.name;
			this.userToUpdate.email = user.email;
			this.userToUpdate.group_id = user.group_id;
			$("#editUserModal").modal();
		},
		hideEditUserModal(){
			this.emptyErrors();
			$("#editUserModal").modal("hide");
		},
		updateUser(){
			this.emptyErrors();
			axios.put(`/api/users/${this.userToUpdate.id}`,this.userToUpdate)
			.then((res)=>{this.getUsers();this.hideEditUserModal();this.showSuccessMessage("User was updated successfully");this.userToUpdate={id:null,name:"",email:""}})
			.catch((err)=>{this.fillErrors(err);});
		},
		toggleEditPassword(){
			if(!this.editPassword){
				this.editPassword = true;
				this.userToUpdate.password = "";
			}
			else{
				delete this.userToUpdate.password;
				this.editPassword=false;
			}
		},
		showSuccessMessage(message){
			this.successMessage = message;
			setTimeout(()=>{this.successMessage="";},1500);
		},
		deleteUser(user){
			if(!confirm("Delete user ?")) return;
			axios.delete(`/api/users/${user.id}`)
			.then((res)=>{this.getUsers();this.showSuccessMessage("User was deleted successfully")})
			.catch((err)=>{this.fillErrors(err)});
		},
		getGroups(){
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
		this.getUsers();
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