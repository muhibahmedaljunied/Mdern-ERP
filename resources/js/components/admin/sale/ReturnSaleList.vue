<template>
    <div>
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">

                        <span class="h2"> مردود مبيعات</span>
                    </div>
                    <div class="card-body">

                        <div class="row">

                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <!-- <div class="col-md-2">
                      <label for="inputAddress">الفرع</label>
                      <select style="background-color: beige;" v-model="branchselected" class="form-control" required>
                        <option v-for="branch in branches" v-bind:value="branch.id">
                          {{ branch.name }}
                        </option>
                      </select>
                    </div> -->
                                        <div class="col-md-2">
                                            <label for="inputAddress">العميل</label>
                                            <select style="background-color: beige;" v-model="branchselected"
                                                class="form-control" required>
                                                <option v-for="branch in branches" v-bind:value="branch.id">
                                                    {{ branch.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6 col-md-3">

                                            <label for="inputAddress">بحث</label>
                                            <br>
                                            <a href="#">

                                                <i class="fa-solid fa-magnifying-glass fa-2xl"
                                                    style="color: #74C0FC;"></i>


                                            </a>


                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="row">

                            <div class="card">

                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table text-md-nowrap" id="example1">
                                            <thead>
                                                <tr>
                                                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                                                    <th class="wd-15p border-bottom-0">رقم السند</th>
                                                    <!-- <th class="wd-15p border-bottom-0">العميل</th> -->
                                                    <!-- <th class="wd-15p border-bottom-0">الكميه</th> -->
                                                    <!-- <th class="wd-15p border-bottom-0">الفرع</th> -->
                                                    <th class="wd-15p border-bottom-0">تاريخ المردود</th>
                                                    <th class="wd-15p border-bottom-0">سبب الارجاع </th>
                                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="return_sale && return_sale.data.length > 0">
                                                <tr v-for="(return_sales, index) in return_sale.data">
                                                    <td>
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td>{{ return_sales.id }}</td>
                                                    <!-- <td>{{ return_sales.customer_name }}</td> -->

                                                    <!-- <td>{{ return_sales.quantity_return }}</td> -->

                                                    <!-- <td></td> -->
                                                    <td>{{ return_sales.date }}</td>
                                                    <td>{{ return_sales.note }}</td>
                                                    <td>




                                                        <div class="optionbox">
                                                            <select @change="changeRoute(index)"
                                                                v-model="operationselected[index]" name="العمليات"
                                                                class="form-control">
                                                                <option class="btn btn-success"
                                                                    v-bind:value="['/returnsale_details/', return_sales.id, 0]">
                                                                    تفاصيل
                                                                </option>


                                                                <option class="btn btn-success"
                                                                    v-bind:value="['return_sale_invoice', return_sales.id, 1]">
                                                                    سند مردود مبيعات
                                                                </option>
                                                                <option class="btn btn-success"
                                                                    v-bind:value="['return_sale_recive', return_sales.id, 2]">
                                                                    سند استلام مردود مبيعات
                                                                </option>
                                                                <option class="btn btn-success"
                                                                    v-bind:value="['/return_sale_invoice_cancel/', return_sales.sale_id, 3]">
                                                                    الفاء الفاتوره
                                                                </option>
                                                                <!-- <option class="btn btn-success"
                            v-bind:value="['/return_sale_invoice_update/', return_sales.sale_id, 4]">
                            تعديل الفاتوره
                          </option> -->
                                                                <option class="btn btn-success"
                                                                    v-bind:value="['return_sale_daily', return_sales.id, 5]">
                                                                    عرض القيد المحاسبي
                                                                </option>

                                                            </select>
                                                        </div>



                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header pb-0">

                                        <span class="h2">تفاصيل مردود المبيعات</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table text-md-nowrap" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                                                        <!-- <th class="wd-15p border-bottom-0">رقم المردود</th> -->
                                                        <th class="wd-15p border-bottom-0">المنتج</th>
                                                        <th class="wd-15p border-bottom-0">الحاله</th>
                                                        <th>المواصفات والطراز</th>
                                                        <th class="wd-15p border-bottom-0">الكميه</th>
                                                        <th class="wd-15p border-bottom-0">المخزن</th>

                                                    </tr>
                                                </thead>

                                                <tbody v-if="return_detail && return_detail.length > 0">
                                                    <tr v-for="return_details in return_detail">
                                                        <!-- <td>{{ return_details.supply_return_id }}</td> -->
                                                        <td>
                                                            {{ index + 1 }}
                                                        </td>
                                                        <td>


                                                            <div>
                                                                <input type="hidden" v-model="return_details.product_name"
                                                                    id="desc" class="form-control" />

                                                                <span>{{ return_details.product_name }}</span>
                                                                <span style="color: blue;" v-if="return_details.kk"
                                                                    v-for="ss in return_details.kk">


                                                                    -{{ ss.value }}





                                                                </span>
                                                            </div>




                                                        </td>
                                                        <td>{{ return_details.name }}</td>
                                                        <td>{{ return_details.desc }}</td>
                                                        <!-- <td>{{ return_details.qty_return }}</td> -->
                                                        <td>


                                                            <div
                                                                v-for="temx in return_details.qty_after_convert['qty']">



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
                                                <tbody v-else>
                                                    <tr>
                                                        <td align="center" colspan="3">
                                                            <h3>لايوجد اي مردودات</h3>
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

        </div>

    </div>
</template>
<script>
import operation from '../../../operation.js';
export default {
    mixins: [operation],
    data() {
        return {
            return_sale: "yes",
            return_detail: '',
            operationselected: [],
            type: '',
            index: '',
        };
    },
    props: ['data'],

    mounted() {

        this.table = 'sale_return_details';


        if (this.data) {

            this.axios.post(`/listreturn_sale/${this.data}`).then(({ data }) => {
                this.return_sale = data.returns;

            });

        } else {

            this.axios.post(`/listreturn_sale`).then(({ data }) => {
                this.return_sale = data.returns;
                // this.customers = data.customers;

            });

        }

    },
    methods: {
        changeRoute(index) {

            console.log('dfdfdfdf', this.operationselected[index][0], this.operationselected[index][1]);

            if (this.operationselected[index][2] == 0) {

                this.axios
                    .post(this.operationselected[index][0] + this.operationselected[index][1], {
                        table: this.table, operation: 'OperationQty'
                    })
                    .then((response) => {

                        this.return_detail = response.data.return_details;

                    })
                    .catch(({ response }) => {
                        console.error(response);
                    });

            } else {

                // this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);

                this.$router.push({
                    name: this.operationselected[index][0],
                    params: { data: this.operationselected[index][1] },
                });

            }

        },

    },
};
</script>

<style scoped>
.optionbox select {
    background: #E62968;
    color: #fff;
    padding: 10px;
    width: 120px;
    height: 30px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 18px rgb(93, 15, 9);
    outline: none;
}
</style>
