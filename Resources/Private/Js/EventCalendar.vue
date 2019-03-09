<template>
	<div>
		<monthly-calendar></monthly-calendar>
	</div>
</template>

<script lang="ts">

import { Component, Vue, Prop } from "vue-property-decorator";
import Modernizr from "modernizr";

import MonthlyCalendar from './Components/MonthlyCalendar';
import { EventItem } from "./Interfaces";
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

    created() {
		this.isTouch = Modernizr.touchevents;
		this.events.forEach((event: EventItem) => {
			event.start = moment.unix(event.dateTimeStart);
			event.end = moment.unix(event.dateTimeEnd);
		});
		this.$store.commit('setEvents', this.events);
		console.log(this.$store.getters.events(moment().startOf('month'), moment().endOf('month')));
    }

}

</script>