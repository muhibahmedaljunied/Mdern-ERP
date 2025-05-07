<template>
    <div>
        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header pb-0">

                        <div class="d-flex justify-content-right">
                            <span class="h2"> مردود المشتريات</span>
                        </div>
                    </div>


                    <!-- <div class="d-flex justify-content-right">


            <div class="form-group">
              <input type="search" autocomplete="on" name="search" role="button" placeholder="بحث  بالرقم"
                v-model="word_search" @input="get_search()" />
            </div>
          </div> -->

                    <div class="card-body">


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
                                        <label for="inputAddress">المورد</label>
                                        <select style="background-color: beige;" v-model="supplier" class="form-control"
                                            required>
                                            <option v-for="supplier in suppliers" v-bind:value="supplier.id">
                                                {{ supplier.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 col-md-3">

                                        <label for="inputAddress">بحث</label>
                                        <br>
                                        <a href="#">

                                            <i class="fa-solid fa-magnifying-glass fa-2xl" style="color: #74C0FC;"></i>


                                        </a>


                                    </div>
                                </div>

                            </div>
                        </div>




                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                                                <!-- <th class="wd-15p border-bottom-0">رقم التوريد</th> -->
                                                <th class="wd-15p border-bottom-0">رقم السند</th>
                                                <!-- <th class="wd-15p border-bottom-0">المورد</th> -->
                                                <!-- <th class="wd-15p border-bottom-0"> الكميه المردوده</th> -->
                                                <th class="wd-15p border-bottom-0">الفرع</th>
                                                <th class="wd-15p border-bottom-0">تاريخ المردود</th>
                                                <th class="wd-15p border-bottom-0">سبب الارجاع </th>

                                                <th class="wd-15p border-bottom-0">العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="return_purchases && return_purchases.data.length > 0">
                                            <tr v-for="(return_purchase, index) in return_purchases.data" :key="index">

                                                <td>
                                                    {{ index + 1 }}
                                                </td>
                                                <td>{{ return_purchase.id }}</td>
                                                <td></td>
                                                <td>{{ return_purchase.date }}</td>
                                                <td>{{ return_purchase.note }}</td>
                                                <td>


                                                    <div class="optionbox">

                                                        <select @change="changeRoute(index)"
                                                            v-model="operationselected[index]" name="العمليات"
                                                            class="form-control">
                                                            <option class="btn btn-success"
                                                                v-bind:value="['/returnpurchase_details/', return_purchase.id, 0]">
                                                                تفاصيل
                                                            </option>


                                                            <option class="btn btn-success"
                                                                v-bind:value="['return_purchase_invoice', return_purchase.id, 1]">
                                                                سند مردود شراء
                                                            </option>
                                                            <option class="btn btn-success"
                                                                v-bind:value="['/return_purchase_recive/', return_purchase.id, 2]">
                                                                سند استلام مردود شراء
                                                            </option>
                                                            <option class="btn btn-success"
                                                                v-bind:value="['/return_purchase_invoice_cancel/', return_purchase.purchase_id, 3]">
                                                                الفاء الفاتوره
                                                            </option>
                                                            <option class="btn btn-success"
                                                                v-bind:value="['/return_purchase_invoice_update/', return_purchase.purchase_id, 4]">
                                                                تعديل الفاتوره
                                                            </option>
                                                            <option class="btn btn-success"
                                                                v-bind:value="['return_purchase_daily', return_purchase.id, 5]">
                                                                عرض القيد المحاسبي
                                                            </option>

                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="8">
                                                    <h3>
                                                        لايوجد اي مردود مشتريات
                                                    </h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <pagination align="center" :data="return_purchases" @pagination-change-page="list">
                                </pagination>
                            </div>
                        </div>



                        <div class="card">
                            <div class="card-header pb-0">

                                <span class="h2">تفاصيل مردود الشراء</span>
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
                                                <th class="wd-15p border-bottom-0"> الكميه المردوده</th>
                                                <th class="wd-15p border-bottom-0">المخزن</th>



                                            </tr>
                                        </thead>
                                        <tbody v-if="return_detail && return_detail.length > 0">
                                            <tr v-for="(return_details, index) in return_detail" :key="index">
                                                <td>{{ index + 1 }}</td>
                                                <!-- <td>{{ return_details.supply_return_id }}</td> -->

                                                <td>


                                                    <div>
                                                        <input type="hidden" v-model="return_details.text" id="desc"
                                                            class="form-control" />

                                                        <span>{{ return_details.text }}</span>
                                                        <span style="color: blue;" v-if="return_details.kk"
                                                            v-for="ss in return_details.kk">


                                                            -{{ ss.value }}





                                                        </span>
                                                    </div>




                                                </td>
                                                <td>{{ return_details.status }}</td>
                                                <td>{{ return_details.desc }}</td>
                                                <!-- <td>{{ return_details.qty_return }}</td> -->

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
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="5">
                                                    <h3>لايوجد اي تفاصبل</h3>
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
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../operation.js';
export default {
    mixins: [operation],
    components: {
        pagination,
    },
    data() {
        return {
            return_purchases: {
                type: Object,
                default: null,
            },
            word_search: "",
            operationselected: [],
            return_detail: '',
            table: '',


        };
    },
    props: ['data'],

    mounted() {

        this.table = 'purchase_return_details';

        this.list();
    },
    methods: {
        changeRoute(index) {


            // alert(index);
            console.log(this.operationselected[index][0]);


            if (this.operationselected[index][2] == 0) {

                this.axios
                    .post(this.operationselected[index][0] + this.operationselected[index][1], {
                        table: this.table,
                        operation: 'OperationQty'

                    })
                    .then((response) => {
                        console.log(response.data.return_details);
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
        get_search(word_search) {
            this.axios
                .post(`/listreturn_purchasesearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    this.return_purchases = data.return_purchases;

                    // this.$root.logo = "Category";
                });
        },
        list(page = 1) {

            if (this.data) {

                this.axios
                    .post(`/listreturn_purchase/${this.data}`)
                    .then(({ data }) => {
                        console.log(data.returns);
                        this.return_purchases = data.returns;
                        // this.suppliers =data.suppliers;

                    })
                    .catch(({ response }) => {
                        console.error(response);
                    });

            } else {

                this.axios
                    .post(`/listreturn_purchase`)
                    .then(({ data }) => {
                        console.log(data.returns);
                        this.return_purchases = data.returns;

                    })
                    .catch(({ response }) => {
                        console.error(response);
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
