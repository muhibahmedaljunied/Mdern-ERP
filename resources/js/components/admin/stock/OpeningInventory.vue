<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">


                        <h3> <span id="codigo">المخزون الافتتاحي</span></h3>

                        <!-- <h1 class="card-title"> المخزون الافتتاحي</h1> -->
                    </div>

                    <div class="card-body">
                        <div class="row">


                            <div class="card">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="pagoPrevio">المنتج</label>
                                            <div class="custom-search">

                                                <input style="background-color: beige;font-size: 15px;"
                                                    :id="'OpeningInventory_product_tree'" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'OpeningInventory_product_tree_id'" type="hidden" readonly
                                                    class="custom-search-input">
                                                <input :id="'select_account_Purchase'" type="hidden" readonly
                                                    class="custom-search-input">


                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    @click="detect_index(null)" data-target="#exampleModalProduct">
                                                    <i class="fa fa-plus-circle"></i></button>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <label for="pagoPrevio">المخزن</label>
                                            <div class="custom-search">

                                                <input style="background-color: beige;font-size: 15px;"
                                                    :id="'OpeningInventory_store_tree'" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'OpeningInventory_store_tree_id'" type="hidden" readonly
                                                    class="custom-search-input">
                                                <input :id="'select_account_Purchase'" type="hidden" readonly
                                                    class="custom-search-input">


                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    @click="detect_index(null)" data-target="#exampleModalStore">
                                                    <i class="fa fa-plus-circle"></i></button>
                                            </div>

                                        </div>


                                        <div class="col-md-4">
                                            <label> الحساب</label>
                                            <div class="custom-search">

                                                <input :id="'OpeningInventory_account_tree'" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'OpeningInventory_account_tree_id'" type="hidden" readonly
                                                    class="custom-search-input">


                                                <button @click="detect_index(null)" class="custom-search-botton"
                                                    type="button" data-toggle="modal"
                                                    data-target="#exampleModalAccount">
                                                    <i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>











                        </div>


                        <div class="row">


                            <div class="card">

                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-3">
                                            <label for="cliente"> الحساب التفصيلي</label>

                                            <select class="form-control" style="background-color: beige;"
                                                name="forma_pago" id="select_account_Purchase_group">

                                            </select>

                                        </div>


                                        <div class="col-md-4">
                                            <label for="pagoPrevio">البيان</label>


                                            <input class="form-control" style="background-color: beige;" type="text"
                                                v-model="description">


                                        </div>

                                        <div class="col-md-2">
                                            <label for="date">التاريخ</label><br />

                                            <input class="form-control" style="background-color: beige;" name="date"
                                                type="date" v-model="date" />
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>

                        <div class="row">

                            <div class="card text-right">


                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table table-bordered text-right"
                                            style="width: 100%; font-size: x-large">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Code</th> -->
                                                    <th>المنتج</th>
                                                    <!-- <th>المجموعه</th> -->

                                                    <th>الحاله</th>
                                                    <th>الموصفات والطراز</th>
                                                    <th>المخزن</th>
                                                    <th>الوحده</th>
                                                    <th>التكلفه</th>

                                                    <th>الكميه</th>

                                                    <th>الاجمالي</th>
                                                    <th>تاريخ الانتهاء</th>


                                                    <th>اضافه</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="index in count" :key="index">

                                                    <td>





                                                        <div class="custom-search">

                                                            <input :id="'OpeningInventory_productm_tree' + index"
                                                                type="text" readonly class="custom-search-input">
                                                            <input :id="'OpeningInventory_productm_tree_id' + index"
                                                                type="hidden" readonly class="custom-search-input">

                                                            <button class="custom-search-botton" type="button"
                                                                data-toggle="modal" data-target="#exampleModalProductm"
                                                                @click="detect_index(index)"> <i
                                                                    class="fa fa-plus-circle"></i></button>
                                                        </div>


                                                    </td>

                                                    <td>
                                                        <div id="factura_producto">
                                                            <select v-model="status[index]" name="type" id="type"
                                                                class="form-control" required>

                                                                <option v-for="status in statuses"
                                                                    v-bind:value="status.id">
                                                                    {{ status.name }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div id="factura_producto">
                                                            <input type="text" v-model="desc[index]" id="desc"
                                                                class="form-control" />
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <!-- <div id="factura_producto" class="input_nombre">
                             <select v-model="store[index]" name="type" id="type" class="form-control"
                                 required>
                                 <option v-for="store in stores" v-bind:value="store.id">
                                     {{ store.text }}
                                 </option>
                             </select>
                         </div> -->


                                                        <div class="custom-search">

                                                            <input :id="'OpeningInventory_storem_tree' + index"
                                                                type="text" readonly class="custom-search-input">
                                                            <input :id="'OpeningInventory_storem_tree_id' + index"
                                                                type="hidden" readonly class="custom-search-input">

                                                            <button class="custom-search-botton" type="button"
                                                                data-toggle="modal" data-target="#exampleModalStorem"
                                                                @click="detect_index(index)">
                                                                <i class="fa fa-plus-circle"></i></button>
                                                        </div>
                                                    </td>




                                                    <td>
                                                        <!-- <div id="factura_producto">

                                                            <select v-model="unit[index]" name="type"
                                                                :id="'select_unit' + index" class="form-control"
                                                                required>

                                                            </select>
                                                        </div> -->

                                                        <div id="factura_producto">

                                                            <select v-on:change="calculate()"
                                                                style="background-color: beige;" v-model="unit[index]"
                                                                name="type" :id="'select_unit' + index"
                                                                class="form-control" required>

                                                            </select>
                                                        </div>



                                                    </td>


                                                    <td>
                                                        <input type="number" v-model="unit_price[index]"
                                                            class="form-control" />
                                                    </td>

                                                    <td>
                                                        <input @input="calculate()" type="number" v-model="qty[index]"
                                                            id="qty" class="form-control" />
                                                    </td>


                                                    <td>
                                                        <input type="number" @input="calculate()" v-model="total[index]"
                                                            :id="'total_row' + index" class="form-control" />


                                                    </td>

                                                    <td>
                                                        <input name="expiry_date" type="date" v-model="expiry_date"
                                                            class="form-control" />

                                                    </td>




                                                    <td v-if="index == 1">

                                                        <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="addComponent(count)">
                                                            <i class="fa fa-plus-circle"></i></button>

                                                        <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="addComponent(count)">
                                                            <i class="fa fa-minus-circle"></i></button>



                                                    </td>
                                                </tr>

                                                <tr>

                                                    <td colspan="6" style="color: red;">الاجمالي</td>
                                                    <td>
                                                        <input @input="calculate()" type="text" id="cantidad_total"
                                                            v-model="total_quantity" class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input @input="calculate()" type="text" id="subtotal_general"
                                                            name="subtotal_general" v-model="grand_total"
                                                            class="form-control" />
                                                        <input type="hidden" id="subtotal_general_sf"
                                                            name="subtotal_general_sf" value="0.00" />
                                                    </td>
                                                    <td colspan="2">
                                                        <a href="javascript:void" @click="add_opening()"
                                                            class="btn btn-primary"><span>تاكيد
                                                                العمليه</span></a>
                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="row">


                            <div class="card">

                                <div class="card-header">


                                    <div style="display: flex;float: left; margin: 5px">


                                        <button @click="exports_excel()">
                                            <i class="fas fa-file-export" style="font-size: 24px; color: #ee335e"></i>
                                        </button>

                                        <button @click="imports_excel()">
                                            <i class="fas fa-file-import" style="font-size: 24px; color: #22c03c"></i>
                                        </button>

                                        <input type="search" autocomplete="on" name="search" data-toggle="dropdown"
                                            role="button" aria-haspopup="true" aria-expanded="true" placeholder="بحث "
                                            v-model="word_search" @input="get_search()" />
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-right m-t-30"
                                            style="width: 100%; font-size: x-small">
                                            <thead>
                                                <tr>
                                                    <th style="width: 60px">#</th>
                                                    <th style="width: 60px">المنتج</th>
                                                    <th style="width: 60px">المخزن</th>
                                                    <th style="width: 60px">الحاله</th>
                                                    <th style="width: 60px">المواصفات والطراز</th>
                                                    <th style="width: 60px">الكميه </th>
                                                    <th style="width: 60px">التكلفه</th>
                                                    <th style="width: 60px">الاجمالي</th>
                                                    <th style="width: 60px">العمليات</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="opening_inventuries && opening_inventuries.length > 0">
                                                <tr v-for="(opening_inventury, index) in opening_inventuries"
                                                    :key="index">
                                                    <td>{{ index + 1 }}</td>

                                                    <td>{{ opening_inventury.product }}</td>
                                                    <td>{{ opening_inventury.store }}</td>
                                                    <td>{{ opening_inventury.status }}</td>
                                                    <td>{{ opening_inventury.desc }}</td>
                                                    <td>


                                                        <div v-for="temx in opening_inventury.qty_after_convert['qty']">



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

                                                    <!-- <td>{{ purchase_details.qty }} {{ purchase_details.unit }}</td> -->


                                                    <!-- <td>{{ purchase_details.unit }}</td> -->
                                                    <td>{{ opening_inventury.cost }}</td>
                                                    <td>{{ opening_inventury.total }}</td>
                                                    <!-- <td>{{ purchase_details.qty_return }}</td> -->
                                                    <td>
                                                        <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                                                        <button type="button"
                                                            class="btn btn-sm waves-effect btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                        </button>

                                                        <router-link :to="{
                                                            name: 'edit_allowance_types',
                                                            params: { id: opening_inventury.id },
                                                        }" class="edit btn btn-sm waves-effect btn-success">
                                                            <i class="fa fa-edit"></i></router-link>
                                                    </td>


                                                </tr>
                                                <!-- <tr>

                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->

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
                                </div>
                            </div>

                        </div>
                    </div>
                </div>






                <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_product"></div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_store"></div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModalStorem" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_storem"></div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_product"></div>

                            </div>

                        </div>
                    </div>
                </div>


                <div class="modal fade" id="exampleModalProductm" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_productm"></div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModalAccount" tabindex="-1" role="dialog"
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
        </section>
    </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
