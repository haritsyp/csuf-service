<template>
	<div>
		<va-header title="Poll"></va-header>
		<div class="content">
			<div class="container">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-12">
								<form @submit.prevent="getData">
									<div class="form-row">
										<div class="form-group col-md-4">
											<label for="inputCity">Start Date</label>
											<input type="date" v-model="state.start_date"  class="form-control">
										</div>
										<div class="form-group col-md-4">
											<label for="inputState">End Date</label>
											<input type="date" v-model="state.end_date"  class="form-control">
										</div>
										<div class="form-group col-md-4">
											<label for="inputZip">Service</label>
											<select v-model="state.service_id"  class="form-control">
												<option></option>
												<option v-bind:value="service.service_id" v-for="(service, index) in services">{{ service.service_name }}</option>
											</select>
											
										</div>
									</div>
									<div class="form-group col-md-4">
										<button type="submit" class="btn btn-sm btn-danger">
											<i class="fa fa-sm fa-search"></i> 
											Filter
										</button> 
										<a v-bind:href="url" class="btn btn-sm btn-success">
											<i class="fa fa-sm fa-file"></i> 
											Export
										</a>
									</div>
									
								</form>
							</div>
						</div>
						
					</div>
					<div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>No.</th>
									<th>Date</th>
									<th>Service ID</th>
									<th>Poll</th>
									<th>Result</th>
									<th>Image</th>
									<th>Actions</th>
								</tr>
							</thead>

							<tbody>
								<tr v-for="(poll, index) in polls.data">
									<td>{{ index+1 }}</td>
									<td>{{ poll.poll_date }} </td>
									<td>{{ poll.service_id }} </td>
									<td>{{ poll.value }} </td>
									<td>{{ poll.result }} </td>
									<td><img :src="'./uploads/' + poll.poll_image" width="100px"></td>
									<td width="100px">
										<button class="btn btn-xs btn-danger" v-on:click="deletePoll(poll.poll_id)">Delete</button>
									</td>
								</tr>
							</tbody>
						</table>
						<ul class="pagination">
							<li v-if="polls.prev_page_url">
								<a @click.prevent="paginate(polls.prev_page_url)" :href="polls.prev_page_url">&laquo; Previous</a>
							</li>
							<li v-if="polls.next_page_url">
								<a @click.prevent="paginate(polls.next_page_url)" :href="polls.next_page_url">Next &raquo;</a>
							</li>
						</ul>
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
			polls: [],
			url : 'excel',
			services :[],
			state : {
				service_id : '',
				start_date : '',
				end_date : ''
			},
		}
	},
	mounted() {
		axios.get('./service').then(response => {
			this.services = response.data;
		});
		this.getData();

	},
	methods: {
		getData(){
			this.url = 'excel?start_date='+this.state.start_date+'&end_date='+this.state.end_date+'&service_id='+this.state.service_id;
			axios.get('./api/polls',{
				params : this.state
			}).then(response => {
				this.polls = response.data;
				console.log(response.data)
			});
		},
		paginate(url) {
			axios.get(url).then(response => {
				this.polls = response.data;
			})
		},
		deletePoll(id){
			this.$swal({
				title: "Are you sure?",
				text: "Once deleted, you will not be able to recover this data!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					axios.delete('./poll/',{
						params:{
							poll_id : id
						}
					}).then(response => {
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