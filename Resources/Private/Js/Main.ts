import '../Scss/Styles.scss';

import Vue from "vue";
import EventCalendar from "./EventCalendar.vue";

Vue.config.productionTip = false;

const eventCalendar = new Vue({
    el: '#eventCalendar',
    components: {
        'event-calendar': EventCalendar
    }
});