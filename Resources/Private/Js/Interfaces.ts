import {Moment} from "moment";

export interface CalendarDay {
	date: Moment;
	display: string;
	week?: number;
	isNotThisMonth?: boolean;
}

export interface CalendarWeek {
	number: number;
	days?: CalendarDay[];
}