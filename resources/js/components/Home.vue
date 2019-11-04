<template>
	<div>
		<va-header title="Dashboard"></va-header>
		<div class="content">
			<div class="container">
				<div class="card">
					<div class="card-header">
						<h4>Result</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<form @submit.prevent="filter">
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
										<a v-bind:href="url" class="btn btn-sm btn-warning">
											<i class="fa fa-sm fa-file"></i> 
											Export
										</a>
									</div>
								</form>
							</div>
						</div>
						<br>
						<line-chart :chart-data="datacollection"  class="small"></line-chart>
						<br><br>
						<center>
							<h4>List Polling</h4>
						</center>
						<table class="table">
							<thead>
								<tr>
									<th>No.</th>
									<th>Date</th>
									<th>Sangat Puas</th>
									<th>Puas</th>
									<th>Cukup</th>
									<th>Kecewa</th>
								</tr>
							</thead>

							<tbody>
								<tr v-for="(poll, index) in polls">
									<td>{{ index+1 }}</td>
									<td>{{ poll.mydate }} </td>
									<td>{{ poll.sangatpuas }} </td>
									<td>{{ poll.puas }} </td>
									<td>{{ poll.cukup }} </td>
									<td>{{ poll.kecewa }} </td>
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
import Header from './Header'
import LineChart from './LineChart.js'


export default {
	name: 'Header',
	components: {
		'va-header': Header,
		LineChart
	},
	data () {
		return {
			url : 'excelresult',
			state : {
				service_id : '',
				start_date : '',
				end_date : ''
			},
			services : [],
			polls : [],
			date : [],
			datacollection: null,
		}
	},
	mounted () {
		this.fillData()
		this.getData()
	},
	methods: {
		fillData () {
			let app = this;
			axios.get('./api/resulttable',{
				params : {
					service_id : ''
				}
			}).then(response => {
				this.polls = response.data;
			});
			axios.get('./api/resultpoll')
			.then(function (response) {
				app.data = response.data;
				app.datacollection = {
					labels: ['Sangat Puas', 'Puas', 'Cukup', 'Kecewa'],
					datasets: [
					{
						backgroundColor: ['#f87979','#4287f5','#26bf45','#c7f207'],
						data: app.data
					}]
				}
			})
			//console.log(this.state)
			
			
		},
		filter(){
			if(this.state.start_date == null || this.state.start_date == ''){
				this.url = 'excelresult?start_date='+this.state.start_date+'&end_date='+this.state.end_date+'&service_id='+this.state.service_id;
				let app = this;
				axios.get('./api/resulttable',{
					params : {
						service_id : this.state.service_id
					}
				}).then(response => {
					this.polls = response.data;
				});
				axios.get('./api/resultpoll',{
					params : {
						service_id : this.state.service_id
					}
				})
				.then(function (response) {
					app.data = response.data;
					app.datacollection = {
						labels: ['Sangat Puas', 'Puas', 'Cukup', 'Kecewa'],
						datasets: [
						{
							backgroundColor: ['#f87979','#4287f5','#26bf45','#c7f207'],
							data: app.data
						}]
					}
				})
			}else{
				let app = this;
				this.url = 'excelresult?start_date='+this.state.start_date+'&end_date='+this.state.end_date+'&service_id='+this.state.service_id;
				axios.get('./api/resulttablefilter',{
					params : this.state
				}).then(response => {
					app.polls = response.data;
				});
				axios.get('./api/resultpollfilter',{
					params : this.state
				})
				.then(function (response) {
					app.data = response.data;
					app.datacollection = {
						labels: ['Sangat Puas', 'Puas', 'Cukup', 'Kecewa'],
						datasets: [
						{
							backgroundColor: ['#f87979','#4287f5','#26bf45','#c7f207'],
							data: app.data
						}]
					}
				})
			}
			
		},
		getData(){
			axios.get('./service').then(response => {
				this.services = response.data;
			});
		}
	}
}
</script>

<style>
.small {
	max-width: 300px;
	margin : 0px auto;
	padding-top:10px;
}
</style>