<template>
  <div class='container-fluid'>
    <div class="row row-sm">
      <div class="col-xl-12">

        <div class="card">

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2">الارصده الافتتاحيه</span>
            </div>
          </div>

          <div class="card-body">

            <div class="row">

              <div class="card">
                <!-- <form method="post" @submit.prevent="submitForm"> -->


                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-2">
                            <label for="desde">تاريخ القيد </label>
                            <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                              name="modal_reporte_venta_inicio" v-model="daily_date"
                              onkeypress="return controltag(event)" style="background-color: white" />
                          </div>

                          <div class="col-md-2">
                          <label for="inputAddress">الفرع</label>
                          <select v-model="branchselected" class="form-control" required>
                            <option v-for="branch in branches" v-bind:value="branch.id">
                              {{ branch.name }}
                            </option>
                          </select>
                        </div>
                        
                          <div class="col-md-2">
                            <label for="desde"> اجمالي المدين </label>
                            <input v-model="total_debit" type="text" class="form-control hasDatepicker"
                              onkeypress="return controltag(event)" readonly />
                          </div>
                          <div class="col-md-2">
                            <label for="desde"> اجمالي الدائن </label>
                            <input v-model="total_credit" type="text" class="form-control hasDatepicker"
                              onkeypress="return controltag(event)" readonly />
                          </div>


                        </div>
                      </div>
                    </div>
                  </div>



                </div>
              </div>

              <!-- ------------------------------------------------------------------------------------------ -->
              <div class="card">
                <!-- <form method="post" @submit.prevent="submitForm"> -->


                <div class="card-body">

                  <div class="row">
                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                            <th class="wd-15p border-bottom-0">رقم الحساب</th>
                            <th class="wd-15p border-bottom-0">اسم الحساب</th>
                            <th class="wd-15p border-bottom-0"> الحساب التفصيلي</th>
                            <th class="wd-15p border-bottom-0"> العمله</th>
                            <th class="wd-15p border-bottom-0">البيان</th>
                            <th class="wd-15p border-bottom-0">مدين</th>

                            <th class="wd-15p border-bottom-0">داين</th>
                            <th>+</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="index in count" :key="index">

                            <td>
                              {{ index+1 }}
                            </td>
                            <td>
                              <input required type="number" :id="'OpenningBalance_accounts_tree_id' + index"
                                name="account_id" class="form-control input_cantidad" readonly />
                            </td>
                            <td>




                              <div class="custom-search">

                                <input :id="'OpenningBalance_accounts_tree' + index" type="text" readonly
                                  class="custom-search-input">

                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                  data-target="#exampleModal" @click="detect_index(index)"> <i
                                    class="fa fa-plus-circle"></i></button>
                              </div>



                            </td>

                            <td>




                              <select class="form-control" style="background-color: beige;" name="forma_pago"
                                :id="'select_account_OpenningBalance_group_' + index">

                              </select>






                            </td>

                            <td>



                              <input style="text-align: center;color:red" v-model="currency" name="date" type="number"
                                class="form-control" />



                            </td>





                            <td>
                              <input v-model='description[index]' required type="text" style="width: 500px"
                                class="form-control input_cantidad" />
                            </td>
                            <td>
                              <input @input="calculate_total('debit')" v-model='debit[index]' type="number"
                                style="width: 150px" class="form-control input_cantidad" />
                            </td>
                            <td>
                              <input @input="calculate_total('credit')" v-model='cred[index]' type="number"
                                style="width: 150px" class="form-control input_cantidad" />
                            </td>


                            <td v-if="index == 1">

                              <button class="tn btn-info btn-sm waves-effect btn-agregar" @click="addComponent(index)">
                                <i class="fa fa-plus-circle"></i></button>

                              <button class="tn btn-info btn-sm waves-effect btn-agregar" @click="disComponent(index)">
                                <i class="fa fa-minus-circle"></i></button>



                            </td>
                          </tr>
                          <tr>

                            <td colspan="5" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                            <td style="text-align:center;color:red;font-size:large">

                              <input type="hidden" style="width: 250px" class="form-control input_cantidad" />

                            </td>
                            <td style="text-align:center;color:red;font-size:large">

                              <input type="hidden" style="width: 250px" class="form-control input_cantidad" />

                            </td>


                            <td> <a href="javascript:void" @click='addDaily()' class="btn btn-primary"><span>تاكيد
                                  العمليه</span></a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                  </div>


                </div>
              </div>
              <div class="card">


                <div class="card-header">
                  <span class="h2"> التفاصيل</span>

                  <div style="display: flex;float: left; margin: 5px">


                    <button @click="exports_excel()">

                      <i class="fa-solid fa-file-export " style="font-size: 24px; color: #63E6BE;"></i>
                    </button>

                    <button @click="imports_excel()">

                      <i class="fa-solid fa-file-import " style="font-size: 24px; color: #B197FC;"></i>
                    </button>

                    <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                      aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                      @input="get_search()" />
                  </div>
                </div>
                <div class="card-body" id="printme">

                  <div class="row">

                    <div class="table-responsive">
                      <table class="table table-bordered text-center">
                        <thead>
                          <tr>
                            <th class="wd-15p border-bottom-0">رقم الحساب</th>
                            <th class="wd-15p border-bottom-0">اسم الحساب</th>
                            <th class="wd-15p border-bottom-0">البيان</th>
                            <th class="wd-15p border-bottom-0">مدين</th>
                            <th class="wd-15p border-bottom-0">داين</th>

                          </tr>
                        </thead>
                        <tbody v-if="value_list && value_list.data.length > 0">
                          <tr v-for="(daily, index) in value_list.data" :key="index">
                            <!-- <tr > -->
                            <td>
                              {{ daily.id }}
                            </td>
                            <td>

                              {{ daily.text }}

                            </td>
                            <td>

                              {{ daily.description }}
                            </td>
                            <td>
                              {{ daily.debit }}
                            </td>
                            <td>
                              {{ daily.credit }}
                            </td>



                          </tr>
                          <tr>
                            <td colspan="3">الاجمالي</td>
                            <td> <span style="color:green">{{ sum_debit }}</span></td>
                            <td> <span style="color:green">{{ sum_credit }}</span></td>
                            <!-- <td></td> -->


                          </tr>

                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td align="center" colspan="5">
                              <h3> لايوجد بيانات </h3>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>



                </div>
              </div>


            </div>
          </div>
        </div>



      </div>



      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="container">

                <div class="well" id="treeview_json_accounts"></div>

              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- </form> -->
    </div>

  </div>
