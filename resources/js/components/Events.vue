<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            {{title}}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <eventform></eventform>
                            </div>
                            <event v-for="event in events" :event="event" :key="event.id"></event>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import event from './event.vue';
    import eventform from './EventForm.vue'
    export default {
        data() {
            return {
                events: {},
                form: new Form({})
            }
        },
        methods: {
            loadAllEvents() {
                this.form.get('api/event').then(
                    ({
                        data
                    }) => {
                        this.events = data.data
                    }
                )
                console.log("loading all events");
            }
        },
        computed: {
            title() {
                return 'All Events'
            }
        },
        components: {
            event,
            eventform
        },
        mounted() {
            this.loadAllEvents()
            Fire.$on('someChange', () => {
                this.loadAllEvents()
            })
        },
    }

</script>
