<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> السلف</span>

          </div>
          <div class="card-body">


            <div class="row row-sm">
              <div class="col-xl-12">
                <!-- <form method="post"> -->
                <div class="card">


                  <div class="card-body">



                    <div class="row">

                      <div class="col-md-2">
                      <label for="inputAddress">الفرع</label>
                      <select style="background-color: beige;" v-model="branchselected" class="form-control" required>
                        <option v-for="branch in branches" v-bind:value="branch.id">
                          {{ branch.name }}
                        </option>
                      </select>
                    </div>
                      <div class="col-md-2">
                        <label for="FormaPago">طريقه الدفع</label>
                        <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                          v-model="Way_to_pay_selected" v-on:change="onwaychange">
                          text

                          <option v-bind:value="1">نقد</option>
                          <!-- <option v-bind:value="2">أجل</option> -->
                          <option v-bind:value="3">بنك</option>
                        </select>
                      </div>





                    </div>

                    <br>
                    <br>
                    <div class="row">

                      
                      <div class="col-md-2">
                        <label for="date">الحساب</label><br />
                        <div class="custom-search">
                          <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->

                          <input style="background-color: beige;" :id="'Advance_account_tree'" type="text" readonly
                            class="custom-search-input">
                          <input :id="'Advance_account_tree_id'" type="hidden" readonly class="custom-search-input"
                            v-model="account">

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalAccountAdvance" @click="detect_index(null)">
                            <i class="fa fa-plus-circle"></i></button>
                        </div>
                      </div>
                      <div class="col-md-3">





                        <label for="cliente"> الحساب التفصيلي</label>


                        <select class="form-control" style="background-color: beige;" name="forma_pago"
                          id="select_account_Advance_group">

                        </select>





                      </div>

                      <div class="col-md-3">
                        <label for="date">التاريخ</label><br />

                        <input style="background-color: beige;" name="date" type="date" v-model="date"
                          class="form-control" />
                      </div>
                    </div>






                  </div>


                  <!-- </form> -->
                </div>
              </div>
            </div>
            <div class="row row-sm">
              <div class="col-xl-12">
                <!-- <form method="post"> -->
                <div class="card">


                  <div class="card-body">



                    <div class="row">
                      <div class="form">

                        <form method="post">
                          <div class="table-responsive">
                            <table class="table table-bordered text-right">
                              <thead>
                                <tr>




                                  <th>اسم الموظف</th>
                                  <!-- <th>الحساب </th> -->

                                  <!-- <th>الحساب التفصيلي </th> -->
                                  <th>المبلغ</th>
                                  <th>ظريقه الخصم</th>
                                  <!-- <th>التاريخ</th> -->

                                  <th>اضافه</th>


                                </tr>

                              </thead>
                              <tbody>


                                <tr v-for="index in count" :key="index">



                                  <td>

                                    <select v-model="staffselected[index]" name="type" id="type" class="form-control"
                                      required>
                                      <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                      </option>
                                    </select>

                                  </td>




                                  <td>


                                    <input @input="calc_grand_total(index)" v-model="quantity[index]" type="number"
                                      class="form-control" required />
                                  </td>
                                  <td>



                                    <label for="">من الراتب</label>
                                    <input type="checkbox" name="" id="">
                                  </td>





                                  <!-- <td>

                                    <input v-model="date[index]" type="date" class="form-control" name="name" id="name"
                                      required />

                                  </td> -->

                                  <td v-if="index == 1">
                                    <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                      v-on:click="addComponent(count)">
                                      <i class="fa fa-plus-circle"></i></a>

                                    <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                      v-on:click="disComponent(count)">
                                      <i class="fa fa-minus-circle"></i></a>
                                  </td>


                                </tr>
                                <tr>
                                  <td colspan="2">الاجمالي</td>
                                  <td>


                                    <input v-model="grand_total" type="number" class="form-control" name="name"
                                      id="name" readonly />
                                  </td>

                                  <td colspan="2">
                                    <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>

                                  </td>

                                </tr>

                              </tbody>

                            </table>
                          </div>




                        </form>
                      </div>
                    </div>




                  </div>


                  <!-- </form> -->
                </div>
              </div>
            </div>
            <div class="row row-sm">
              <div class="col-xl-12">
                <div class="card">
                  <div class="card-header">


                    <div style="display: flex;float: left; margin: 5px">




                      <button @click="exports_excel()">

                        <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
                      </button>

                      <button @click="imports_excel()">

                        <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
                      </button>

                      <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search" />
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr>

                            <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                            <th class="wd-15p border-bottom-0">المبلغ</th>


                            <th class="wd-15p border-bottom-0">التاريخ</th>


                            <th class="wd-15p border-bottom-0"> ملاجظه</th>


                            <th class="wd-15p border-bottom-0">العمليات</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(advance, index) in value_list.data" :key="index">
                            <td>{{ advance.name }}</td>

                            <td>

                              <div v-for="(adv, index) in advance.advance" :key="index">
                                {{ adv.quantity }}
                                <hr>
                              </div>
                            </td>


                            <td>

                              <div v-for="(adv, index) in advance.advance" :key="index">
                                {{ adv.date }}
                                <hr>
                              </div>
                            </td>

                            <td>

                              <div v-for="(adv, index) in advance.advance" :key="index">
                                {{ adv.note }}
                                <hr>
                              </div>
                            </td>


                            <td>
                      <button type="button" class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>


                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateAd"
                        data-toggle="modal" id="agregar_productos">
                        <i class="fa fa-edit"></i></a>

                    </td>


                            <!-- <td>
                      <button type="button" class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateAd"
                        data-toggle="modal" id="agregar_accountos">
                        <i class="fa fa-edit"></i></a>

                    </td> -->
                          </tr>
                        </tbody>
                        <!-- <tbody v-else>
                          <tr>
                            <td align="center" colspan="3">لايوجد بياتات.</td>
                          </tr>
                        </tbody> -->
                      </table>
                    </div>
                    <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
                  </div>




                </div>
              </div>

            </div>
          </div>



        </div>
      </div>

    </div>




    <div class="modal fade" id="exampleModalAccountAdvance" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_account_Advance"></div>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>

