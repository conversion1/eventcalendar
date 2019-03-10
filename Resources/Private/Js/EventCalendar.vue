<template>
	<div>
		<monthly-calendar :current-month="activeMonth"
		                  :dates="dates"></monthly-calendar>
	</div>
</template>

<script lang="ts">

import { Component, Vue, Prop } from "vue-property-decorator";
import Modernizr from "modernizr";

import MonthlyCalendar from './Components/MonthlyCalendar';
import {CalendarDay, CalenderDate, EventItem} from "./Interfaces";
import {Moment} from 'moment';
import * as moment from 'moment';

@Component({
	components: {
		'monthly-calendar': MonthlyCalendar
	}
})
export default class EventCalendar extends Vue {

	protected isTouch:boolean = false;
	@Prop(String) readonly apiUrl!: string;
	@Prop(Array) events: EventItem[];
	protected activeMonth: Moment;
	protected monthEvents: EventItem[] = [];
	protected dates: CalenderDate[] = [];

    created() {
		moment.locale('de');
		this.isTouch = Modernizr.touchevents;
		this.activeMonth = moment();
		this.events.forEach((event: EventItem) => {
			event.start = moment.unix(event.dateTimeStart);
			event.end = moment.unix(event.dateTimeEnd);
		});
		this.$store.commit('setEvents', this.events);
		this.monthEvents = this.$store.getters.events(this.activeMonth);

		this.dates = [];
		this.monthEvents.forEach((event: EventItem) => {
			this.dates.push({
				start: event.start,
				end: event.end
			});
		});


    }

}

</script>