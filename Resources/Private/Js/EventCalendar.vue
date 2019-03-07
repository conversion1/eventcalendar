<script lang="ts">

import { Component, Vue } from "vue-property-decorator";
import Modernizr from "modernizr";

@Component
export default class EventCalendar extends Vue {

    public constructor() {
        super();
        console.log("CONSTRUCT");
        this.isTouch = Modernizr.touchevents;
    }

}

</script>