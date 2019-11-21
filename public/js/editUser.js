var app = new Vue({
	el : "#app",
	data : {
		user : {},
		error : "",
		message : "",
		loading:true,
		successMessage:"",
		editPassword:false,
	},
	methods:{
		getUser(){
			axios.get("api/auth")
			.then((res)=>{
				this.user = res.data.data;
				this.loading=false;
			})
		},
		updateUser(){
			this.emptyErrors();
			axios.put("api/users/"+this.user.id,this.user)
			.then((res)=>{
				this.showSuccessMessage("Your profile was updated successfully");
				this.getUser();
			})
			.catch((err)=>{
				this.fillErrors(err);
			})
		},
		emptyErrors(){
			this.error = {};
			this.message = "";
		},
		fillErrors(err){
			if(err.response.data.errors) this.error = err.response.data.errors;
			if(err.response.data.message) this.message = err.response.data.message;
		},
		showSuccessMessage(message){
			this.successMessage = message;
			setTimeout(()=>{this.successMessage="";},1500);
		},
		toggleEditPassword(){
			if(!this.editPassword){
				this.editPassword = true;
				this.user.password = "";
				this.user.current_password = "";
				this.user.confirmation_password = "";
			}
			else{
				delete this.user.password;
				delete this.user.current_password;
				delete this.user.confirmation_password;
				this.editPassword=false;
			}
		}
	},
	created(){
		this.getUser();
	}
})