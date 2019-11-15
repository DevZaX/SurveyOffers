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
	},
	methods:{
		getUsers(){
			axios.get("/api/users").then((res)=>{console.log(res);this.users=res.data});
		},
		storeUser(){
			this.emptyErrors();
			axios.post("/api/users",this.userToStore)
			.then((res)=>{this.getUsers();this.hideCreateUserModal();this.showSuccessMessage("User was created successfully")})
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
			if(err.response){
				this.error= err.response.data.errors;
				this.message = err.response.data.message;
			}
		},
		emptyErrors(){
			this.error = {};
			this.message = "";
		},
		showEditUserModal(user){
			this.userToUpdate.id=user.id;
			this.userToUpdate.name = user.name;
			this.userToUpdate.email = user.email;
			$("#editUserModal").modal();
		},
		hideEditUserModal(){
			this.emptyErrors();
			$("#editUserModal").modal("hide");
		},
		updateUser(){
			this.emptyErrors();
			axios.put(`/api/users/${this.userToUpdate.id}`,this.userToUpdate)
			.then((res)=>{this.getUsers();this.hideEditUserModal();this.showSuccessMessage("User was updated successfully")})
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
		}
	},
	created(){
		this.getUsers();
		this.loading=false;
	}
})