<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <span class="h2"> الموردين</span>


        </div>

        <div class="card-body">
          <form method="post" enctype="multipart/form-data">

            <div class="table-responsive">
              <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-large">
                <thead>
                  <tr>

                    <th> المورد</th>
                    <th> الهاتف</th>
                    <th> البريد الالكتروني</th>
                    <!-- <th> كلمه السر</th> -->
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
                    <!-- <td>
                      <input v-model="password[index]" type="text" name="password" id="password" class="form-control"
                        required />

                    </td> -->


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
                    <td colspan="4"></td>
                    <td>
                      <button @click="addsupplier()" type="button" class="btn btn-primary btn-lg btn-block">
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
          <!-- <span class="h2"> الموردين</span> -->

          <div style="display: flex;float: left; margin: 5px">


            <button @click="Export()">
              <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
            </button>

            <button @click="Import()">
              <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
            </button>

            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="true" placeholder="بحث عن مورد" v-model="word_search"
              @input="get_search()" />
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">الاسم </th>
                  <!-- <th class="wd-15p border-bottom-0">الاسم </th> -->
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">البريد الالكتروني</th>
                  <th class="wd-15p border-bottom-0">العنوان</th>
                  <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->
                  <!-- <th class="wd-15p border-bottom-0">التصنيف</th> -->
                  <th class="wd-15p border-bottom-0">الرصيد</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="suppliers && suppliers.data.length > 0">
                <tr v-for="(supplier, index) in suppliers.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ supplier.name }}</td>
                  <!-- <td>{{ supplier.last_name }}</td> -->
                  <td>{{ supplier.phone }}</td>
                  <td>{{ supplier.email }}</td>
                  <td>{{ supplier.address }}</td>
                  <!-- <td>{{ supplier.group_name }}</td> -->
                  <td></td>
                  <!-- <td>{{ supplier.status }}</td> -->
                  <!-- <td v-if="supplier.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>

                  <td v-else-if="supplier.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                  <td>
                    <button type="button" @click="delete_supplier(supplier.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link :to="{
                      name: 'edit_supplier',
                      params: { id: supplier.id },
                    }" class="btn btn-success"><i class="fa fa-edit"></i></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="8">
                    <h3> لايوجد موردين </h3>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="suppliers" @pagination-change-page="list"></pagination>
        </div>
      </div>
    </div>
  </div>
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
      // supplier:'yes',

      suppliers: {
        type: Object,
        default: null,
      },


      type: '',
      error_name: '',
      error_email: '',
      name: [],
      phone: [],
      email: [],
      address: [],
      // last_name: [],
      status: [],
      type_of_tree: 0,
      jsonTreeData: '',
      group: '',
      supplier_groups: '',

      word_search: "",
    };
  },
  mounted() {

    this.type = 'Supplier';
    this.counts[0] = 1;

    this.list();

  },
  methods: {
    get_search(word_search) {
      this.axios
        .post(`/suppliersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.suppliers = data;
        });
    },
    Import() {
      this.axios.post(`/SupplierImport`).then(({ data }) => {
        this.list();
      });
    },

    Export() {
      this.axios.post(`/SupplierExport`).then((responce) => {
        console.log(responce);
      });
    },

    delete_supplier(id) {
      this.axios
        .post(`delete_supplier/${id}`)
        .then((response) => {
          toastMessage("تم الحذف بنجاح");

          this.list();
        })
        .catch((error) => {
          console.log(error.response);

          if (error.response.status == 500) {
            // toastMessage("فشل", error.response.data.message);
            toastMessage("فشل", 'لايمكن الحذف لانه مرتبط بعملبات اخري');
          }
        });
    },
    addsupplier() {


      this.axios
        .post("store_supplier", {
          "count": this.counts,
          "name": this.name,
          "phone": this.phone,
          "email": this.email,
          "address": this.address,

        })
        .then(function (response) {

          // console.log(response.error);

          toastMessage("تم الاضافه بنجاح");
        })
        .catch(error => {
          console.error(error)

          this.error_name = error.response.data.error.name
          this.error_email = error.response.data.error.email

        });

      this.$router.go(1);
    },
    list(page = 1) {
      this.axios
        .post(`/supplier?page=${page}`)
        .then(({ data }) => {
          this.suppliers = data.suppliers;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>
