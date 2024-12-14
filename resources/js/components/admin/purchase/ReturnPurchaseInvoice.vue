<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">

                <table style="width: 100% ; outline:double;">
                  <thead>
                    <tr>
                      <td rowspan="4" style="text-align: center; line-height: 1px">
                        <h2>الجمهوريه اليمنيه</h2>
                        <br />
                        <h2>وزاره الشباب والرياضه</h2>
                        <br />
                        <!-- <h2>رياسه هيه الاركات</h2>
                        <br />
                        <h2>قياده القوات الجويه والدفاع</h2>
                        <br />
                        <h2>الدراسات والابحاث</h2>
                        <br /> -->
                        <h2>المخازن</h2>
                        <br />
                      </td>
                      <td rowspan="4" style="text-align: center; line-height: 1px">
                        <img :src="`/assets/img/images3.jpg`" height="150px" alt="products image" />
                      </td>
                      <td rowspan="4" style="text-align: center; line-height: 1px">
                        <h2>رقم السند :{{ return_purchases[0].purchase_id }}</h2>
                        <br />

                        <h2>تاريخ السند :{{ return_purchases[0].date }}</h2>
                        <br />

                        <h2>
                          اسم المورد : {{ return_purchases[0].name }}
                          {{ return_purchases[0].last_name }}

                        </h2>
                        <br />
                      </td>
                    </tr>
                    <tr></tr>

                    <tr></tr>
                    <tr>
                      <td colspan="1"></td>

                      <td style="text-align: left">
                        <button @click="printDiv('printme')">
                          <i class="fas fa-print" style="font-size: 24px; color: rgb(34, 192, 60)"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1"></td>

                      <td style="
                          text-align: center;
                          border-radius: 10px;
                          background-color: red;
                        ">
                        <h1> فاتوره مرتجع مشتريات</h1>
                      </td>
                      <td></td>
                    </tr>
                  </thead>

                </table>
              </div>
              <div class="card-body">
                <table class="table table-bordered text-right" style="width: 100%">
                  <thead style="background:red">
                    <tr>
                      <th>اسم المنتج</th>
                      <th>الحاله</th>
                      <!-- <th class="wd-15p border-bottom-0">الكميه </th> -->
                      <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                      <th>المخزن</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="return_details in purchase_detail">
                      <td>{{ return_details.product }}</td>
                      <td>{{ return_details.status }}</td>
                      <!-- <td>{{ return_details.qty }}</td> -->
                      <!-- <td>{{ return_details.qty_return }}</td> -->
                      <div v-for="temx in return_details.qty_after_convert['qty']">



                        <span v-for="temx2 in temx">


                          <span style="float: right;">
                            {{ temx2[0] }}
                            <span style="color: red;">
                              {{ temx2[1] }}
                            </span>

                          </span>



                        </span>

                        <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                      </div>

                      <td>{{ return_details.store }}</td>

                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="7"> الاجمالي:{{ return_purchases[0].sub_total }}</th>


                    </tr>
                    <tr>
                      <th colspan="7"> اجمالي الضريبه:{{ return_purchases[0].tax_amount }}</th>


                    </tr>
                    <tr>

                      <th colspan="7"> الخصم:{{ return_purchases[0].discount }}</th>


                    </tr>
                    <tr style="background-color: aqua;">

                      <th colspan="7"> الاجمالي الكلي:{{ return_purchases[0].grand_total }}</th>


                    </tr>

                  </tfoot>
                </table>
                <div id="intro" style="text-align:left;">
                  <h5>{{ timestamp }}</h5>
                </div>
                <div id="intro" style="text-align:right;">
                  <h5>امين المخازن:{{ user }}</h5>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {


      purchase_detail: {
        type: Object,
        default: null,
      },
      return_purchases: {
        type: Object,
        default: null,
      },

      timestamp: "",
      user: "",
      table: 'purchase_return_details',
    };
  },
  created() {
    setInterval(this.getNow, 1000);
  },
  props: ['data'],
  mounted() {
    let uri = `/return_purchase_invoice/${this.data}`;
    this.axios.post(uri,{ id:this.data,table: this.table }).then((response) => {
      console.log('ddddddddrerererer', response.data);
      this.user = response.data.users.name;
      this.purchase_detail = response.data.purchase_return_details;
      this.return_purchases = response.data.purchase_returns;



    });
  }
};
</script>
<style scoped>
.table-bordered {
  border: 2px solid black;
}

.table-bordered th,
.table-bordered td {
  border: 2px solid black;
  text-align: center;
  font-size: 40px;
}

td h2 {
  line-height: 20px;
}
</style>