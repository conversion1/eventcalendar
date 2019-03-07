import '../Scss/Styles.scss';

import Vue from "vue";
import EventCalendar from "./EventCalendar.vue";

Vue.config.productionTip = false;

const eventCalendar = new EventCalendar({
    el: '#eventCalendar'
});