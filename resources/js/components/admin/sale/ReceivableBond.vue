<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                  <span class="h2"> سند قبض</span>
                </div>



              </div>
              <div class="card-body">

                <div class="row">

                  <!-- 
                  <div class="col-md-4">
                    <h5 class="card-title">رقم الحساب</h5>
                    <div class="custom-search">

                      <input :id="'ReceivableBond_account_tree_id'" type="text" readonly class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalReceivableBond">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div> -->

                  <div class="col-md-2">


                    <label for="date">رقم الفاتوره</label><br />


                    <div>{{ details.data[0].paymentable.id }}</div>


                  </div>
                  <div class="col-md-2">
                    <label for="FormaPago">طريقه الدفع</label>
                    <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                      v-model="Way_to_pay_selected" v-on:change="onwaychange">

                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="3">بنك</option>
                    </select>
                  </div>
                </div>

                <br>
                <hr>
                <div class="row">
                  <div class="col-md-4">
                    <h5 class="card-title"> الحساب</h5>
                    <div class="custom-search">

                      <input style="background-color: beige;" :id="'ReceivableBond_account_tree'" type="text" readonly
                        class="custom-search-input">

                      <input :id="'ReceivableBond_account_tree_id'" type="hidden" readonly class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalReceivableBond">
                        <i class="fa fa-plus-circle"></i></button>



                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="cliente"> الحساب التفصيلي</label>


                    <select class="form-control" style="background-color: beige;" name="forma_pago"
                      id="select_account_ReceivableBond_group">

                    </select>

                  </div>
                  <div class="col-md-4">
                    <h5 class="card-title">العمله</h5>
                    <div class="custom-search">

                      <select class="form-control" style="background-color: beige;" name="forma_pago">

                      </select>

                    </div>
                  </div>

                </div>

                <br>
                <hr>
                <div class="row">




                  <div class="col-md-3"><label for="pagoPrevio">البيان</label>
                    <input v-model="description" type="text" class="form-control" style="background-color: beige;">
                  </div>



                  <div class="col-md-2">
                    <label for="pagoPrevio">التاريخ</label>
                    <input v-model="date" type="date" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />

                  </div>
                </div>
                <br>

                <hr>

                <div class="row">

                  <div class="col-md-4">
                    <label for="pagoPrevio">العميل</label>
                    <input type="text" v-model="details.data[0].paymentable.customer.name"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />
                    <!-- 
                    <input type="hidden" v-model="details.data[0].paymentable.customer.id"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />
                    <input type="hidden" v-model="details.data[0].paymentable.customer.group.group_account.account_id"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                    <input type="hidden" v-model="details.data[0].paymentable.id"
                      class="form-control input_cantidad" onkeypress="return valida(event)" /> -->

                  </div>

                  <div class="col-md-2">
                    <label for="pagoPrevio">المبلغ المدفوع</label>
                    <input @input="credit(details.data[0].paid)" v-model="details.data[0].paid"
                      style="background-color: beige;" type="number" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />

                  </div>
                  <div class="col-md-2">
                    <label for="pagoPrevio">المبلغ المتبقي</label>
                    <input v-model="details.data[0].remaining" style="background-color: beige;" type="number"
                      class="form-control input_cantidad" onkeypress="return valida(event)"  readonly/>

                  </div>




                  <div class="col-md-4">

                    <button @click="payment()" class="btn btn-info">تاكيد
                      العمليه</button>


                  </div>
                </div>
                <br>
                <hr>

              </div>
            </div>
          </div>
        </div>


      </div>
    </section>

    <div class="modal fade" id="exampleModalReceivableBond" tabindex="-1" role="dialog"
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

  </div>
</template>
<script>
import operation from '../../../operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [operation,tree],
  data() {
    return {
      jsonTreeData: '',
      type_of_tree: 1,
      details: '',
      remaining: '',
      date: '',
      description: '',
      treasury: [],
    };
  },
  props: ['data'],
  mounted() {

    this.list();

    this.type = 'ReceivableBond';
    this.type_of_tree = 1;
    this.showtree('account', 'tree_account');

    // console.log(this.$route.params);

  },

  methods: {

    list(page = 1) {
      let uri = `/data_for_receivable_bond/${this.data}`;
      this.axios.post(uri).then((response) => {

        console.log(response.data.list_data);
        this.details = response.data.list_data;
        this.remaining = this.details.data[0].remaining;

      });
    },

    onwaychange(e) {
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {

        this.remaining = this.grand_total;
        this.paid = 0;
      }


      if (input.value == 1) {
        this.paid = this.grand_total;
        this.remaining = 0;
      }

      if (input.value == 3) {
        this.paid = this.grand_total;
        this.remaining = 0;
      }
    },
    credit(paid) {


      var remaining = this.remaining - paid;

      if (remaining < 0) {

        this.details.data[0].remaining = 0
      } else {

        this.details.data[0].remaining = remaining

      }

    },

    payment() {

      console.log('yes sale', 
      this.details.data[0].paymentable.customer.group.group_account[0].account_id);
      this.axios
        .post(`/store_ReceivableBond`, {
          type: 'ReceivableBond',


          remaining: this.details.data[0].remaining,
          date: this.date,
          description: this.description,
          // sale_id: this.details.data[0].sale_id,
          paid: this.details.data[0].paid,
          grand_total: this.details.data[0].paid,
          id: this.details.data[0].paymentable.id,

          debit: {
            account_id: $(`#ReceivableBond_account_tree_id`).val(),
            value: this.details.data[0].paid,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          credit: {
            account_id: this.details.data[0].paymentable.customer.group.group_account[0].account_id,
            value: this.details.data[0].paid,
            account_details: this.details.data[0].paymentable.customer.id,

          },
          daily_index: 1,
          payment_type: this.Way_to_pay_selected,
          type_daily: 'ReceivableBond',



        })
        .then((response) => {




          // this.$router.go(0);
        });

    },


  },

};
</script>
