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
                                                <input :id="'select_account_OpeningInventory'" type="hidden" readonly
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
                                                <input :id="'select_account_OpeningInventory'" type="hidden" readonly
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
                                                name="forma_pago" id="select_account_OpeningInventory_group">

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
                                                    <th class="wd-5p border-bottom-0">الرقم التسلسلي</th>
                                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                                    <!-- <th>المجموعه</th> -->
                                                    <th class="wd-5p border-bottom-0">المخزن</th>

                                                    <th class="wd-5p border-bottom-0">الموصفات والطراز</th>
                                                    <th class="wd-10p border-bottom-0">الحاله</th>
                                                    <th class="wd-10p border-bottom-0">الوحده</th>
                                                    <th class="wd-10p border-bottom-0">التكلفه</th>

                                                    <th class="wd-10p border-bottom-0">الكميه</th>

                                                    <th class="wd-15p border-bottom-0">الاجمالي</th>
                                                    <th class="wd-15p border-bottom-0">تاريخ الانتهاء</th>



                                                </tr>
                                            </thead>
                                            <tbody id="show_pro">
                                                <tr v-for="(sto_pro, index) in store_products" :key="index">
                                                    <td>{{ index + 1 }}



                                                    </td>
                                                    <td>


                                                        <div>
                                                            <input type="hidden" v-model="sto_pro.text" id="desc"
                                                                class="form-control" />

                                                            <span>{{ sto_pro.text }}</span>
                                                            <span style="color: blue;" v-if="sto_pro.kk"
                                                                v-for="ss in sto_pro.kk">


                                                                -{{ ss.value }}





                                                            </span>
                                                        </div>


                                                        <!-- <div class="custom-search">

                              <input style="background-color: beige;font-size: 15px;"
                                :id="'Purchase_productm_tree' + index" type="text" readonly class="custom-search-input">
                              <input :id="'Purchase_productm_tree_id' + index" type="hidden" readonly
                                class="custom-search-input">

                              <button class="custom-search-botton" type="button" data-toggle="modal"
                                data-target="#exampleModalProductm" @click="detect_index(index)">
                                <i class="fa fa-plus-circle"></i></button>
                            </div> -->



                                                    </td>
                                                    <td>


                                                        <!-- <div>
                                <input type="text" v-model="sto_pro.text" id="desc" class="form-control" />
                              </div> -->


                                                        <div class="custom-search">

                                                            <input style="background-color: beige;font-size: 15px;"
                                                                :id="'OpeningInventory_storem_tree' + index" type="text"
                                                                readonly class="custom-search-input">
                                                            <input :id="'OpeningInventory_storem_tree_id' + index" type="hidden"
                                                                readonly class="custom-search-input">


                                                            <button class="custom-search-botton" type="button"
                                                                data-toggle="modal" data-target="#exampleModalStorem"
                                                                @click="detect_index(index)">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </button>
                                                        </div>



                                                    </td>
                                                    <td>

                                                        {{ sto_pro.status }}


                                                    </td>

                                                    <td>

                                                        {{ sto_pro.desc }}


                                                    </td>



                                                    <td>
                                                        <div>

                                                            <!-- <select v-on:change="calculate()" style="background-color: beige;" v-model="unit[index]"
                                name="type" :id="'select_unit' + index" class="form-control" required>

                              </select> -->


                                                            <select v-on:change="set_unit_price(index), calculate()"
                                                                style="background-color: beige;" v-model="unit[index]"
                                                                name="type" :id="'select_unit' + index"
                                                                class="form-control" required>

                                                                <option v-for="ssu in sto_pro.unit"
                                                                    v-bind:value="[ssu.id, ssu.rate, ssu.cost]">
                                                                    {{ ssu.name }}
                                                                </option>

                                                            </select>





                                                        </div>
                                                    </td>


                                                    <td>
                                                        <input v-on:input="calculate()" style="background-color: beige;"
                                                            type="number" v-model="unit_price[index]" id="qty"
                                                            class="form-control" />
                                                    </td>
                                                    <td>
                                                        <input style="background-color: beige;" @input="calculate()"
                                                            type="number" v-model="qty[index]" id="qty"
                                                            class="form-control" />
                                                    </td>


                                                    <td>
                                                        <input type="number" @input="calculate()" v-model="total[index]"
                                                            :id="'total_row' + index" class="form-control" />


                                                    </td>

                                                    <td>
                                                        <input name="expiry_date" type="date" v-model="expiry_date"
                                                            class="form-control" />

                                                    </td>




                                                    <!-- <td v-if="index == 1" rowspan="3">

                            <button class="btn btn-info btn-sm waves-effect btn-agregar"
                              v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></button>

                            <button class="btn btn-info btn-sm waves-effect btn-agregar"
                              v-on:click="disComponent(count)">
                              <i class="fa fa-minus-circle"></i></button>



                          </td> -->
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

                                            <i class="fa-solid fa-file-export "
                                                style="font-size: 24px; color: #63E6BE;"></i>
                                        </button>

                                        <button @click="imports_excel()">

                                            <i class="fa-solid fa-file-import "
                                                style="font-size: 24px; color: #B197FC;"></i>
                                        </button>

                                        <input type="search" autocomplete="on" name="search" data-toggle="dropdown"
                                            role="button" aria-haspopup="true" aria-expanded="true" placeholder="بحث "
                                            v-model="word_search" @input="get_search()" />
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="wd-15p border-bottom-0">الرقم التسلسلي</th>
                                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                                    <th class="wd-15p border-bottom-0">المخزن</th>
                                                    <th class="wd-15p border-bottom-0">الحاله</th>
                                                    <th class="wd-15p border-bottom-0">المواصفات والطراز</th>
                                                    <th class="wd-15p border-bottom-0">الكميه </th>
                                                    <th class="wd-15p border-bottom-0">التكلفه</th>
                                                    <th class="wd-15p border-bottom-0">الاجمالي</th>
                                                    <th class="wd-15p border-bottom-0">العمليات</th>
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



                                                        </div>


                                                    </td>

                                                    <td>{{ opening_inventury.cost }}</td>
                                                    <td>{{ opening_inventury.total }}</td>

                                                    <td>

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
        this.first_row = 0;
        this.showtree('store', 'tree_store');
        this.showtree('product', 'tree_product');
        this.showtree('storem', 'tree_store');
        // this.showtree('productm', 'tree_product');
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
                    date: this.date,
                    grand_total: this.grand_total,
                    sub_total: this.sub_total,
                    paid: this.paid,
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

                    this.statuses = data.statuses;
                    this.store_products = data.store_products;

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

                    toastMessage("تم اتمام عمليه التصدير");
                    this.$router.go(0);
                })
                .catch(error => {


                });
        },
        imports_excel() {

            axios
                .post(`/import_opening_inventuries`)
                .then(function (response) {
                    toastMessage("تم اتمام عمليه الاستيراد");
                    this.$router.go(0);

                    // this.list();




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
