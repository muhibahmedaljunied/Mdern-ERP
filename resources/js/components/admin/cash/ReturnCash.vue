<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="h3"> مرتجع صرف</span>
                            </div>


                            <div class="card-body">


                                <div class="row">

                                    <div class="col-md-2">


                                        <label for="date">رقم الفاتوره</label><br />


                                        <div>{{ data.cash_id }}</div>


                                    </div>
                                    <div class="col-md-2">


                                        <label for="cliente"> العميل</label>



                                        <div>{{ data.customer_name }}</div>

                                    </div>
                                    <div class="col-md-4">
                                        <label for="pagoPrevio">اجمالي الفاتوره</label>

                                        <div>{{ data.grand_total }}</div>



                                    </div>


                                </div>

                                <hr>
                                <br>
                                <div class="row">



                                    <div class="col-md-2">


                                        <label for="date">التاريخ</label><br />

                                        <input style="background-color: beige;" name="date" type="date"
                                            v-model="dateselected" class="form-control" />



                                    </div>
                                    <div class="col-md-2" v-if="data.payment_status == 'pendding'">

                                        <label for="date">طريقه الدفع</label><br />

                                        <input style="background-color: beige;" name="date" type="text" value="أجل"
                                            class="form-control" />



                                    </div>



                                    <div class="col-md-2" v-else>

                                        <label for="date">طريقه الدفع</label><br />


                                        <select style="background-color: beige;" name="forma_pago" class="form-control"
                                            id="forma_pago" v-model="Way_to_pay_selected" v-on:change="onwaychange">


                                            <option v-bind:value="1">نقد</option>
                                            <option v-bind:value="2">أجل</option>
                                            <option v-bind:value="3">بنك</option>

                                        </select>


                                    </div>

                                    <div class="col-md-4">
                                        <h5 class="card-title"> الحساب</h5>
                                        <div class="custom-search">

                                            <input :id="'CashReturn_account_tree'" type="text"
                                                class="custom-search-input">
                                            <input :id="'CashReturn_account_tree_id'" type="hidden"
                                                class="custom-search-input">
                                            <!-- <input :id="'CashReturn_store_tree_id'" type="hidden"  class="custom-search-input"> -->


                                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalAcoount">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="cliente"> الحساب التفصيلي</label>


                                        <select class="form-control" style="background-color: beige;" name="forma_pago"
                                            id="select_account_CashReturn_group">

                                        </select>

                                    </div>







                                </div>
                                <hr>
                                <br>

                                <div class="row">



                                    <div class="col-md-4">
                                        <label for="cliente">المخزن المرتجع البه</label>

                                        <div class="custom-search">

                                            <input style="background-color: beige;" :id="'CashReturn_store_tree'"
                                                type="text" class="custom-search-input">
                                            <input :id="'CashReturn_store_tree_id'" type="hidden">
                                            <input :id="'select_account_CashReturn'" type="hidden"
                                                class="custom-search-input">
                                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                                @click="detect_index(index)" data-target="#exampleModalStore">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>

                                    </div>

                                    <!-- <div class="col-md-2" v-if="show_treasury == true">

                    <label for="pagoPrevio">الصندوق</label>
                    <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>
                  <div class="col-md-2" v-if="show_bank == true">

                    <label for="pagoPrevio">البنك</label>
                    <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div> -->

                                    <div class="col-md-4">
                                        <label for="pagoPrevio">البيان</label>


                                        <input class="form-control" style="background-color: beige;" type="text"
                                            v-model="description">


                                    </div>

                                    <div class="col-md-4">
                                        <label for="pagoPrevio">اختيار الكل</label> <br>

                                        <input v-model="check_state_all" @change="check_all_return()" type="checkbox"
                                            class="btn btn-info waves-effect">
                                    </div>

                                </div>
                                <hr>
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>الرقم</th> -->
                                                        <th>اسم المنتج</th>

                                                        <th> المواصفات والطراز</th>
                                                        <th>الحاله</th>
                                                        <th>المخزن</th>
                                                        <th>المخزن المرتجع البه</th>
                                                        <!-- <th>الكميه المتوفره</th> -->
                                                        <th>الكميه المصروفه</th>

                                                        <th>الكميه المسموح ارجاعها</th>

                                                        <th> الوحده </th>

                                                        <th> التكلفه </th>
                                                        <th>الكميه المرتجعه الفعليه </th>
                                                        <th>قيمه المرتجع</th>
                                                        <th>ملاحظه</th>

                                                    </tr>
                                                </thead>
                                                <tbody v-if="detail && detail.length > 0">
                                                    <tr v-for="(cash_details, index) in detail" :key="index">
                                                        <input v-model="id = cash_details.cash_id" type="hidden"
                                                            name="name" id="name" class="form-control" />

                                                        <td>


                                                            <div>
                                                                <input type="hidden" v-model="cash_details.text"
                                                                    id="desc" class="form-control" />

                                                                <span>{{ cash_details.text }}</span>
                                                                <span style="color: blue;" v-if="cash_details.kk"
                                                                    v-for="ss in cash_details.kk">


                                                                    -{{ ss.value }}





                                                                </span>
                                                            </div>




                                                        </td>

                                                        <td>{{ cash_details.desc }}</td>
                                                        <td>{{ cash_details.status }}</td>
                                                        <td>{{ cash_details.store }}
                                                            <input :id="'select_account_CashReturn' + index"
                                                                type="hidden">
                                                        </td>

                                                        <td>
                                                            <div class="custom-search">

                                                                <input style="background-color: beige;"
                                                                    :id="'CashReturn_storem_tree' + index" type="text"
                                                                    class="custom-search-input">
                                                                <input :id="'CashReturn_storem_tree_id' + index"
                                                                    type="hidden">

                                                                <button class="custom-search-botton" type="button"
                                                                    data-toggle="modal" @click="detect_index(index)"
                                                                    data-target="#exampleModalStorem">
                                                                    <i class="fa fa-plus-circle"></i></button>
                                                            </div>
                                                        </td>

                                                        <td>
                                                            <div v-for="temx in cash_details.qty_after_convert['qty']">



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

                                                        <td>

                                                            <div
                                                                v-for="temx in cash_details.qty_after_convert['qty_remain']">



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
                                                        <td>

                                                            <select v-on:change="set_unit_price(index), calculate()"
                                                                style="background-color: beige;"
                                                                :id="'select_unit' + index" v-model="unit[index]"
                                                                name="type" class="form-control" required>

                                                                <option v-for="unit in cash_details.unit"
                                                                    v-bind:value="[unit.unit_id, unit.rate, unit.cost]">
                                                                    {{ unit.name }}
                                                                </option>


                                                            </select>


                                                        </td>


                                                        <td>
                                                            <input v-model="unit_price[index]" type="hidden"
                                                                class="form-control input_cantidad"
                                                                onkeypress="return " />

                                                            {{ unit_price[index] }}

                                                        </td>


                                                        <td>
                                                            <div class="form-group">
                                                                <input @input="calculate()"
                                                                    style="background-color: beige;"
                                                                    v-model="qty[index]" type="number"
                                                                    class="form-control" />




                                                            </div>
                                                        </td>

                                                        <td>
                                                            <input @input="calculate()" type="number"
                                                                v-model="total[index]" :id="'total_row' + index"
                                                                class="form-control" />
                                                        </td>
                                                        <td>

                                                            <span style="color: red;"
                                                                :id="'message_validation' + index"></span>

                                                        </td>

                                                    </tr>








                                                </tbody>
                                                <tbody v-else>
                                                    <tr>
                                                        <td align="center" colspan="12">
                                                            <h3 style="color:red">
                                                                لايوجد كمبه متوفره في المخزن
                                                            </h3>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>


                                <br>
                                <hr>
                                <div class="row">
                                    <div class="col-md-8">







                                        <div class="row">

                                            <div class="col-md-12"> <label for="pagoPrevio">نوع العمله</label>
                                                <select class="form-control" name="forma_pago" id="forma_pago">
                                                    <option v-bind:value="2">ريال يمني </option>
                                                    <option v-bind:value="1">دولار امريكي</option>
                                                    <option v-bind:value="2">ريال سعودي </option>
                                                </select>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-md-12">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <label for="pagoPrevio">اجمالي الكميه</label>

                                                <input @input="calculate()" type="text" id="cantidad_total"
                                                    v-model="total_quantity" class="form-control" />
                                            </div>



                                            <div class="col-md-12">
                                                <label for="subTotal">الاجمالي</label>

                                                <input @input="calculate()" type="text" id="subtotal_general"
                                                    name="subtotal_general" v-model="grand_total"
                                                    class="form-control" />
                                                <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf"
                                                    value="0.00" />
                                            </div>

                                            <div class="col-md-12" v-show="show">
                                                <label for="pagoPrevio">المدفوع</label>
                                                <input @input="calculate()" class="form-control" type="text" id="paid"
                                                    v-on:input="credit" v-model="paid" style="color: red" />

                                            </div>

                                            <div class="col-md-12" v-show="show">
                                                <label for="pagoPrevio">المتبقي</label>
                                                <input @input="calculate()" type="text" id="remaining"
                                                    class="form-control" v-model="remaining" />

                                            </div>
                                            <div class="col-md-12">
                                                <div class="text-center">
                                                    <a style="
                                width: 100%;
                                padding-top: 0.5em;
                                padding-bottom: 0.5em;
                                font-size: 18pt;" href="javascript:void" @click="Add_return()"
                                                        class="btn btn-info waves-effect waves-light" id="pagar">
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
        </section>

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

        <div class="modal fade" id="exampleModalStorem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
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
    </div>
