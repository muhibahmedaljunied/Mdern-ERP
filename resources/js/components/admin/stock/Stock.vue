<template>
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <span class="h2"> المخزون</span>



            </div>

            <div class="card-body">
                <div class="row row-sm">
                    <div class="col-xl-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="container">
                                    <div class="row justify-content-left">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- <div class="container">
                  <div class="well" id="treeview_json_product"></div>
                </div> -->

                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="input-group">
                                                                    <input style="background-color: azure;" type="text"
                                                                        id="ricerca-enti" class="form-control"
                                                                        placeholder="بحث"
                                                                        aria-describedby="search-addon" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-xs-12" id="treeview_json_product">
                                                                <div id="test"></div>
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
                    </div>
                    <div class="col-xl-12">
                        <div class="card">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="wd-5p border-bottom-0">
                                                    الرقم التسلسلي </th>
                                                <th class="wd-10p border-bottom-0">
                                                    المنتج
                                                </th>
                                                <th class="wd-15p border-bottom-0">
                                                    الباركود
                                                </th>
                                                <th class="wd-5p border-bottom-0">
                                                    الحاله
                                                </th>
                                                <th class="wd-5p border-bottom-0">المواصفات والطراز</th>
                                                <th class="wd-5p border-bottom-0">
                                                    المخزن
                                                </th>

                                                <th class="wd-5p border-bottom-0">
                                                    الكميه المتوفره
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(stock, index) in stocks" :key="index">

                                                <td>{{ index + 1 }}</td>
                                                <td>


                                                    <div>
                                                        <input type="hidden" v-model="stock.text" id="desc"
                                                            class="form-control" />

                                                        <span>{{ stock.product }}</span>
                                                        <span style="color: blue;" v-if="stock.kk"
                                                            v-for="ss in stock.kk">


                                                            -{{ ss.value }}





                                                        </span>
                                                    </div>




                                                </td>
                                                <td></td>

                                                <td>{{ stock.status }}</td>
                                                <td>{{ stock.desc }}</td>

                                                <td>{{ stock.store }}</td>

                                                <td>
                                                    <div v-for="temx in stock
                                                        .qty_after_convert[
                                                        'quantity'
                                                    ]">
                                                        <span v-for="temx2 in temx">
                                                            <span style="float: right">
                                                                {{ temx2[0] }}
                                                                <span style="color: red">
                                                                    {{ temx2[1] }}
                                                                </span>
                                                            </span>
                                                        </span>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <pagination align="center" :data="stocks" @pagination-change-page="list"></pagination>
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
import operation from "../../../operation.js";
import tree from "../../../../js/tree/tree.js";
import VueBarcode from '@chenfengyuan/vue-barcode';

export default {
    mixins: [operation, tree],

    components: {

        VueBarcode,
        pagination
    },
    data() {
        return {
            // stocks: {
            //     type: Object,
            //     default: null,
            // },


            stocks: '',
            word_search: "",
            trees: "",
        };
    },
    mounted() {
        this.type = "Stock";
        this.type_of_tree = 0;

        this.list();
    },
    created() {
        this.showtree("product", "tree_product");
    },
    methods: {
        // get_search(word_search) {
        //     this.axios
        //         .post(`/stocksearch`, { word_search: this.word_search })
        //         .then(({ data }) => {
        //             this.stocks = data;
        //         });
        // },
        list() {
            this.axios
                .post(`/stock`, {
                    type_qty: this.type,
                    operation: "StockQty",
                })
                .then(({ data }) => {
                    this.stocks = data.stocks;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
    },
};
</script>
