require('./bootstrap');

import VueRouter from 'vue-router';
import Example from './components/Example'
import Home from './components/Home'
import Service from './components/services/index'
import ServiceCreate from './components/services/create'
import ServiceEdit from './components/services/edit'
import Poll from './components/polls/index'
import adapter from 'webrtc-adapter';



Vue.use(VueRouter);


const routes = [{
	path: '/',
	name: 'index',
	component: Example
},{
	path: '/home',
	name: 'home',
	component: Home
},{
	path: '/service',
	name: 'service',
	component: Service
},{
	path: '/service/create',
	name: 'service.create',
	component: ServiceCreate
},{
	path: '/service/edit/:id',
	name: 'service.edit',
	component: ServiceEdit
},{
	path: '/poll',
	name: 'poll',
	component: Poll
}];

const router = new VueRouter({ 
	hashbang: false,
	history: false,
	linkActiveClass: "active",
	routes : routes 
});

const app = new Vue({
	router
}).$mount('#app')