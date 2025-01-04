<template>
  <div class='container-fluid'>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال الارباح والخسائر</span>
            </div>
          </div>
          <div class="card-body" id="printme">


            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">


                    <div class="col-md-3">
                      <label for="desde"> الحساب</label>

                      <div class="custom-search">
                        <!-- <input id='product_tree' type="text" class="custom-search-input" readonly> -->

                        <!-- <input :id="'Transfer_store_tree'" type="text" readonly class="custom-search-input" />
                        <input :id="'Transfer_store_tree_id'" type="hidden" readonly class="custom-search-input" /> -->

                        <input id="Close_account_tree" type="text" class="custom-search-input">
                        <input id="Close_account_tree_id" type="hidden" class="custom-search-input">
                        <button class="custom-search-botton" type="button" data-toggle="modal"
                          data-target="#exampleModalClose">
                          <i class="fa fa-plus-circle"></i>
                        </button>
                      </div>
                    </div>



                    <!-- <div class="col-md-3">
                      <label for="desde"> الحساب </label>
                      <input style="background-color: beige;" type="text" class="form-control"
                        id="modal_reporte_venta_inicio" v-model="account"
                        onkeypress="return controltag(event)" />
                    </div> -->




                    <div class="col-md-3">
                      <label for="desde"> التأريخ </label>
                      <input style="background-color: beige;" type="text" class="form-control hasDatepicker"
                        id="modal_reporte_venta_inicio" name="modal_reporte_venta_inicio" v-model="date"
                        onkeypress="return controltag(event)" />
                    </div>

                    <div class="col-md-2 mt-4">

                      <a href="javascript:void" @click="close()" class="btn btn-primary"><span>اقفال الارباح والخسائر
                        </span></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال المخزون</span>
            </div>
          </div>
          <div class="card-body" id="printme">

            <div class="row">
              <div class="col-md-4">
                <label> طريقه الاقفال</label>


                <select class="form-control" style="background-color: beige;" name="forma_pago"
                  id="select_account_Sale">

                </select>


              </div>
              <div class="col-md-6 mt-4">

                <a href="javascript:void" @click="addDaily()" class="btn btn-primary"><span>اقفال المخزون
                  </span></a>
              </div>
            </div>


          </div>
        </div>
      </div>

    </div>
    <!-- <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
   

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال الحسابات</span>
            </div>
          </div>
          <div class="card-body" id="printme">

            <div class="row row-sm">
              <div class="col-xl-12">
                <div class="card">

                  <div class="card-body" id="printme">


                    <div class="col-sm-12">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          نقل الادخالات الاساسيه من الفترات السابقه
                        </label>
                      </div>

                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          المحاسبه الماليه
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="" checked>
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          الاصول الثابته </label>
                      </div>
                      <div class="checkbox disabled">
                        <label>
                          <input type="checkbox" value="" disabled>
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          المخزون </label>
                      </div>
                    </div>


                    <div class="col-sm-12">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
                          الموظفين </label>
                      </div>

                    </div>

                  </div>


             

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div> -->

    <div class="modal fade" :id="'exampleModalClose'" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" :id="'treeview_json_account'">
            </div>

          </div>

        </div>
      </div>
    </div>


  </div>
</template>
<script>
import tree from '../../../../tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {


      value_list: {
        type: Object,
        default: null,
      },
      counts: {},

      date: new Date().toISOString().substr(0, 10),

      table: '',
      type: '',

      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),

      // -----------------------------------------
      count: 1,
      daily_date: "2021-11-24",
      daily_id: '',
      trees: "",
      account: [],
      account_name: [],
      description: [],
      debit: [],
      credit: [],
      jsonTreeData: '',
      type_of_tree: 1,
      // indexselected: '',
      // indexselectedaccount: '',

      last_nodes: '',

      index: 0,


    };
  },
  mounted() {
    this.list();
    this.type = 'Close';
    this.counts[0] = 1;
    this.type_of_tree = 1;
    this.showtree('account', 'tree_account');




  },

  methods: {

    list() {

      this.axios
        .post(`/daily`)
        .then(({ data }) => {
          console.log('daily', data.daily_details.data);
          this.value_list = data.daily_details;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


    close() {

      this.axios
        .post("/daily_close", {

          daily_date: this.daily_date,
          account_id: this.account,

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

      // this.$router.go(-1);
    },
  },
};
</script>
