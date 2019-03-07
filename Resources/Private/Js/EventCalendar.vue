<template>
	<div>
		<monthly-calendar></monthly-calendar>
	</div>
</template>

<script lang="ts">

import { Component, Vue } from "vue-property-decorator";
import Modernizr from "modernizr";

import MonthlyCalendar from './Components/MonthlyCalendar';

@Component({
	components: {
		'monthly-calendar': MonthlyCalendar
	}
})
export default class EventCalendar extends Vue {

    public constructor() {
        super();
        this.isTouch = Modernizr.touchevents;
    }

}

</script>