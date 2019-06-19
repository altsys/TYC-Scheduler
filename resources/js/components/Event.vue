<template>

    <div class="list-group-item list-group-item-action">
        <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{name}}</h5>
            <small>
                <span>
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-cog fa-fw"> </i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                <a class="dropdown-item" href="#">Book</a>
                                <a class="dropdown-item" href="#">Edit</a>
                                <a class="dropdown-item" href="#">Reserve</a>
                                <a class="dropdown-item" @click="deleteEvent">Delete</a>
                            </div>
                        </div>
                    </div>
                </span>
            </small>
        </div>
        <p class="mb-1">{{description}}</p>
        <small><i class="fas fa-calendar-alt fa-fw"> </i> {{this.frequencyName}}</small><br>
        <span class="badge badge-secondary badge-pill">
            <span> <i class="fas fa-user-friends fa-fw"> </i> </span>
            {{type}}
        </span>
        <span :class="">
            <span> <i class="fa-flag"> </i> </span>
            {{ this.priorityName }}
        </span>
    </div>
</template>

<script>
    export default {
        props: ['event'],
        data() {
            return {
                name: this.event.name,
                description: this.event.description,
                type: this.event.type,
                priority: this.event.priority,
                frequency: this.event.frequency,
                priorities: ['Low', 'Normal', 'High'],
                frequencies: ['one time', 'yearly', 'qourterly', 'monthly', 'weekly', 'daily']
            }
        },
        computed: {
            frequencyName() {
                return this.frequencies[this.frequency];
            },
            priorityName() {
                return this.priorities[this.priority + 1];
            },
            priorityClass() {
                priorityClasses = 'badge badge-default badge-pill';
                if (this.priority == 1) {
                    priorityClasses = 'badge badge-success badge-pill';
                } else if (this.priority == 2) {
                    priorityClasses = 'badge badge-danger badge-pill';
                }
                return priorityClasses;
            }
        },
        methods: {
            deleteEvent() {
                console.log('Will delete event');
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }

</script>
