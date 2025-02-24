<template>
  <!-- row opened -->

  <div class="container-fluid">


    <div class="card">
      <div class="card-header">
          <span class="h2"> العملاء</span>

       
        </div>
      <div class="card-body">
        <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
  
        <div class="card-body">
          <form method="post" enctype="multipart/form-data">

            <div class="table-responsive">
              <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-large">
                <thead>
                  <tr>

                    <th> العميل</th>
                    <th> الهاتف</th>
                    <th> البريد الالكتروني</th>
                    <th> كلمه السر</th>
                    <th> العنوان</th>
                    <th>اضافه</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="index in count" :key="index">
                    <td>
                      <input style="background-color: beige;" v-model="name[index]" type="text" name="name" id="name"
                        class="form-control" required />

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



                    <td v-if="index == 1">
                      <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                        <i class="fa fa-plus-circle"></i></a>

                      <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                        <i class="fa fa-minus-circle"></i></a>
                    </td>



                  </tr>

                  <tr>
                    <td colspan="5"></td>
                    <td>
                      <button @click="addcustomer()" type="button" class="btn btn-primary btn-lg btn-block">
                        حفظ
                      </button>

                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </form>

        </div>
      </div>
    </div>
    <div class="col-xl-12">
      <div class="card">

        <div class="card-header">
          <!-- <span class="h2"> العملاء</span> -->

          <div style="display: flex;float: left; margin: 5px">


            <button @click="Export()">
              <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
            </button>

            <button @click="Import()">
              <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
            </button>

            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="true" placeholder="بحث عن عميل" v-model="word_search"
              @input="get_search()" />
          </div>
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">العميل</th>
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">البريد الالكتروني</th>
                  <th class="wd-15p border-bottom-0">العنوان</th>
                  <!-- <th class="wd-15p border-bottom-0"> التصنيف</th> -->
                  <!-- <th class="wd-15p border-bottom-0">الرصيد</th> -->
                  <!-- <th class="wd-15p border-bottom-0">كلمه السر</th>
                  <th class="wd-15p border-bottom-0">الصلاحيه</th> -->
                  <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="customers && customers.data.length > 0">
                <tr v-for="(customer, index) in customers.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ customer.name }}</td>
                  <td>{{ customer.phone }}</td>
                  <td>{{ customer.email }}</td>
                  <td>{{ customer.address }}</td>
                  <!-- <td>{{ customer.group_name }}</td> -->
                  <td></td>
                  <td></td>
                  <td></td>
                  <!-- <td>{{ customer.status }}</td> -->
                  <!-- <td v-if="customer.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>
                  <td v-else-if="customer.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                  <td>
                    <button type="button" @click="delete_customer(customer.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link :to="{ name: 'edit_customer', params: { id: customer.id } }" class="btn btn-success"><i
                        class="fa fa-edit"></i></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="8">
                    <h3> لايوجد عملاء </h3>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="customers" @pagination-change-page="list"></pagination>
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
      </div>
    </div>
  </div>

  <!-- /row -->
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../operation1.js';
export default {
  components: {
    pagination,
  },
  mixins: [
    operation,
    // tree
  ],
  data() {
    return {
      //   customer: "yes",

      customers: {
        type: Object,
        default: null,
      },

      type: '',
      name: [],
      phone: [],
      email: [],
      address: [],
      password: [],
      // status: [],
      role: '',
      // roleselected: 1,
      type_of_tree: '',
      jsonTreeData: '',
      group: '',
      customer_groups: '',

      word_search: "",
    };
  },
  mounted() {
    this.type = 'Customer';
    this.counts[0] = 1;
    this.list();
  },
  methods: {
    delete_customer(id) {
      this.axios.post(`/delete_customer/${id}`).then((response) => {
        // this.$router.push('customer')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/customersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.customers = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/customer?page=${page}`)
        .then(({ data }) => {
          console.log(data.data);
          this.customers = data.customers;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    Import() {
      this.axios.post(`/CustomerImport`).then(({ data }) => {
        this.list();
      });
    },

    Export() {
      this.axios.post(`/CustomerExport`).then((responce) => {
        console.log(responce);
      });
    },

    addcustomer() {

      

      // formData.append("group", this.group);

      // formData.append("account", this.account);
      // formData.append("password", this.password);
      // formData.append("status", this.status);
      // formData.append("role_id", this.roleselected);

      // send upload request
      this.axios
        .post("store_customer", {
          "count": this.counts,
          "name": this.name,
          "phone": this.phone,
          "email": this.email,
          "address": this.address,

        })
        .then(function (response) {
     


          toastMessage("تم الاضافه بنجاح");

        })
        .catch(function (error) {
          currentObj.output = error;
        });

      this.$router.go(1);

    },
  },
};
</script>