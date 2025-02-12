<template>
  <div class="container-fluid">

    <div class="card">

      <div class="card-header">

<div class="pull-right">
  <h3>كشف حساب عميل <span id="codigo"></span></h3>
</div>

</div>


<div class="card-body">

  <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
     
          <div class="card-body">


            <div class="row">


              <div class="col-md-4">
                <label for="cliente"> العميل</label>

                <select v-model="customer" id="supplier" class="form-control">
                  <option v-for="sup in customers" v-bind:value="[sup.id, sup.name]">
                    {{ sup.name }}
                  </option>
                </select>
              </div>

              <div class="col-md-2">
                <label for="date"> من تاريخ </label><br />

                <input name="date" type="date" v-model="date" class="form-control" />
              </div>
              <div class="col-md-2">
                <label for="date"> الي تاريخ </label><br />

                <input name="date" type="date" v-model="date" class="form-control" />
              </div>
              <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div>

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


            <div class="pull-right">
              <h3> التفاصيل <span id="codigo"></span></h3>
            </div>


          </div>
          <div class="card-body">



            <div class="row" style="font-size: 10pt">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-large"
                    id="lista_productos_temporal">
                    <thead>
                      <tr>


                        <th>التاريخ</th>
                        <th>البيات</th>
                        <th>داين</th>
                        <th>مدين</th>

                        <th>الرصيد</th>




                      </tr>
                    </thead>
                    <tbody v-if="sales">

                      <tr v-for="temporales in sales.sales">



                        <template v-if="temporales.id">


                          <td>{{ temporales.created_at }}</td>
                          <td> <span style="color:red">فاتوره بيع رقم </span> {{
                            temporales.id }}


                          </td>
                          <td>{{ temporales.credit }}
                          </td>
                          <td>{{ temporales.debit }}</td>
                   

                          <td>
                            {{ temporales.total }}

                            <input type="hidden" v-model="temporales.total">
                          </td>
                        </template>


                      </tr>

                      <tr v-for="temporales2 in sales.receivable_notes">
                        <td>
                          {{ temporales2.date }}

                        </td>
                        <td>

                          <span style="color:red"> سند قبض رقم </span> {{
                            temporales2.id
                          }}
                        </td>
                        <td>{{ temporales2.credit }}
                        </td>
                        <td>{{ temporales2.debit }}</td>
                        

                        <td>
                          {{ temporales2.total }}

                          <input type="hidden" v-model="temporales2.total">
                        </td>

                      </tr>



                      <tr>
                        <td align="center" colspan="2" style="color:red;font-size:30px;">
                          الاجمالي
                        </td>
                        <td>


                          <span style="color:green;font-size:30px;">{{
                            sales.total_debit }}</span>

                        </td>
                        <td>


                          <span style="color:green;font-size:30px;">{{
                            sales.total_credit }}</span>

                        </td>
                        <td>


                          <span v-if="sales.total > 0" style="color:green;font-size:30px;">{{ sales.total
                            }}</span>
                          <span v-else style="color:red;font-size:30px;">{{
                            sales.total }}</span>

                        </td>
                      </tr>


                    </tbody>
                  </table>
                </div>
                <pagination align="center" :data="sales" @pagination-change-page="onwaychange">
                </pagination>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/div-->
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
  mixins: [operation],
  data() {
    return {

      xx: '',
      text_message: '',
      type: '',

      count: 1,
      counts: {},



      check_state: [],



      total_quantity: 0,
      grand_total: 0,
      sub_total: 0,


      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',
      date: new Date().toISOString().substr(0, 10),

      temporale: 1,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,



      detail: '',
      id: '',
      sales: '',






    }
    // return data;
  },

  mounted() {
    this.list();
    this.counts[0] = 0;
    this.type = 'Purchase';
    this.type_refresh = 'increment';


  },

  methods: {
    

    //   get_search() {
    //     this.axios
    //       .post(`/purchase/newsalesearch`, { word_search: this.word_search })
    //       .then(({ data }) => {
    //         this.temporales = data.temporales;

    //         this.temporale.forEach((item) => {
    //           this.total_quantity = item.tem_qty + this.total_quantity;
    //         });

    //         this.products = data.products;
    //         this.suppliers = data.suppliers;

    //         // this.stores = data;
    //       });
    //   },
    list(page = 1) {
      this.axios
        .post(`/sale/newsale?page=${page}`)
        .then(({ data }) => {
          this.customers = data.customers;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    onwaychange(page = 1) {



      this.axios.post(`/customer/customer_account_list/${this.customer[0]}?page=${page}`).then(({ data }) => {
        console.log(data.sales)
        this.sales = data.sales;





      });


    },

    



  },
};
</script>
