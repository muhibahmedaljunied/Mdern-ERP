<template>
  <!-- row opened -->
  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> المستخدمين</span>
            </div>
          

          </div>
          <div class="card-body">
            <div class="form">
              
            

              <form method="post" enctype="multipart/form-data">

                <div class="table-responsive">
                  <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                    <thead>
                      <tr>
                        <th> الاسم</th>
                        <th> الهاتف</th>
                        <th> البريد الالكتروني</th>
                        <th> كلمه السر</th>
                        <th> العنوان</th>
                        <th> الصلاحيه</th>
                        <th> الحاله</th>



                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="index in count" :key="index">
                        <td>
                          <input v-model="name[index]" type="text" name="name" id="name" class="form-control" required />

                        </td>

                        <td>
                          <input v-model="phone[index]" type="text" name="phone" id="phone" class="form-control" />

                        </td>


                        <td>
                          <input v-model="email[index]" type="text" name="email" id="email" class="form-control" />
                        </td>


                        <td>
                          <input v-model="password[index]" type="text" name="password" id="password" class="form-control"
                            required />
                        </td>


                        <td>
                          <input v-model="address[index]" type="text" name="address" id="address" class="form-control" />
                        </td>

                        <td>
                          <select v-model="roleselected[index]" name="role" id="role" class="form-control" required>
                            <option value="">select</option>
                            <option v-for="roles in role" v-bind:value="roles.id">
                              {{ roles.name }}
                            </option>
                          </select>
                        </td>

                        <td>
                          <input v-model="status[index]" type="text" name="status" id="status" class="form-control" />

                        </td>

                        <td v-if="index == 1">
                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></a>

                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                              <i class="fa fa-minus-circle"></i></a>
                          </td>





                      </tr>

                      <tr>
                        <td colspan="7"></td>
                        <td>
                          <button type="button" class="btn btn-primary" @click="adduser()">حفظ </button>
                        </td>
                      </tr>

                    </tbody>
                  </table>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!--/div-->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <!-- <span class="h2"> الموردين</span> -->

            <div style="display: flex;float: left; margin: 5px">


              <button @click="Export()">
                <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
              </button>

              <button @click="Import()">
                <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
              </button>

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                @input="get_search()" />
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">الاسم</th>
                    <th class="wd-15p border-bottom-0">الهاتف</th>
                    <th class="wd-15p border-bottom-0">البريد الالكتروني</th>
                    <th class="wd-15p border-bottom-0">العنوان</th>
                    <!-- <th class="wd-15p border-bottom-0">كلمه السر</th> -->
                    <th class="wd-15p border-bottom-0">الصلاحيه</th>
                    <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="users && users.data.length > 0">
                  <tr v-for="(user, index) in users.data" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.phone }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.address }}</td>
                    <!-- <td>{{ user.password }}</td> -->
                    <td>{{ user.role_name }}</td>
                    <!-- <td>{{ user.status }}</td> -->
                    <!-- <td v-if="user.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>
                  <td v-else-if="user.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                    <td>
                      <button type="button" @click="delete_user(user.id)" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                      </button>
                      <router-link :to="{ name: 'edit_user', params: { id: user.id } }" class="btn btn-success"><i
                          class="fa fa-edit"></i></router-link>
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">لايوجد بياتات.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="users" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
      <!--/div-->
    </div>

  </div>

  <!-- /row -->
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../js/staff/BasicData/operation.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      //   user: "yes",

      users: {
        type: Object,
        default: null,
      },

      error_name: '',
      error_email: '',
      error_password: '',
      name: [],
      phone: [],
      email: [],
      address: [],
      password: [],
      status: [],
      role: '',
      roleselected: [],



      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
  },
  created() {
    let uri = `/create_user`;
    this.axios.post(uri).then((response) => {
      console.log(response.data);
      this.role = response.data;
    });
  },
  methods: {
    delete_user(id) {
      this.axios.post(`/delete_user/${id}`).then((response) => {
        // this.$router.push('user')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/usersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.users = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/user?page=${page}`)
        .then(({ data }) => {
          this.users = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    adduser() {
   
      this.axios
        .post("store_user", {

          count: this.counts,
          name: this.name,
          phone: this.phone,
          email: this.email,
          address: this.address,
          password: this.password,
          role:this.roleselected,
          status: this.status,


        })
        .then(function (response) {
        
          toastMessage("تم الاضافه بنجاح");

          this.list();

        })
        .catch(error => {
          console.error(error)

          this.error_name = error.response.data.error.name
          this.error_email = error.response.data.error.email
          this.error_password = error.response.data.error.password

        });

      // this.$router.go(0);

    },
  },
};
</script>