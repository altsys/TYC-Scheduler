<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Venues</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addNewUser">
                                Add New <i class="fas fa-plus fa-fw"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="list-group">
                            <div class="list-group-item list-group-item-action">
                                <form @submit.prevent="createVenue">
                                    <div class="first-visible form-row" v-on:keydown="isHidden = false">
                                        <div class="form-group col-md-6">
                                            <input v-model="form.name" type="text" name="name"
                                                placeholder="Venue name or id here..." class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <input v-model="form.capacity" type="number" name="capacity"
                                                placeholder="Venue capacity..." class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('capacity') }">
                                            <has-error :form="form" field="capacity"></has-error>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <select v-model="form.status" name="status" id="status" class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('status') }">
                                                <option value="" selected>Status..</option>
                                                <option value="0">Available</option>
                                                <option value="1">Reserved</option>
                                                <option value="2">Unavailable</option>
                                            </select>
                                            <has-error :form="form" field="status"></has-error>
                                        </div>
                                    </div>
                                    <div class="second-hidden" v-if="!isHidden">
                                        <div class="form-group">
                                            <textarea v-model="form.description" name="description" id="description"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('description') }"
                                                placeholder="Short description for the venue (Optional)"></textarea>
                                            <has-error :form="form" field="description"></has-error>
                                        </div>
                                        <div class="form-group">
                                            <textarea v-model="form.location" name="location" id="location"
                                                class="form-control"
                                                :class="{ 'is-invalid': form.errors.has('location') }"
                                                placeholder="Describe location of the venue (Optional)"></textarea>
                                            <has-error :form="form" field="location"></has-error>
                                        </div>
                                        <div class="buttons">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="button" class="btn btn-secondary">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div v-for="(venue, index) in venues" :key="venue.id"
                                class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{venue.name}}</h5>
                                    <small>

                                        <span>
                                            <div class="btn-group" role="group"
                                                aria-label="Button group with nested dropdown">
                                                <div class="btn-group" role="group">
                                                    <button id="btnGroupDrop1" type="button"
                                                        class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-cog fa-fw"> </i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                        <a class="dropdown-item" href="#">Book</a>
                                                        <a class="dropdown-item" href="#">Edit</a>
                                                        <a class="dropdown-item" href="#">Reserve</a>
                                                        <a class="dropdown-item"
                                                            @click="deleteVenue(venue.id)">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </span>
                                    </small>
                                </div>
                                <p class="mb-1">{{venue.description}}</p>
                                <small><i class="fas fa-map-marker-alt fa-fw"> </i> {{venue.location}}</small><br>
                                <span class="badge badge-secondary badge-pill">
                                    <span> <i class="fas fa-user-friends fa-fw"> </i> </span>
                                    {{venue.capacity}}
                                </span>
                                <span :class="statusBadgeClasses(venue)">
                                    <span> <i :class="statusFaClass(venue)"> </i> </span>
                                    {{ status(venue) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                venues: {},
                form: new Form({
                    name: '',
                    description: '',
                }),
                isHidden: true
            }
        },

        methods: {
            status(v) {
                return v.status == 0 ? 'Available' : 'Booked';
            },
            statusFaClass(v) {
                return v.status == 0 ? 'fas fa-check' : 'fas fa-times';
            },
            statusBadgeClasses(v) {
                return v.status == 0 ? 'badge badge-success badge-pill' : 'badge badge-danger badge-pill';
            },
            popModal(changemod, v){
                // display modal to either edit or delete with venue data
            },
            createVenue() {
                this.$Progress.start()
                this.form.post('api/venue').then(() => {
                    this.$Progress.finish()
                    toast.fire({
                        type: 'success',
                        title: 'Venue created successfully'
                    })
                    Fire.$emit('afterChange')
                }).catch(() => {
                    this.$Progress.fail()
                    toast.fire({
                        type: 'error',
                        title: 'Venue not created successfully'
                    })
                })
            },
            loadAllVenues() {
                this.form.get('api/venue').then(
                    ({
                        data
                    }) => {
                        this.venues = data.data
                    }
                )
            },
            deleteVenue(venue) {
                Swal.fire({
                    title: 'Delete?',
                    text: "Are you sure? You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete(`api/venue/` + venue).then(() => {
                            toast.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            Fire.$emit('afterChange')
                        })
                    }
                })
            }
        },
        mounted() {
            this.loadAllVenues()
            Fire.$on('afterChange', () => {
                this.loadAllVenues()
            })
        }
    }

</script>
