var app = new Vue({
	el : "#app",
	data : {
		email : "",
		password : "",
		error:"",
		message:"",
	},
	methods : {
		login(){
			this.emptyErrors();
			axios.post("/api/auth",{email:this.email,password:this.password})
			.then((res)=>{
				location.href = "/offers";
			})
			.catch((err)=>{
				this.fillErrors(err);
			});
		},
		emptyErrors(){
			this.error = {};
			this.message = "";
		},
		fillErrors(err){
			if(err.response.data.errors) this.error = err.response.data.errors;
			if(err.response.data.message) this.message = err.response.data.message;
		},
	},
});