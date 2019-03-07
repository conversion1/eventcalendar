<template>
	<div>
		<h1>{{this.currentMonth.format('MMMM YYYY')}}</h1>

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

	protected currentMonth: Moment;
	protected currentYear: number;
	protected calendarDays: CalendarDay[] = [];
	protected calendarWeeks: CalendarWeek[] = [];
	protected monthBefore: Moment;
	protected monthAfter: Moment;
	protected offsetDaysBefore: CalendarDay[] = [];
	protected offsetDaysAfter: CalendarDay[] = [];

	public constructor() {
		super();
		let monthNumber: number = 0;
		moment.locale('de');
		this.currentYear = parseInt(moment().year(2019).format('YYYY'));
		this.currentMonth = moment().month(monthNumber).year(this.currentYear);
		this.calendarDays = this.getDaysOfMonth(this.currentMonth);
		this.monthBefore = moment().month(monthNumber).year(this.currentYear).subtract(1, 'month');
		this.monthAfter = moment().month(monthNumber).year(this.currentYear).add(1, 'month');
		this.offsetDaysBefore = this.getOffsetDaysBefore(this.currentMonth, this.monthBefore);
		this.offsetDaysAfter = this.getOffsetDaysAfter(this.currentMonth, this.monthAfter);
		this.calendarDays = this.offsetDaysBefore.concat(this.calendarDays);
		this.calendarDays = this.calendarDays.concat(this.offsetDaysAfter);
		this.calendarWeeks = this.mapDaysToWeeks(this.calendarDays);
	}

	protected getDaysOfMonth(currentMonth: Moment): CalendarDay[] {
		let days: CalendarDay[] = [];
		let i: number = 1;
		while (i <= currentMonth.daysInMonth()) {
			let date: Moment = moment().date(i).month(parseInt(currentMonth.format('M') - 1)).year(currentMonth.year());
			let day: CalendarDay = this.createCalendarDay(date);
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

	protected getOffsetDaysBefore(currentMonth: Moment, monthBefore: Moment) {
		let days: CalendarDay[] = [];
		let offset: number = currentMonth.startOf('month').day() - 1;
		let totalDays: number = monthBefore.daysInMonth();
		let dayStart: number = totalDays - offset + 1;
		while (dayStart <= totalDays) {
			let date: Moment = moment().date(dayStart).month(parseInt(monthBefore.format('M') - 1)).year(monthBefore.year());
			let day: CalendarDay = this.createCalendarDay(date);
			day.isNotThisMonth = true;
			day.week = currentMonth.startOf('month').week();
			days.push(day);
			dayStart++;
		}
		return days;
	}

	protected getOffsetDaysAfter(currentMonth: Moment, monthAfter: Moment) {
		let days: CalendarDay[] = [];
		let offset: number = currentMonth.endOf('month').day() - 1;
		let dayStart: number = 1;
		while (dayStart <= offset) {
			let date: Moment = moment().date(dayStart).month(parseInt(monthAfter.format('M') - 1)).year(monthAfter.year());
			let day: CalendarDay = this.createCalendarDay(date);
			day.week = currentMonth.endOf('month').week();
			day.isNotThisMonth = true;
			days.push(day);
			dayStart++;
		}
		return days;
	}

	protected createCalendarDay(date: Moment): CalendarDay {
		return {
			date:  date,
			display: date.format('dddd, DD.MM.YYYY'),
			week: date.week()
		}
	}

}

</script>