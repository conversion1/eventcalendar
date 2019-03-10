import Vue from 'vue';
import Vuex from 'vuex';
import * as moment from 'moment';
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
		events: (state) => (month?: Moment) =>{
			if (month && month.isValid()) {
				let start: Moment = month.clone().startOf('month');
				let end: Moment = month.clone().endOf('month');
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
