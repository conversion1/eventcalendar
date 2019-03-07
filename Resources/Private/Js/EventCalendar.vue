<template>
	<div>
		<monthly-calendar></monthly-calendar>
	</div>
</template>

<script lang="ts">

import { Component, Vue, Prop } from "vue-property-decorator";
import Modernizr from "modernizr";

import MonthlyCalendar from './Components/MonthlyCalendar';

@Component({
	components: {
		'monthly-calendar': MonthlyCalendar
	}
})
export default class EventCalendar extends Vue {

	protected isTouch:boolean = false;
	@Prop(String) readonly apiUrl!: string;

    created() {
		this.isTouch = Modernizr.touchevents;
    }

}

</script>