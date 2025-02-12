<template>
    <div class="container-fluid">

        <div class="card">

            <div class="card-header">
                        <!-- <span class="h2"> المخزون</span> -->

                        <div class="pull-right">
                            <h3>كشف حساب مورد <span id="codigo"></span></h3>
                        </div>


                    </div>


                    <div class="card-body">
                        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
              
                    <div class="card-body">

                        <div class="row">


                            <div class="col-md-4">
                                <label for="cliente">المورد </label>

                                <select v-model="supplier" id="supplier" class="form-control">
                                    <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
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
                                <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt=""
                                        style="width: 10%;"> </a>
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
                        <!-- <span class="h2"> المخزون</span> -->

                        <div class="pull-right">
                            <h3>التفاصيل<span id="codigo"></span></h3>
                        </div>


                    </div>
                    <div class="card-body">


                        <div class="row" style="font-size: 20px">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-right m-t-30"
                                        style="width: 100%; font-size: x-large" id="lista_productos_temporal">
                                        <thead>
                                            <tr>


                                                <th>التاريخ</th>
                                                <th>البيات</th>
                                                <th>داين</th>
                                                <th>مدين</th>
                                
                                                <th>الرصيد</th>

                                            </tr>
                                        </thead>

                                        <tbody v-if="purchases">

                                            <tr v-for="temporales in purchases.purchases" >



                                              <template v-if="temporales.id">


                                                    <td>{{ temporales.created_at }}</td>
                                                    <td> <span style="color:red">فاتوره شراء رقم </span> {{
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

                                            <tr v-for="temporales2 in purchases.payable_notes">
                                              <td>
                                                    {{ temporales2.date }}

                                                </td>
                                                <td>

                                                    <span style="color:red"> سند صرف رقم </span> {{
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
                                                        purchases.total_debit }}</span>

                                                </td>
                                                <td>


                                                    <span style="color:green;font-size:30px;">{{
                                                        purchases.total_credit }}</span>

                                                </td>
                                                <td>


                                                    <span v-if="purchases.total > 0"
                                                        style="color:green;font-size:30px;">{{ purchases.total
                                                        }}</span>
                                                    <span v-else style="color:red;font-size:30px;">{{
                                                        purchases.total }}</span>

                                                </td>
                                            </tr>
                            

                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="8">
                                                    <h3>
                                                        لايوجد اي بيانات
                                                    </h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <pagination align="center" :data="purchases" @pagination-change-page="onwaychange">
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

            purchases: {
                type: Object,
                default: null,
            },
            date: '',
            supplier: [],
            suppliers: '',


        }
       
    },

    mounted() {
        this.list();




    },

    methods: {
    

        list(page = 1) {


            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {

                this.suppliers = data.suppliers;

            });


        },

        onwaychange(page = 1) {


            this.axios.post(`/supplier/supplier_account_list/${this.supplier[0]}?page=${page}`).then(({ data }) => {
          
                this.purchases = data.purchases;
 




            });


        },
   



    },
};
</script>
