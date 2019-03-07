<template>
	<div>
		<h1>Monthly calendar</h1>

		<div class="o-monthly-calendar">
			<div class="o-monthly-calendar__row o-monthly-calendar__row--head">
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Mo</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Di</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Mi</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Do</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Fr</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">Sa</span>
				</div>
				<div class="o-monthly-calendar__cell">
					<span class="o-monthly-calendar__cell__day">So</span>
				</div>
			</div>
			<div class="o-monthly-calendar__row o-monthly-calendar__row"
			     v-for="calendarWeek in this.calendarWeeks">
				<div class="o-monthly-calendar__cell"
				     v-for="calendarDay in calendarWeek.days">
					<span class="o-monthly-calendar__cell__day">{{calendarDay.date.format('DD')}}</span>
				</div>
			</div>

		</div>



	</div>
</template>

<script lang="ts">

import { Component, Vue } from "vue-property-decorator";
import * as _ from "lodash";
import {Moment} from 'moment';
import * as moment from 'moment';
import {CalendarDay, CalendarWeek} from "../Interfaces";

@Component
export default class MonthlyCalendar extends Vue {

	protected calendarDays: CalendarDay[] = [];
	protected calendarWeeks: CalendarWeek[] = [];

	mounted() {
		moment.locale('de');
		let currentYear: number = parseInt(moment().year(2019).format('YYYY'));
		let currentMonth: Moment = moment().month(2).year(currentYear);
		this.calendarDays = this.getDaysOfMonth(currentMonth);
		this.calendarWeeks = this.mapDaysToWeeks(this.calendarDays);
	}

	protected getDaysOfMonth(currentMonth: Moment): CalendarDay[] {
		let days: CalendarDay[] = [];
		let i: number = 1;
		while (i <= currentMonth.daysInMonth()) {
			let date: Moment = moment().date(i).month(parseInt(currentMonth.format('M') - 1)).year(currentMonth.year());
			let day: CalendarDay = {
				date:  date,
				display: date.format('dddd, DD.MM.YYYY'),
				week: date.week()
			}
			days.push(day);
			i++;
		}
		return days;
	}

	protected mapDaysToWeeks(calendarDays: CalendarDay[]): CalendarWeek[] {
		let weeks: CalendarWeek[] = [];
		if (calendarDays.length) {
			weeks = _.map(
				_.groupBy(calendarDays, 'week'),
				(days: CalendarDay[], number: number) => {
					return {
						number: parseInt(number),
						days: days
					}
				}
			);
		}
		return weeks;
	}

}

</script>