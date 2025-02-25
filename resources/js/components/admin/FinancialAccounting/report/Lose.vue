<template>
  <div class="row row-sm">
    <div class="col-xl-12">

      <div class="card">

        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2">الارباح والخسائر</span>
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

                      <td colspan="2" style="font-size: x-large;color:blue;"> الايرادات</td>


                    </tr>

                    <tr>

                      <td style="text-align: right;font-weight: 400">ايراد غياب</td>
                      <td style="text-align: right;"> </td>




                    </tr>



                    <tr>
                      <td style="font-weight: 900;">اجمالي الايرادات</td>
                      <td>
                        <span style="text-align: right;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>
                  </tbody>
                  <tbody>
                    <tr>

                      <td colspan="2" style="font-size: x-large;color:blue;"> المصروفات</td>


                    </tr>

                    <tr>

                      <td style="text-align: right;font-weight: 400">ايراد غياب</td>
                      <td style="text-align: center;"> </td>




                    </tr>


                    <tr>
                      <td style="font-weight: 900;">اجمالي المصروفات</td>
                      <td>
                        <span style=" text-align: center;color:green;font-weight: 900;">{{ sum_debit }}</span>

                      </td>


                    </tr>

                    <tr>

                      <td> صافي الحساره</td>
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
    this.type = 'AccountReport';
    this.type_of_tree = 1;
    this.showtree('account', 'tree_account');

  },
  methods: {

    // get_search(word_search) {
    //   this.axios.post(`/stocksearch`, { word_search: this.word_search }).then(({ data }) => {


    //     this.stocks = data;

    //   });
    // },
    onwaychange() {

      var account_id = $('#AccountReport_account_tree_id').val();
      let uri = `/account_report/${account_id}`;

      this.axios
        .post(uri)
        .then(({ data }) => {
          console.log(data.account_details);
          this.value_list = data.account_details;
          this.sum_debit = data.sum_debit;
          this.sum_credit = data.sum_credit

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    list(page = 1) {
      this.axios
        .post(`/account_list?page=${page}`)
        .then(({ data }) => {
          console.log(data.daily_details);
          this.value_list = data.daily_details;
          this.sum_debit = data.sum_debit;
          this.sum_credit = data.sum_credit
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  }
}
</script>