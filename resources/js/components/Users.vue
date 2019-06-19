<template>
    <div class="container">
        <div class="row justify-content-center  mt-5">
            <div class="col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Users</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" v-on:click="editmode = false"
                                data-toggle="modal" data-target="#addNewUser">
                                Add New <i class="fas fa-user-plus fa-fw"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Type</th>
                                    <th>Modify</th>
                                </tr>
                                <tr v-for="(user, index) in users" :key="user.id">
                                    <td>{{index + 1}}</td>
                                    <td>{{user.name | upcase}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.created_at | formatDate}}</td>
                                    <td>Admin</td>
                                    <td>
                                        <div class="btn-group" role="group"
                                            aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button"
                                                    class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-cog fa-fw"> </i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    <a class="dropdown-item" @click="popModal(user)"
                                                        v-on:click="editmode = true">Edit</a>
                                                    <a class="dropdown-item" href="#">Assign Event Role</a>
                                                    <a class="dropdown-item" href="#">Invite</a>
                                                    <a class="dropdown-item" @click="deleteUser(user.id)">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addNewUserLabel">{{title}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" placeholder="User name here..."
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('email') }" placeholder="Email address">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.bio" name="bio" id="bio" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('bio') }"
                                    placeholder="Short bio for your user (Optional)"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <select v-model="form.type" name="type" id="type" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('type') }">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admins</option>
                                    <option value="user">User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('password') }" placeholder="Password">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{btnLabel}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editmode: false,
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        computed: {
            title() {
                return this.editmode ? 'Update User Information' : 'Create new user';
            },
            btnLabel() {
                return this.editmode ? 'Update Changes' : 'Save Changes';
            }
        },
        methods: {
            popModal(user) {
                // display modal to either edit or delete with venue data
                this.form.reset();
                $('#addNewUser').modal('show')
                this.form.fill(user)
            },
            createUser() {
                this.$Progress.start()
                this.form.post('api/user').then(() => {
                    this.$Progress.finish()
                    toast.fire({
                        type: 'success',
                        title: 'User created successfully'
                    })
                    $('#addNewUser').modal('hide')
                    Fire.$emit('afterChange')
                })
            },
            updateUser() {
                this.$Progress.start()
                this.form.put(`api/user/${this.form.id}`).then(() => {
                    this.$Progress.finish()
                    toast.fire({
                        type: 'success',
                        title: 'User updated successfully'
                    })
                    $('#addNewUser').modal('hide')
                    Fire.$emit('afterChange')
                })
            },
            loadUsers() {
                this.$Progress.start()
                this.form.get('api/user').then(({
                    data
                }) => {
                    this.users = data.data
                    this.$Progress.finish()
                })
            },
            deleteUser(userId) {
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
                        this.form.delete('api/user' + userId).then((res) => {
                            toast.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }).catch(() => {
                            toast.fire(
                                'Not Deleted!',
                                'Somthing unexpected happened.',
                                'error'
                            )
                        })
                        Fire.$emit('afterChange')
                    }
                })
            }
        },
        mounted() {
            this.loadUsers()
            Fire.$on('afterChange', () => {
                this.loadUsers()
            })
            // setInterval(() => {
            //     this.loadUsers();
            // }, 3000);

        }
    }

</script>
