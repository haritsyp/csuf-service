<template>
	<div>
		<va-header title="Service"></va-header>
		<div class="content">
			<div class="container">
				<div class="card">
					<div class="card-header">
						<router-link :to="{ path: 'service/create' }" class="btn btn-sm btn-primary">
							<i class="fa fa-sm fa-plus"></i> 
							Add
						</router-link>
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>No.</th>
									<th>Service ID</th>
									<th>Name</th>
									<th>Created</th>
									<th>Actions</th>
								</tr>
							</thead>

							<tbody>
								<tr v-for="(service, index) in services">
									<td>{{ index+1 }}</td>
									<td>{{ service.service_id }} </td>
									<td>{{ service.service_name }} </td>
									<td>{{ service.created_at }} </td>
									<td width="100px">
										<router-link :to="{ name: 'service.edit', params : {id : service.service_id} }" class="btn btn-xs btn-success">
											Edit
										</router-link>
										<button class="btn btn-xs btn-danger" v-on:click="deleteService(service.service_id)">Delete</button>
									</td>
								</tr>
							</tbody>
						</table>
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
			services: []
		}
	},
	mounted() {
		this.getData();
	},
	methods: {
		getData(){
			axios.get('./service').then(response => {
				this.services = response.data;
			});
		},
		deleteService(id){
			this.$swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this data!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					axios.delete('./service/'+id).then(response => {
						this.getData();
						swal("Your data has been deleted!", {
							icon: "success",
						});
					});				
				}
			});
		}

	}
}
</script>