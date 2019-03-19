<template>
	<div class="o-monthly-calendar">
		<h1>{{this.month.format('MMMM YYYY')}}</h1>
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
					<span class="o-monthly-calendar__cell__day"
					      v-bind:class="{
					        'o-monthly-calendar__cell__day--soft': calendarDay.isNotThisMonth,
					        'o-monthly-calendar__cell__day--mark': calendarDay.hasEvents
					      }">
						{{calendarDay.date.format('DD')}}
						<span v-if="calendarDay.hasEvents"
						      class="o-monthly-calendar__cell__day__event-icon"></span>
					</span>
			</div>
		</div>
	</div>
</template>

<script lang="ts">

import { Component, Vue, Prop } from "vue-property-decorator";
import * as _ from "lodash";
import {Moment} from 'moment';
import * as moment from 'moment';
import {CalendarDay, CalendarWeek, CalenderDate, DateMark} from "../Interfaces";

@Component
export default class MonthlyCalendar extends Vue {

	@Prop(Object) readonly currentMonth?: Moment;
	@Prop(Array) readonly dates: CalenderDate[];

	protected year: number;
	protected month: Moment;
	protected calendarDays: CalendarDay[] = [];
	protected calendarWeeks: CalendarWeek[] = [];
	protected monthBefore: Moment;
	protected monthAfter: Moment;
	protected offsetDaysBefore: CalendarDay[] = [];
	protected offsetDaysAfter: CalendarDay[] = [];
	protected dateMarks: DateMark[] = [];

	created() {
		// moment.locale('de');
		let monthNumber: number = moment().month();
		if (!this.currentMonth) {
			this.month = moment();
		} else {
			this.month = this.currentMonth;
		}
		this.year = this.month.year();
		this.calendarDays = this.getDaysOfMonth(this.month);
		this.monthBefore = moment().month(monthNumber).year(this.year).subtract(1, 'month');
		this.monthAfter = moment().month(monthNumber).year(this.year).add(1, 'month');
		this.offsetDaysBefore = this.getOffsetDaysBefore(this.month, this.monthBefore);
		this.offsetDaysAfter = this.getOffsetDaysAfter(this.month, this.monthAfter);
		this.calendarDays = this.offsetDaysBefore.concat(this.calendarDays);
		this.calendarDays = this.calendarDays.concat(this.offsetDaysAfter);
		this.calendarWeeks = this.mapDaysToWeeks(this.calendarDays);
		this.dateMarks = this.datesToDateMarks(this.dates);
		this.calendarDays = this.markDaysInCalendar(this.dateMarks);
	}

	protected markDaysInCalendar(dateMarks: DateMark[]) {
		this.calendarDays.forEach((calendarDay: CalendarDay) => {
			dateMarks.forEach((dateMark: DateMark) => {
				if (calendarDay.date.isSame(dateMark.start, 'day')) {
					calendarDay.hasEvents = true;
					if (dateMark.days) {
						calendarDay.days = dateMark.days;
					}
				}
			});
		});
		return this.calendarDays;
	}

	protected datesToDateMarks(dates: CalenderDate[]) {
		let dateMarks: DateMark[] = [];
		dates.forEach((date: CalenderDate) => {
			if (date.start.day() !== date.end.day()) {
				dateMarks.push({
					start: date.start,
					days: date.end.startOf('day').diff(date.start.startOf('day'), 'days')
				})
			} else {
				dateMarks.push({
					start: date.start
				})
			}
		});
		console.log(dateMarks);
		return dateMarks;
	}

	protected getDaysOfMonth(month: Moment): CalendarDay[] {
		let days: CalendarDay[] = [];
		let i: number = 1;
		while (i <= month.daysInMonth()) {
			let date: Moment = moment().date(i).month(parseInt(month.format('M') - 1)).year(month.year());
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

	protected getOffsetDaysBefore(month: Moment, monthBefore: Moment) {
		let days: CalendarDay[] = [];
		let offset: number = month.startOf('month').day() - 1;
		let totalDays: number = monthBefore.daysInMonth();
		let dayStart: number = totalDays - offset + 1;
		while (dayStart <= totalDays) {
			let date: Moment = moment().date(dayStart).month(parseInt(monthBefore.format('M') - 1)).year(monthBefore.year());
			let day: CalendarDay = this.createCalendarDay(date);
			day.isNotThisMonth = true;
			day.week = month.startOf('month').week();
			days.push(day);
			dayStart++;
		}
		return days;
	}

	protected getOffsetDaysAfter(month: Moment, monthAfter: Moment) {
		let days: CalendarDay[] = [];
		let offset: number = month.endOf('month').day() - 1;
		let dayStart: number = 1;
		while (dayStart <= offset) {
			let date: Moment = moment().date(dayStart).month(parseInt(monthAfter.format('M') - 1)).year(monthAfter.year());
			let day: CalendarDay = this.createCalendarDay(date);
			day.week = month.endOf('month').week();
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