import '../Scss/Styles.scss';

import Vue from "vue";
import store from './Store';
import EventCalendar from "./EventCalendar.vue";

Vue.config.productionTip = false;

const eventCalendar = new Vue({
    el: '#eventCalendar',
    store,
    components: {
        'event-calendar': EventCalendar
    }
});