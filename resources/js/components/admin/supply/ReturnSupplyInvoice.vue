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
                                                <img :src="`/assets/img/images3.jpg`" height="150px"
                                                    alt="products image" />
                                            </td>
                                            <td rowspan="4" style="text-align: center; line-height: 1px">
                                                <h2>رقم السند :{{ return_supplies[0].supply_id }}</h2>
                                                <br />

                                                <h2>تاريخ السند :{{ return_supplies[0].supply_date }}</h2>
                                                <br />

                                                <h2>
                                                    اسم المورد : {{ return_supplies[0].name }}
                                                    {{ return_supplies[0].last_name }}

                                                </h2>
                                                <br />
                                            </td>
                                        </tr>
                                        <tr></tr>

                                        <tr></tr>
                                        <tr>
                                            <td colspan="1"></td>

                                            <td style="text-align: left">
                                                <button @click="report_style('printme', '')">
                                                    <i class="fas fa-print"
                                                        style="font-size: 24px; color: rgb(34, 192, 60)"></i>
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
                                                <h1> سند مرتجع توريد</h1>
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

                                            <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                                            <th>المخزن</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="return_details in supply_detail">
                                            <td>


                                                <div>
                                                    <input type="hidden" v-model="return_details.product_name" id="desc"
                                                        class="form-control" />

                                                    <span>{{ return_details.product_name }}</span>
                                                    <span style="color: blue;" v-if="return_details.kk"
                                                        v-for="ss in return_details.kk">


                                                        -{{ ss.value }}





                                                    </span>
                                                </div>


                                            </td>
                                            <td>{{ return_details.name }}</td>

                                            <td>
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
                                            </td>
                                            <td>{{ return_details.text }}</td>

                                        </tr>
                                    </tbody>
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
import InvoiceOperation from '../../../../js/InvoiceOperation.js';
export default {
    mixins: [InvoiceOperation],
    data() {
        return {

            supply_detail: {
                type: Object,
                default: null,
            },
            return_supplies: {
                type: Object,
                default: null,
            },

            timestamp: "",
            user: "",
        };
    },
    created() {
        setInterval(this.getNow, 1000);
    },
    props: ['data'],
    mounted() {
        this.table = 'supply_return_details';
        let uri = `/invoice_return_supply/${this.data}`;
        this.axios.post(uri, { id: this.data, table: this.table }).then((response) => {
            this.user = response.data.users.name;
            this.return_supplies = response.data.supply_returns;
            this.supply_detail = response.data.supply_return_details;
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
