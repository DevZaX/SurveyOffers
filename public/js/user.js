var vueUser = new Vue({
	el : "#user",
	data : {
		email:"",
		password:"",
		password_confirmation:"",
		old_password:"",
		name:"",
	},
	methods:{
		getUser(){
			axios.get("api/users/"+$("#userId").val())
			.then((res)=>{
				console.log(res);
			})
		},
		showEditUserFromNavModal(){
			console.log("work");
			$("#editUserFromNavModal").modal();
		}
	},
	created(){
		this.getUser();
	}
})