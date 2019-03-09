import Vue from 'vue';
import Vuex from 'vuex';
import {Moment} from "moment";
import {EventItem} from "@/Interfaces";
Vue.use(Vuex);
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
		events: (state) => (start?: Moment, end?: Moment) =>{
			if (start && start.isValid() && end && end.isValid()) {
				return state.events.filter( (event: EventItem) => {
					if (event.start.isSameOrAfter(start) && event.end.isSameOrBefore(end)) {
						return event;
					}
				})
			} else {
				return state.events;
			}
		}
	}
});