</div></template>
<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../operation.js';

export default {
  mixins: [tree,
    operation],
  data() {
    return {


      value_list: {
        type: Object,
        default: null,
      },

      date: new Date().toISOString().substr(0, 10),

      table: '',
      type: '',


      total_debit: '',
      total_credit: '',

      // -----------------------------------------
      count: 1,
      daily_date: "2021-11-24",
      daily_id: '',
      trees: "",
      account: [],
      account_name: [],
      description: [],

      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',
      indexselectedaccount: '',
      sum_debit: '',
      sum_credit: '',
      last_nodes: '',

      cred: [],
      index: 0,

      // ---------

      debit_account_id: [],
      credit_account_id: [],
      debit_value: [],
      credit_value: [],
      debit_account_details: [],
      credit_account_details: [],
      debit_description: [],
      credit_description: [],


    };
  },
  mounted() {
    this.list();
    this.type = 'OpenningBalance';
    this.counts[0] = 1;
    this.type_of_tree = 1;
    this.showtree('accounts', 'tree_account');




  },

  methods: {

    list() {

      this.axios
        .post(`/daily`)
        .then(({ data }) => {
          // console.log('daily', data.daily_details.data);
          this.value_list = data.daily_details;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    onwaychange() {

      this.axios
        .post(`/daily/${this.daily_id}`)
        .then(({ data }) => {
          console.log(data.account_details);
          this.value_list = data.daily_details;
          this.sum_debit = data.sum_debit;
          this.sum_credit = data.sum_credit
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    addDaily() {



      // console.log(this.account)
      // console.log(this.credit);



      for (let index = 1; index <= this.count; index++) {
        // for (const key in this.account) {


        if (this.cred[index]) {

          this.credit_account_id[index] = this.account[index];
          this.credit_value[index] = this.cred[index];
          this.credit_account_details[index] = $(`#select_account_${this.type}_group_${index}`).val();
          this.credit_description[index] = this.description[index];

        }

        if (this.debit[index]) {

          this.debit_account_id[index] = this.account[index];
          this.debit_value[index] = this.debit[index];
          this.debit_account_details[index] = $(`#select_account_${this.type}_group_${index}`).val();
          this.debit_description[index] = this.description[index];
        }





        // }
      }
      // console.log('ere1', this.debit_account_id, this.debit_value, this.debit_description);
      // console.log('ere12', this.credit_account_id, this.credit_value, this.credit_description);

      // for (const key in this.credit) {
      //   if (Object.prototype.hasOwnProperty.call(this.credit, key)) {

      //     const element = this.credit[key];



      //     console.log('credit',element,this.credit);

      //   }
      // }


      // for (const key in this.account) {
      //   if (Object.prototype.hasOwnProperty.call(this.account, key)) {

      //     const element = this.account[key];


      //     console.log('account',element,this.account);
      //   }
      // }

      // console.log(this.debit[index]);
      // console.log(this.credit[index]);

      // if (this.debit[index].length>0) {

      //   this.debit_account_id[index] = this.account[index];
      //   this.debit_value[index] = this.debit[index];
      //   this.debit_account_details[index] = this.account_details[index];
      //   this.debit_description = this.description[index];
      // }

      // if (this.credit[index].length>0) {

      //   this.credit_account_id[index] = this.account[index];
      //   this.credit_value[index] = this.credit[index];
      //   this.credit_account_details[index] = this.account_details[index];
      //   this.credit_description = this.description;

      // }




      // }

      // console.log('debit_account_id',this.debit_account_id);
      // console.log('1',this.debit_value);
      // console.log('1',this.debit_account_details);
      // console.log('1',this.debit_description);
      // console.log('credit_account_id',this.credit_account_id);
      // console.log('1',this.credit_value);
      // console.log('1',this.credit_account_details);
      // console.log('1',this.credit_description);
      this.axios
        .post("/store_daily_openning_balance", {

          count: this.counts,
          daily_date: this.daily_date,
          total_debit: this.total_debit,
          total_credit: this.total_credit,
          debit: {
            account_id: this.debit_account_id,
            value: this.debit_value,
            account_details: this.debit_account_details,
            // description: this.debit_description,

          },
          credit: {

            account_id: this.credit_account_id,
            value: this.credit_value,
            account_details: this.credit_account_details,
            // description: this.credit_description,

          },
          type_daily: 'openning_balance',
          date: this.date,
          // treasury: this.treasury[0],

          // grand_total: this.grand_total,
          // paid: this.paid,




        })
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";


          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });
      // }
      // this.$router.go(-1);
    },

    calculate_total(type) {




      if (type == 'debit') {

        this.total_debit = 0;

      }

      if (type == 'credit') {

        this.total_credit = 0;
      }

      this.calc_total(type);


    },

    calc_total(type) {

      for (let i = 1; i <= this.count; i++) {


        if (type == 'debit') {

          if (this.debit[i]) {

            this.total_debit = parseInt(this.debit[i]) + parseInt(this.total_debit);

          } else {

            this.total_debit = parseInt(0) + parseInt(this.total_debit);
          }

        }

        if (type == 'credit') {

          if (this.cred[i]) {

            this.total_credit = parseInt(this.cred[i]) + parseInt(this.total_credit);

          } else {

            this.total_credit = parseInt(0) + parseInt(this.total_credit);
          }
        }



      }
    },

  },
};
</script>