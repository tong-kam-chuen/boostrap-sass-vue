<template>
    <!-- <div class="container"> -->
    <div class="row" v-if="$gate.isAdminOrAuthor()" >
      <div class="col-lg-12">
        <div class="card">
          <!-- /.card-header -->
          <div class="card-header">
            <span class="card-title"></span>
              Users Table
            <div class="card-tools">
              <div class="input-group input-group-sm">
                <div class="input-group-append">
                  <button class="btn btn-success" @click="newModal" >
                    Add New <i class="fas fa-user-plus fa-fw yellow"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>Email</th>
                  <th>Type</th>
                  <th>Created_At</th>
                  <th>Updated_At</th>
                  <th>Modify</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="user in users.data" :key="user.id">
                  <td><span style="font-size:11px">{{ user.id }}                     </span></td>
                  <td><span style="font-size:11px">{{ user.name }}                   </span></td>
                  <td><span style="font-size:11px">{{ user.email }}                  </span></td>
                  <td><span style="font-size:11px">{{ user.type | upText }}          </span></td>
                  <td><span style="font-size:8px"> {{ user.created_at | formatDate }}</span></td>
                  <td><span style="font-size:8px"> {{ user.updated_at | formatDate }}</span></td>
                  <td>
                    <a href="#" class="blue" @click="editModal(user)">Edit
                      <i class="fa fa-edit blue"></i>
                    </a>

                    <a href="#" class="red" @click="deleteUser(user.id)">Delete
                      <i class="fa fa-trash red"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <pagination :data="users"
            @pagination-change-page="getResults"></pagination>
          </div>
        </div>
        <!-- /.card -->
      </div>

      <!-- input Modal -->

      <div class="modal fade" id="input" tabindex="-1" role="dialog"
        aria-labelledby="inputLable" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" v-show="!editmode" id="inputLabel">Add New</h5>
              <h5 class="modal-title" v-show="editmode" id="inputLabel">Update User's Info</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <form @submit.prevent="editmode ? updateUser() : createUser()" >
              <div class="modal-body">
                <div class="form-group">
                  <input v-model="form.name" type="text" name="name" placeholder="Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.email" type="email" name="email" placeholder="Email Address"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.photo" type="text" name="photo" placeholder="Photo Link"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('photo') }">
                  <has-error :form="form" field="photo"></has-error>
                </div>

                <div class="form-group">
                  <textarea v-model="form.bio" name="bio" id="bio"
                    placeholder="Short bio for user (Optional)"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                  <has-error :form="form" field="bio"></has-error>
                </div>

                <div class="form-group">
                  <select v-model="form.type" name="type" id="type" placeholder="Select User Role"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="admin" >Administrator</option>
                    <option value="user"  >Standard User</option>
                    <option value="author">Author       </option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div>

                <div class="form-group">
                  <input v-model="form.password" type="password" name="password" id="password"
                    placeholder="Password"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success" v-show="editmode">Update</button>
                <button type="submit" class="btn btn-primary" v-show="!editmode">Create</button>
              </div>
            </form>

          </div>
        </div>
      </div>
      <!-- input Modal -->

    </div>
    <div class="row" v-else >
      <unauthorized></unauthorized>
    </div>
</template>

<script>
    export default {
      data () {
        return {
          editmode: false,
          users : {},
          form : new Form({
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
      methods: {
          getResults(page = 1) {
              let query = this.$parent.search;
              axios.get('api/user?page=' + page + '&q=' + query)
                   .then(response => {
                      this.users = response.data;
                   });
          },
          loadUsers () {
              if (this.$gate.isAdminOrAuthor()) {
                axios.get('api/user').then(({ data }) => (this.users = data));
              }
          },
          deleteUser (id) {
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                  if (result.value) {
                    this.form.delete('api/user/'+id).then(() => {
                              Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                              );
                              Fire.$emit('AfterDelete');
                        }).catch(() => {
                              Swal.fire(
                                'Failed!',
                                'There was something wrong.',
                                'warning'
                              );
                        });
                  }
              })
          },
          newModal () {
              this.editmode = false;
              this.form.reset();
              $('#input').modal('show');
          },
          editModal (user) {
              this.editmode = true;
              this.form.reset();
              $('#input').modal('show');
              this.form.fill(user);
          },
          updateUser () {
              this.$Progress.start();
              this.form.put('api/user/'+this.form.id)
                  .then(() => {
                      Fire.$emit('AfterUpdate');
                      $('#input').modal('hide');

                      Swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                      );
                      this.$Progress.finish();
                  })
                  .catch(() => {
                      Swal.fire(
                        'Failed!',
                        'There was something wrong.',
                        'warning'
                      );
                      this.$Progress.fail();
                  });
          },
          createUser () {
              this.$Progress.start();
              this.form.post('api/user')
              Fire.$emit('AfterCreate');
              $('#input').modal('hide');

              Toast.fire({
                icon: 'success',
                title: 'User Created Successfully'
              });

              this.$Progress.finish();
          },
          searchit () {
              Fire.$emit('searching');
          }
      },
      created () {
          this.loadUsers();
          Fire.$on('searching', () => {
              let query = this.$parent.search;
              if (this.$gate.isAdminOrAuthor()) {
                axios.get('api/user?q=' + query)
                     .then(({ data }) => {
                        this.users = data
                     })
                     .catch(() => {

                     });
              }
          });
          Fire.$on('AfterCreate', () => {
              this.loadUsers();
          });
          Fire.$on('AfterDelete', () => {
              this.loadUsers();
          });
          Fire.$on('AfterUpdate', () => {
              this.loadUsers();
          });
          // setInterval(() => this.loadUsers(), 3000);
      }
    }
</script>
