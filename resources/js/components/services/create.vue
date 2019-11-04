<template>
	<div>
		<va-header title="Add Service"></va-header>
		<div class="content">
			<div class="container">
				<div class="card">
					<div class="card-body">
						<form  @submit.prevent="store" action="./service" class="form-horizontal"> 
							<div class="form-group">
								<label for="name" class="col-md-2 control-label">Service ID</label>
								<div class="col-md-4">
									<input class="form-control" required autocomplete="off" placeholder="ID" type="text" v-model="state.service_id" name="name"  autofocus="">
								</div>
							</div> 
							<div class="form-group">
								<label for="name" class="col-md-2 control-label">Name</label>
								<div class="col-md-4">
									<input class="form-control" required autocomplete="off" placeholder="Name" type="text" v-model="state.service_name" name="name"  autofocus="">
								</div>
							</div> 
							<div class="form-group">
								<div class="col-md-4 col-md-offset-2">
									<button class="btn btn-primary" id="btnSimpanService" type="submit">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
</template>

<script type="text/javascript">

import Header from './../Header'

export default {
	name: 'Header',
	components: {
		'va-header': Header
	},
	data() {
		return {
			errors : [],
			services : [],
			state: {
				service_id : '',
				service_name : ''
			}
		}
	},
	mounted() {
	},
	methods: {
		store(e){
			axios.post(e.target.action, this.state).then(response => {
				this.errors = [];
				this.state = {
					service_id: '',
					service_name: ''
				}
				this.message = 'Service has been created.';
			}).catch(error => {
				if (! _.isEmpty(error.response)) {
					if (error.response.status = 422) {
						this.errors = error.response.data;
					}
				}
			});
			this.$router.push({
				name: 'service'
			})
		}

		
	}
}
</script>