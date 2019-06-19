<template>
    <form @submit.prevent="createEvent">
        <div class="input-group" @keydown="isHidden = false">
            <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Event name here..." 
                :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
            <div class="input-group-append">
                <select v-model="form.priority" name="priority" id="priority" class="form-control input-group-text"
                    :class="{ 'is-invalid': form.errors.has('priority') }">
                    <option value="" selected>Priority..</option>
                    <option v-for="(prty, index) in priorities" :key="prty" :value="index+1">{{prty}}</option>
                </select>
                <select v-model="form.type" name="type" id="type" class="form-control input-group-text"
                    :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="" selected>Type..</option>
                    <option v-for="(typ, index) in types" :key="typ" :value="typ">{{typ}}</option>
                </select>
                <select v-model="form.frequency" name="frequency" id="frequency" class="form-control input-group-text"
                    :class="{ 'is-invalid': form.errors.has('frequency') }">
                    <option value="" selected>How Often..</option>
                    <option v-for="(fr, index) in frequencies" :key="index" :value="index">{{fr}}</option>
                </select>
            </div>
        </div>
        <div class="second-hidden mt-3" v-if="!isHidden">
            <div class="form-group">
                <textarea v-model="form.description" name="description" id="description" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('description') }"
                    placeholder="Short description for the venue (Optional)"></textarea>
                <has-error :form="form" field="description"></has-error>
            </div>
            <div class="buttons">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary">Cancel</button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        props: ['types', 'frequencies', 'priorities'],
        data() {
            return {
                ev: {},
                form: new Form({
                    name: '',
                    priority: '',
                    type: '',
                    frequency: '',
                    description: ''
                }),
                isHidden: true
            }
        },
        methods: {
            createEvent(){
                this.$Progress.start()
                this.form.post('api/event').then(() => {
                    this.$Progress.finish()
                    toast.fire({
                        type: 'success',
                        title: 'Event created successfully'
                    })
                    Fire.$emit('someChange')
                }).catch(() => {
                    this.$Progress.fail()
                    toast.fire({
                        type: 'error',
                        title: 'Event not created successfully'
                    })
                })
            }
        },
        mounted() {
            console.log('Component mounted form.')
        }
    }

</script>