</template>
<script>
import operation from '../../../operation.js';
import tree from '../../../tree/tree.js';
export default {
    mixins: [operation, tree],
    data() {


        return {

            check_state_all: '',
            count: 1,
            description: '',
            paid: 0,
            remaining: 0,
            customers: '',
            Way_to_pay_selected: 1,
            show_treasury: true,
            show_bank: false,
            not_qty: true,
            message_check: false,
            text_message: 0,
        };
    },
    props: ['data'],

    mounted() {
        this.table = 'cash_details';
        this.type = 'CashReturn';
        this.type_refresh = 'increment';


        this.type_of_tree = 1;
        let uri = `/cash_details_in_return/${this.data.cash_id}`;
        this.axios.post(uri, { id: this.data.cash_id, table: this.table, operation: 'ReturnOperationQty' }).then((response) => {
            console.log(response);
            this.detail = response.data.details;
            this.treasuries = response.data.treasuries;
        });

        this.first_row = 0;
        // -------------------------------
        this.showtree('store', 'tree_store');
        this.showtree('storem', 'tree_store');
        this.showtree('account', 'tree_account');

    },

    methods: {

        // check_qty(qty, unit, qty_remain) {

        //   var producter_qty = 0;



        //   if (producter_qty > qty_remain) {

        //     toastMessage('فشل', "الكميه المدخله اكبر من المسموحه", 'error');
        //     return 0;

        //   }



        //   if (producter_qty <= 0) {

        //     toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
        //     return 0;

        //   }


        //   return 1;
        // },

        check_data(i) {


            console.log(this.qty[i], this.unit[i][1], this.detail[i].avilable_qty, this.detail[i].qty);

            if ((this.qty[i] * this.unit[i][1]) > this.detail[i].avilable_qty) {


                $(`#message_validation${i}`).html("كميه المرتجع اكبر من المتوفره");

                return 0;
            }

            if ((this.qty[i] * this.unit[i][1]) > this.detail[i].qty) {



                $(`#message_validation${i}`).html("كميه المرتجع اكبر من المصروف");
                return 0;
            }

            if ((this.qty[i] * this.unit[i][1]) > this.detail[i].qty_remain) {


                $(`#message_validation${i}`).html("كميه المرتجع اكبر من المسموح");
                return 0;
            }
            $(`#message_validation${i}`).html("");
            return 1;







        },


        // check_all_return() {




        //   for (let index = 0; index < this.detail.length; index++) {

        //     if (this.check_state_all == true) {


        //       this.check_state[index] = true;

        //     } else {

        //       this.check_state[index] = false;
        //     }

        //     this.detail.forEach(element => {

        //       this.calculate_total(index,element);
        //     });





        //   }




        // },
        set_values() {

            this.counts[this.row_counter] = this.row_counter;
            if (!this.storem[this.row_counter]) {

                this.storem_account[this.row_counter] = this.detail[this.row_counter].store_account_id;
                this.storem[this.row_counter] = this.detail[this.row_counter].store_id;

            }





        },
        onwaychange(e) {
            this.paid = 0;
            this.remaining = 0;
            let input = e.target;
            this.payment_type = input.value;
            if (input.value == 2) {
                this.show = true;
                this.remaining = this.grand_total;
            } else {
                this.show = false;
            }


            if (input.value == 1) {
                this.show_treasury = true;
                this.show_bank = false;
                this.paid = this.grand_total;
            }

            if (input.value == 3) {
                this.show_bank = true;
                this.show_treasury = false;
                this.paid = this.grand_total;
            }
        },
        Add_return() {




            if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

                this.paid = this.grand_total;

            }


            this.axios
                .post(`/cashreturn`, {


                    type: this.type,
                    count: this.count,
                    unit: this.unit,
                    qty: this.qty,
                    total: this.total,
                    credit: {
                        account_id: $(`#CashReturn_account_tree_id`).val(),
                        value: this.grand_total,
                        account_details: $(`#select_account_${this.type}_group`).val(),

                    },
                    debit: {

                        account_id: this.account_in_list,
                        value: this.total,
                        account_details: this.store,

                    },
                    type_daily: 'cashreturn',
                    payment_type: this.Way_to_pay_selected,
                    daily_index: 0,
                    description: this.description,
                    type_refresh: this.type_refresh,
                    customer_id: this.customer[0],
                    customer_name: this.customer[1],
                    treasury: this.treasury[0],
                    type: this.type,
                    old: this.detail,
                    date: this.dateselected,
                    cash_id: this.id,
                    grand_total: this.grand_total,
                    remaining: this.remaining,
                    paid: this.paid,





                })
                .then((response) => {
                    console.log(response);

                    if (response.data.status != 0) {

                        this.seen = false;
                        toastMessage("تم الارجاع بنجاح");
                        // this.$router.go(-1);

                    } else {

                        toastMessage("فشل", response.data.message);




                    }


                });
            // }


        },




    }
};
</script>
