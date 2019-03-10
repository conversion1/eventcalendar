import {Moment} from "moment";

export interface CalendarDay {
	date: Moment;
	display: string;
	week?: number;
	isNotThisMonth?: boolean;
	hasEvents?: boolean;
	days?: number;
}

export interface CalendarWeek {
	number: number;
	days?: CalendarDay[];
}

export interface EventItem {
	uid: number;
	pid: number;
	title: string;
	dateTimeStart: number;
	dateTimeEnd: number;
	start: Moment;
	end: Moment;
}

export interface DateMark {
	start: Moment;
	days?: number;
}

export interface CalenderDate {
	start: Moment;
	end: Moment;
}