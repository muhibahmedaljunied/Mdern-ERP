<template>
  <div class="row row-sm">
    <div class="col-xl-12">

      <div class="card">

        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> الميزانيه العموميه</span>
          </div>
          <p class="tx-12 tx-gray-500 mb-2">

          </p>

        </div>
        <div class="card-body">


          <div class="row">

            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table text-md-nowrap" id="example1">

                  <tbody>
                    <tr text-align: right>

                      <td colspan="2" style="font-size: x-large"> الاصول</td>


                    </tr>

                    <tr v-if="value_list.assest_changed" v-for="data in value_list.assest_fixed">

                      <td style="text-align: right;font-weight: 400"> {{ data.text }}</td>
                      <td style="text-align: right;color: blue;">

                        {{ data.sum_credit - data.sum_debit }}

                      </td>




                    </tr>


                    <tr >
                      <td style="font-weight: 900;">اجمالي الاصول الثابته</td>
                      <td>
                        <span style="text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>
                    <!-- -------------------------------------------------------------------------------------------------------------------- -->


                    <tr v-if="value_list.assest_changed" v-for="data in value_list.assest_changed">

                      <td style="text-align: right;font-weight: 400"> {{ data.text }}</td>
                      <td style="text-align: right;color: blue;">

                        {{ data.sum_credit - data.sum_debit }}

                      </td>




                    </tr>
                    <tr>
                      <td style="font-weight: 900;">اجمالي الاصول المتداوله</td>
                      <td>
                        <span style="text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>

                    <tr class="tt">
                      <th style="font-weight: 900;text-align: right;">اجمالي الاصول </th>
                      <th>
                        <span style="text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </th>


                    </tr>

                    <!-- <tr>

                      <td colspan="3">
                        <hr  style="color: black;border-width: 10px;">
                      </td>
                    </tr> -->
                  </tbody>
                  <tbody>
                    <tr>

                      <td colspan="2" style="font-size: x-large"> الالتزامات</td>


                    </tr>

                    <tr v-if="value_list.big_fixed" v-for="data in value_list.big_fixed">

                      <td style="text-align: right;font-weight: 400"> {{ data.text }}</td>
                      <td style="text-align: right;color: blue;">

                        {{ data.sum_credit - data.sum_debit }}

                      </td>




                    </tr>


                    <tr>
                      <td style="font-weight: 900">اجمالي الالتزامات الثابته</td>
                      <td>
                        <span style=" text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>


                    <!-- -------------------------------------------------------------------------------------------------------------------- -->



                    <tr v-if="value_list.big_changed" v-for="data in value_list.big_changed">

                      <td style="text-align: right;font-weight: 400"> {{ data.text }}</td>
                      <td style="text-align: right;color: blue;">

                        {{ data.sum_credit - data.sum_debit }}

                      </td>




                    </tr>


                    <tr>
                      <td style="font-weight: 900">اجمالي الالتزامات المتداوله</td>
                      <td>
                        <span style=" text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>
                    <tr>
                      <td style="font-weight: 900;text-align: right;">اجمالي الالتزامات </td>
                      <td>
                        <span style=" text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>

                    <!-- <tr>

                      <td colspan="3">
                        <hr  style="color: black;font;border-width: 10px;">
                      </td> 
                    </tr> -->

                    <!-- -------------------------------------------------------------------------------------------------------------------- -->

                    <tr>

                      <td colspan="2" style="font-size: x-large"> حقوق الملكيه</td>


                    </tr>

                    <tr>

                      <td style="text-align: right;font-weight: 400">ايراد غياب</td>
                      <td style="text-align: right;color: blue;"> 20000000</td>




                    </tr>

                    <tr>

                      <td style=" text-align: right;font-weight: 900;"> اجمالي الالتزامات+جقوق الملكيه</td>
                      <td>
                        <span style="color:green;text-align: right;">{{ sum_debit }}</span>

                      </td>


                    </tr>

                    <tr>

                      <td> الاجمالي</td>
                      <td>
                        <span style="color:green;text-align: center;">{{ sum_debit }}</span>

                      </td>


                    </tr>

                  </tbody>

                </table>
              </div>
            </div>
          </div>


          <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalAccountReport" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_account"></div>

          </div>

        </div>
      </div>
    </div>

    <!--/div-->
  </div>
</template>
<script>

import pagination from "laravel-vue-pagination";
import operation1 from '../../../../operation1.js';
// import operation from '../../../../operation.js';
import tree from '../../../../tree/tree.js';
export default {

  components: {
    pagination
  },
  mixins: [operation1, tree],

  data() {
    return {
      // stock:'yes',

      value_list: {
        type: Object,
        default: null,
      },
      sum_debit: '',
      sum_credit: '',
      word_search: "",
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),



    }
  },
  mounted() {
    this.list();
    // this.type = 'BalanceReport';
    // this.type_of_tree = 1;
    // this.showtree('account', 'tree_account');

  },
  methods: {



    list() {
      this.axios
        .post(`/balance_report`)
        .then(({ data }) => {

          console.log('df', data.list.assest_changed);
          this.value_list = data.list;
          // this.sum_debit = data.sum_debit;
          // this.sum_credit = data.sum_credit
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  }
}
</script>