// import operation from '../../../operation1.js';
import operation from '../../../operation.js';
import tree from '../../../../js/tree/tree.js';
export default {

    components: {
        pagination,
    },

    mixins: [tree, operation],

    data() {

        return {

            opening_inventuries: {
                type: Object,
                default: null,
            },
            description: '',
            all_products: '',
            jsonTreeData: '',
            type_of_tree: 1,
            indexselected: '',
            indexselectedproduct: '',
            indexselectedstore: '',
            last_nodes: '',
            rank: 1,
            parent: 0,
            index: 0,

            statusselected: 0,
            unitselected: 0,
            unitselectedname: '',
            productselected: 0,
            productselectedname: "",
            storeselectedname: "",
            storeselected: 0,
            descselected: "",
            operationselected: 0,
            dateselected: 0,
            typeselected: [],
            checkselected: '',
            moveselected: 0,

        }
    },


    mounted() {
        this.list();
        this.counts[0] = 1;
        this.type = 'OpeningInventory';

        this.type_refresh = 'increment';
        this.type_of_tree = 1;
        this.first_row = 1;
        this.showtree('store', 'tree_store');
        this.showtree('product', 'tree_product');
        this.showtree('storem', 'tree_store');
        this.showtree('productm', 'tree_product');
        this.showtree('account', 'tree_account');












    },

    methods: {



        // get_search() {
        //     this.axios
        //         .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
        //         .then(({ data }) => {
        //             this.products = data.products;
        //         });
        // },

        add_opening() {

            this.axios
                .post("/payOpening", {
                    count: this.counts,
                    date: this.date,
                    product: this.productm,
                    store: this.storem,
                    type: this.type,
                    type_refresh: this.type_refresh,
                    desc: this.desc,
                    qty: this.qty,
                    unit: this.unit,
                    units: this.units,
                    status: this.status,
                    price: this.unit_price,
                    expiry_date: this.expiry_date,
                    total: this.total,
                    // old: this.detail,


                    store: this.storem,
                    description: this.description,
                    type_refresh: this.type_refresh,
                    // -------------this for dailies----------------------------------------------
                    debit: {
                        account_id: this.storem_account,
                        value: this.total,
                        account_details: this.storem,

                    },
                    credit: {

                        account_id: $(`#OpeningInventory_account_tree_id`).val(),
                        value: this.sub_total,
                        account_details: $(`#select_account_${this.type}_group`).val(),

                    },

                    type_daily: 'OpeningInventory',
                    payment_type: this.Way_to_pay_selected,
                    daily_index: 1,
                    // supplier_id: this.supplier[0],
                    // supplier_name: this.supplier[1],
                    date: this.date,
                    // treasury: this.treasury[0],
                    // ------------------------------------------------------------------------------
                    grand_total: this.grand_total,
                    sub_total: this.sub_total,
                    // discount: this.discounts,
                    // total_tax: this.total_tax,
                    // type_payment: this.type_payment,
                    // remaining: this.remaining,
                    paid: this.paid,
                    // ------------------------------------------------------------------------------

                    total_quantity: this.total_quantity,





                })
                .then(function (response) {
                    console.log(response);
                    if (response.data.message != 0) {
                        toastMessage("تمت العمليه بنجاح");
                        this.$router.go(0);
                    } else {
                        toastMessage("فشل", response.data.text);
                    }


                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(-1);
        },
        list(page = 1) {
            this.axios
                .post(`/opening/newopening?page=${page}`, {
                    table: 'opening_inventuries'
                })
                .then(({ data }) => {
                    console.log('data.statuses');

                    // this.opening = data.temporales;
                    this.statuses = data.statuses;
                    this.opening_inventuries = data.details;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        check_data(i = 0) {

            return 1;
        },
        exports_excel() {

            axios
                .post(`/export_opening_inventuries`)
                .then(function (response) {

                    // console.log(1);
                })
                .catch(error => {
                    toastMessage("تم اتمام عمليه التصدير");
                    // this.$router.go(0);

                });
        },
        imports_excel() {

            axios
                .post(`/import_opening_inventuries`)
                .then(function (response) {
                    toastMessage("تم اتمام عمليه الاستيراد");
                    this.$router.go(0);

                    // console.log(1);
                })
                .catch(error => {

                });
        },




    },
};
</script>

<style scoped>
th,
td {
    text-align: center;
}
</style>
