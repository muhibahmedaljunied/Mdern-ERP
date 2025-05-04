<template>
    <div class="wrapper">
        <div class="container-fluid">


            <div class="card">
                <div class="card-header">
                    <h3>فاتوره مبيعات <span id="codigo"></span></h3>
                </div>
                <div class="card-body">

                    <div class="row">

                        <div class="card text-right">

                            <div class="card-body">
                                <div class="row">






                                    <div class="col-md-4">
                                        <h5 class="card-title"> المنتج</h5>
                                        <div class="custom-search">

                                            <input :id="'Sale_product_tree'" type="text" class="custom-search-input">
                                            <input :id="'Sale_product_tree_id'" type="hidden"
                                                class="custom-search-input">

                                            <button @click="detect_index(null)" class="custom-search-botton"
                                                type="button" data-toggle="modal" data-target="#exampleModalProduct">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="card-title"> المخزن</h5>
                                        <div class="custom-search">

                                            <input :id="'Sale_store_tree'" type="text" class="custom-search-input">
                                            <input :id="'Sale_store_tree_id'" type="hidden" class="custom-search-input">
                                            <input :id="'select_account_Sale'" type="hidden"
                                                class="custom-search-input">


                                            <button @click="detect_index(null)" class="custom-search-botton"
                                                type="button" data-toggle="modal" data-target="#exampleModalStore">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>


                                </div>
                                <br />
                                <hr>
                                <div class="row">

                                    <div class="col-md-2">
                                        <label for="FormaPago">طريقه الدفع</label>
                                        <select style="background-color: beige;" name="forma_pago" class="form-control"
                                            id="forma_pago" v-model="Way_to_pay_selected" v-on:change="onwaychange">
                                            text

                                            <option v-bind:value="1">نقد</option>
                                            <option v-bind:value="2">أجل</option>
                                            <option v-bind:value="3">بنك</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3" v-if="Way_to_pay_selected != 2">
                                        <label for="cliente"> العميل</label>

                                        <select class="form-control" style="background-color: beige;" v-model="customer"
                                            id="customer">
                                            <option v-for="cus in customers" v-bind:value="[cus.id, cus.name]">
                                                {{ cus.name }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-2"> <label for="pagoPrevio">نوع العمله</label>
                                        <select name="forma_pago" class="form-control" id="forma_pago">
                                            <option v-bind:value="2">ريال يمني </option>
                                            <option v-bind:value="1">دولار امريكي</option>
                                            <option v-bind:value="2">ريال سعودي </option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="date">التاريخ</label><br />

                                        <input style="background-color: beige;" name="date" type="date" v-model="date"
                                            class="form-control" />
                                    </div>








                                </div>
                                <br />
                                <hr>

                                <div class="row">


                                    <div class="col-md-4">
                                        <h5 class="card-title"> الحساب</h5>
                                        <div class="custom-search">

                                            <input :id="'Sale_account_tree'" type="text" class="custom-search-input">
                                            <input :id="'Sale_account_tree_id'" type="hidden"
                                                class="custom-search-input">
                                            <!-- <input :id="'Sale_store_tree_id'" type="hidden"  class="custom-search-input"> -->


                                            <button @click="detect_index(null)" class="custom-search-botton"
                                                type="button" data-toggle="modal" data-target="#exampleModalAcoount">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="cliente"> الحساب التفصيلي</label>


                                        <select class="form-control" style="background-color: beige;" name="forma_pago"
                                            id="select_account_Sale_group">

                                        </select>

                                    </div>



                                    <div class="col-md-4">
                                        <label for="pagoPrevio">البيان</label>


                                        <input class="form-control" style="background-color: beige;" type="text"
                                            v-model="description">


                                    </div>




                                </div>



                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="card text-right">

                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-bordered text-right"
                                            style="width: 100%; font-size: x-large">
                                            <thead>
                                                <tr>
                                                    <!-- <th>Code</th> -->
                                                    <th class="wd-5p border-bottom-0">الرقم التسلسلي</th>
                                                    <th class="wd-15p border-bottom-0">المنتج</th>
                                                    <!-- <th>الباركود</th> -->
                                                    <th class="wd-5p border-bottom-0">المخزن</th>
                                                    <th class="wd-5p border-bottom-0">الحاله</th>
                                                    <th class="wd-10p border-bottom-0"> المواصفات والطراز</th>
                                                    <th class="wd-10p border-bottom-0">الكميه المنوفره</th>
                                                    <th class="wd-5p border-bottom-0">الوحده</th>
                                                    <!-- <th>التكلفه</th> -->
                                                    <!-- <th>التكلفه</th> -->
                                                    <th class="wd-5p border-bottom-0"> سعر البيع </th>

                                                    <th class="wd-10p border-bottom-0">الكميه</th>
                                                    <th class="wd-10p border-bottom-0">الضريبه</th>
                                                    <th class="wd-10p border-bottom-0">الاجمالي</th>

                                                    <th class="wd-10p border-bottom-0">ملاحظه</th>
                                                    <!-- <th class="wd-10p border-bottom-0">اضافه</th> -->
                                                </tr>
                                            </thead>
                                            <tbody v-if="store_products && store_products.length > 0">
                                                <tr v-for="(product, index) in store_products" :key="index">
                                                    <td>
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td>


                                                        <div>
                                                            <input type="hidden" v-model="product.text" id="desc"
                                                                class="form-control" />

                                                            <span>{{ product.text }}</span>
                                                            <span style="color: blue;" v-if="product.kk"
                                                                v-for="ss in product.kk">


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
                                                        <div id="factura_producto" class="input_nombre">
                                                            {{
                                                                product.store
                                                            }}<input type="hidden" v-model="product.store_id"
                                                                id="store_temporale" />
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div id="factura_producto" class="input_nombre">
                                                            {{ product.status }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div id="factura_producto" class="input_nombre">
                                                            {{ product.desc }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div id="factura_producto" class="input_nombre"
                                                            v-if="product.availabe_qty">


                                                            <div v-for="temx in product.qty_after_convert['quantity']">

                                                                <span v-for="temx2 in temx">


                                                                    <span style="float: right;">
                                                                        {{ temx2[0] }}
                                                                        <span style="color: red;">
                                                                            {{ temx2[1] }}
                                                                        </span>

                                                                    </span>



                                                                </span>



                                                            </div>

                                                        </div>

                                                    </td>


                                                    <td>
                                                        <div id="factura_producto" class="input_nombre">





                                                            <select v-on:change="set_unit_price(index), calculate()"
                                                                style="background-color: beige;"
                                                                :id="'select_unit' + index" v-model="unit[index]"
                                                                name="type" class="form-control" required>

                                                                <option  v-for="unit in product.unit"
                                                                v-bind:value="[unit.unit_id, unit.rate, unit.cost]">
                                                                    {{ unit.name }}
                                                                </option>


                                                            </select>


                                                            <!-- <select
                                                                v-on:change="set_unit_price(index), calculate()"
                                                                v-else style="background-color: beige;"
                                                                :id="'select_unit' + index" v-model="unit[index]"
                                                                name="type" class="form-control" required>

                                                                <option v-for="unit in product.unit"
                                                                    v-bind:value="[unit.unit_id, unit.rate, unit.cost]">
                                                                    {{ unit.name }}
                                                                </option>


                                                            </select> -->





                                                        </div>
                                                    </td>

                                                    <td>


                                                        <input
                                                            v-model="unit_price[index]"
                                                            class="form-control input_cantidad" onkeypress="return "
                                                            />


                                                        <!-- <input v-else v-model="unit_price[index]"
                                                            v-on:input="calculate()"
                                                            class="form-control input_cantidad" onkeypress="return " /> -->
                                                    </td>
                                                    <td>



                                                        <input
                                                            style="background-color: beige;" type="number"
                                                            @input="calculate()" v-model="qty[index]" id="qty"
                                                            class="form-control input_cantidad" onkeypress="return "
                                                             />

                                                        <!-- <input v-else style="background-color: beige;" type="number"
                                                            @input="calculate()" v-model="qty[index]"
                                                            id="qty" class="form-control input_cantidad"
                                                            onkeypress="return " /> -->
                                                    </td>
                                                    <td>
                                                        <input  type="number"
                                                            v-model="tax[index]" id="qty"
                                                            class="form-control input_cantidad" onkeypress="return "
                                                             />

                                                        <!-- <input v-else type="number" v-model="tax[index]" id="qty"
                                                            class="form-control input_cantidad" onkeypress="return "
                                                            @input="calculate()" /> -->
                                                    </td>

                                                    <td>

                                                        <input  type="number"
                                                        @input="calculate()" v-model="total[index]" :id="'total_row' + index"
                                                            class="form-control"  />

                                                        <!-- <input v-else @input="calculate()" type="number"
                                                            v-model="total[index]" :id="'total_row' + index"
                                                            class="form-control" /> -->
                                                    </td>

                                                    <td>

                                                        <span style="color: red;"
                                                            :id="'message_validation' + index"></span>

                                                    </td>
                                                    <!-- <td>
                                                        <input :id="'check_state' + index" v-model="check_state[index]"
                                                            @change="calculate()" type="checkbox"
                                                            class="btn btn-info waves-effect">
                                                    </td> -->

                                                </tr>



                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td align="center" colspan="10">
                                                        <h3> لايوجد بيانات </h3>
                                                    </td>
                                                </tr>
                                            </tbody>



                                        </table>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>

                    <div class="row">

                        <div class="card text-right">

                            <div class="card-body">



                                <div class="row">

                                    <div class="col-md-8">
                                        <div class="row">



                                            <div class="col-md-12" v-show="show">
                                                <label for="pagoPrevio">المدفوع</label>
                                                <input @input="calculate()" type="text" class="form-control"
                                                    v-model="paid" style="color: red" />

                                            </div>
                                            <div class="col-md-12" v-show="show">
                                                <label for="pagoPrevio">المتبقي</label>
                                                <input @input="calculate()" type="text" id="remaining"
                                                    class="form-control" v-model="remaining" />

                                            </div>

                                            <div class="col-md-3">
                                                <label for="pagoPrevio">الخصم (%)</label>
                                                <input type="number" @input="take_discount" v-model="discount" :min="0"
                                                    :max="99" :step="1" oninput="validity.valid||(value='');"
                                                    class="form-control input_cantidad" onkeypress="return " />

                                            </div>



                                            <div class="col-md-4">
                                                <label for="pagoPrevio">تاريخ الاستحقاق</label>
                                                <input type="date" id="remaining" class="form-control" />

                                            </div>




                                            <div class="col-md-12">
                                                <label for="total" class="text-left">المبلغ المستحق</label>
                                                <input @input="calculate()" type="text" class="form-control"
                                                    v-model="To_pay" />

                                                <!-- <div class="col-md-12 letra_calculator_total text-center" id="div_total">
    {{ To_pay }}
  </div> -->
                                                <!-- <input type="hidden" name="total" id="total" v-model="To_pay" /> -->
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-4">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <label for="pagoPrevio">اجمالي الكميه</label>
                                                <input @input="calculate()" type="text" id="cantidad_total"
                                                    class="form-control" v-model="total_quantity" />
                                            </div>

                                            <div class="col-md-12">

                                                <label for="impuestosTotales">اجمالي الضريبه</label>
                                                <input @input="calculate()" type="text" id="impuestos_totales"
                                                    class="form-control" v-model="total_tax" />

                                            </div>


                                            <div class="col-md-12">
                                                <label for="subTotal">الاجمالي (مع الضريبه) <small></small></label>

                                                <input @input="calculate()" type="text" id="subtotal_general"
                                                    name="subtotal_general" class="form-control"
                                                    v-model="grand_total" />
                                                <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf"
                                                    class="form-control" value="0.00" />
                                            </div>


                                            <div class="col-md-12">

                                                <label for="subTotal">الاجمالي (بدون ضريبه) <small></small></label>
                                                <input @input="calculate()" type="text" id="subtotal_general_si"
                                                    name="subtotal_general_si" class="form-control" value="0.00"
                                                    v-model="sub_total" />

                                            </div>

                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a style="
width: 100%;
padding-top: 0.5em;
padding-bottom: 0.5em;
font-size: 18pt;
" href="javascript:void" @click="payment()" class="btn btn-info waves-effect waves-light" id="pagar">
                                                        <i class="fa fa-credit-card"></i></a>
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




        <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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

        <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
        <div class="modal fade" id="exampleModalAcoount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
import tree from '../../../tree/tree.js';
import VueBarcode from '@chenfengyuan/vue-barcode';
export default {
    mixins: [operation, tree],
    components: {

        VueBarcode
    },
    data() {
        // return data;
        return {

            account: '',
            count: 1,
            table: '',
            type: '',
            type_refresh: '',
            note: "",

            Total_quantity: 0,
            total_quantity: 0,
            products: '',
            statuses: '',
            stores: '',
            statuses: '',
            units: '',
            opening: '',
            word_search: '',
            customers: '',
            seen: false,
            id: '',
            index: 0,

            jsonTreeData: '',
            type_of_tree: 1,
            indexselected: '',
            last_nodes: '',
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
            checkselected: '',
            // ------------------------------------------------------------
            description: '',
            store_products: '',
            temporale: 1,
            discount: 0,
            type_payment: 0,
            show: false,


        }
    },
    created() {

    },
    mounted() {
        this.list();
        this.type = 'Sale';
        this.type_refresh = 'decrement';
        this.type_of_tree = 1;
        // this.count_row = this.count;
        this.first_row = 0;

        this.showtree('store', 'tree_store');
        this.showtree('product', 'tree_product');
        this.showtree('account', 'tree_account');


    },
    // watch: {
    //   Way_to_pay_selected(newVal, oldVal) {
    //     $(`#treeview_json_account`).jstree(true).destroy();
    //     this.showtree('account', 'tree_account', this.Way_to_pay_selected);

    //     // console.log(newVal, oldVal);
    //   }
    // },

    methods: {


        list(page = 1) {
            this.axios
                .post(`/sale/newsale?page=${page}`)
                .then(({ data }) => {

                    // this.products = data.products;
                    this.store_products = data.store_products;

                    this.customers = data.customers;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },



        take_discount() {

            this.sub_total *= parseInt(this.discount) / 100;
            // this.sub_total = this.sub_total/100;
        },



        onwaychange(e) {
            this.paid = 0;
            this.remaining = 0;
            let input = e.target;
            this.type_payment = input.value;
            if (input.value == 2) {
                this.show = true;


            } else {
                this.show = false;
            }

            if (input.value == 1) {

                this.paid = this.grand_total;

            }

            if (input.value == 3) {

                this.paid = this.grand_total;

            }

        },

        set_values() {

            this.counts[this.row_counter] = this.row_counter;
            this.store_product_id[this.row_counter] = this.store_products[this.row_counter].id;
            this.storem_account[this.row_counter] = this.store_products[this.row_counter].store_account_id;
            this.storem[this.row_counter] = this.store_products[this.row_counter].store_id;

        },


        // check_qty() {

        //   var availabe_qty = this.detail[this.row_counter].availabe_qty;
        //   var producter_qty = this.qty[this.row_counter] * this.unit[this.row_counter][1];
        //   var message = null;


        //   if (producter_qty > availabe_qty) {


        //     var message = `${this.row_counter}لكميه المدخله اكبر من المتوفره في الصف رقم`;


        //   }

        //   if (this.qty[this.row_counter] <= 0) {

        //     message = `${this.row_counter}تأكد  من الكميه المدخله في الصف رقم`;


        //   }

        //   if (message) {

        //     toastMessage('فشل', message, 'error');
        //     return 0;


        //   } else {

        //     return 1
        //   }



        // },

        check_data(i) {


            console.log('dddddd', this.qty[i] * this.unit[i][1], this.store_products[i].availabe_qty);
            if ((this.qty[i] * this.unit[i][1]) > this.store_products[i].availabe_qty) {


                $(`#message_validation${i}`).html("كميه الادخال اكبر من المتوفره");
                return 0;
            }
            $(`#message_validation${i}`).html('');
            return 1;










        },

        payment() {


            if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

                this.paid = this.grand_total;

            }



            this.axios
                .post(`/paySale`, {
                    type: 'Sale',
                    count: this.count,
                    unit: this.unit,
                    // units: this.units,
                    qty: this.qty,
                    price: this.unit_price,
                    total: this.total,
                    tax: this.tax,
                    old: this.store_products,


                    // -------------this for dailies----------------------------------------------
                    debit: {
                        account_id: $(`#Sale_account_tree_id`).val(),
                        value: this.sub_total,
                        account_details: $(`#select_account_${this.type}_group`).val(),

                    },
                    credit: {
                        // credit_account_id: $(`#select_account_${this.type}`).val(),
                        account_id: this.storem_account,
                        value: this.total,
                        // account_details: this.store,
                        account_details: this.storem,


                    },


                    // -----------------------------------------------------------
                    type_daily: 'sale',
                    payment_type: this.Way_to_pay_selected,
                    daily_index: 0,
                    description: this.description,
                    type_refresh: this.type_refresh,
                    customer_id: this.customer[0],
                    customer_name: this.customer[1],
                    date: this.date,
                    treasury: this.treasury[0],
                    // -------------------
                    grand_total: this.grand_total,
                    sub_total: this.sub_total,
                    discount: this.discount,
                    total_tax: this.total_tax,
                    type_payment: this.type_payment,
                    remaining: this.remaining,
                    paid: this.paid,
                    // -------------------

                    total_quantity: this.total_quantity,
                })
                .then((response) => {

                    // console.log(response);




                    if (response.data.status == "success") {

                        toastMessage('success', "تم البيع!", 'success');

                    }
                    // this.$router.go(0);
                });
        },

    },
};
</script>