import pagination from "laravel-vue-pagination";
// import operation from '../../../../../js/staff/operation/operation.js';
import operation from '../../../../operation.js';
import tree from '../../../../../js/tree/tree.js';

export default {
  components: {
    pagination,
  },
  mixins: [
    operation,
    // operation2, 
    tree],
  data() {
    return {


      staffselected: [],
      debit: '',
      grand_total: '',
      quantity: [],
      account: [],

      word_search: "",
      Way_to_pay_selected: '',

    };
  },
  mounted() {
    this.counts[0] = 1;
    this.type_of_tree = 1;
    this.type = 'Advance';
    this.list();
    this.showtree('account', 'tree_account');


  },

  methods: {


    onwaychange(e) {
      this.paid = 0;
      this.remaining = 0;
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {
        this.show = true;


      } else {
        this.show = false;
      }

      if (input.value == 1) {

        this.paid = this.grand_total;

      }

      if (input.value == 3) {

        this.paid = this.grand_total;

      }

    },
    calc_grand_total(count) {

      var quantity = 0;

      for (let index = 0; index < count; index++) {

        quantity = parseInt(quantity) + parseInt(this.quantity[index + 1]);

      }

      this.grand_total = quantity;


    },

    Add_new() {

      this.axios
        .post(`/store_advance`, {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          qty: this.quantity,
          date: this.date,


          debit: {

            account_id: this.debit[0].account_id,
            account_details: '',
            value: this.quantity,

          },
          credit: {

            account_id: $(`#Advance_account_tree_id`).val(),
            account_details: $(`#select_account_${this.type}_group`).val(),
            value: this.quantity,
          },
          daily_index: 1,
          payment_type: this.Way_to_pay_selected,
          grand_total: this.grand_total,
          type_daily: 'hr_advance',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });




    },


    get_search(word_search) {
      this.axios
        .post(`/advancesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.branches = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/advance?page=${page}`, { type: 'advance' })
        .then(({ data }) => {
          this.value_list = data.list;
          // console.log('jhdjshjsdssssssssssss',data);
          this.staffs = data.staffs;
          this.debit = data.debit;

        })
        .catch(({ response }) => {
          // console.error(response);
        });
    },

    exports_excel() {

      axios
        .post(`/export_staff`)
        .then(function (response) {

          toastMessage("تم التصدير");
          this.list();
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`/import_staff`)
        .then(function (response) {

          toastMessage("تم الاستيراد");
          this.list();

        })
        .catch(error => {

        });
    },



  },
};
</script>
