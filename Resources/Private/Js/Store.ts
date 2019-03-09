import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);
// https://egghead.io/lessons
export default new Vuex.Store({
	state: {
		events: []
	},
	mutations: {
		setEvents (state: any, payload: any): void {
			state.events = payload;
		},
		addEvents(state, payload): void {
			state.events.push(payload);
		}
	},
	actions: {
	},
	getters: {
		events(state: any): Event[] {
			console.log(typeof state);
			return state.events;
		}
	}
});
