<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card text-right">

                    <div class="card-header">
                        <h1 class="card-title"> التسعيره</h1>
                    </div>

                    <div class="card-body">

                        <div class="card text-right">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">

                                        <h5 class="card-title"> المنتج</h5>
                                        <div class="custom-search">

                                            <input :id="'Price_product_tree' + index" type="text" readonly
                                                class="custom-search-input">
                                            <input :id="'Price_product_tree_id' + index" type="hidden" readonly
                                                class="custom-search-input">

                                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                                    class="fa fa-plus-circle"></i></button>
                                        </div>

                                    </div>
                                    <div class="col-md-4">

                                        <h5 class="card-title"> المخزن</h5>
                                        <div class="custom-search">

                                            <input :id="'Price_product_tree' + index" type="text" readonly
                                                class="custom-search-input">
                                            <input :id="'Price_product_tree_id' + index" type="hidden" readonly
                                                class="custom-search-input">

                                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                                    class="fa fa-plus-circle"></i></button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card text-right">

                            <div class="card-body">

                                <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                                    <thead>
                                        <tr>
                                            <th>الرقم التسلسلي</th>
                                            <th>المنتج</th>

                                            <!-- <th>المخزن</th> -->
                                            <th>الحاله</th>
                                            <th> المواصفات والطراز</th>

                                            <th>الوحده</th>
                                            <th>التكلفه</th>
                                            <th> اخر سعر توريد</th>
                                            <th>سعر التجزيه</th>
                                            <th>سعر الجمله</th>



                                            <th>سعر خاص</th>

                                        </tr>
                                    </thead>
                                    <tbody v-if="store_products && store_products.length > 0">
                                        <!-- <tr v-for="(products, index) in product"> -->

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
                                            <!-- <td>




                                                <div>
                                                    <input type="hidden" v-model="sto_pro.text" id="desc"
                                                        class="form-control" />

                                                    <span>{{ sto_pro.text }}</span>
                                                    <span style="color: blue;" v-if="sto_pro.kk"
                                                        v-for="ss in sto_pro.kk">


                                                        -{{ ss.value }}





                                                    </span>
                                                </div>



                                            </td> -->

                                            <td>
                                                <div>
                                                    <div>
                                                        {{ sto_pro.name }}

                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div>
                                                    {{ sto_pro.desc }}

                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ sto_pro.unit_name }}

                                                </div>
                                            </td>



                                            <td>


                                                <div>
                                                    <input style="background-color: beige;" type="number"
                                                        v-model="sto_pro.cost" id="qty" class="form-control" />

                                                </div>






                                            </td>


                                            <td>
                                                <input style="background-color: beige;" type="number"
                                                    v-model="sto_pro.supply_price" id="qty" class="form-control" />
                                            </td>
                                            <td>
                                                <input style="background-color: beige;" type="number"
                                                    v-model="sto_pro.small_price" id="qty" class="form-control" />
                                            </td>
                                            <td>
                                                <input style="background-color: beige;" type="number"
                                                    v-model="sto_pro.big_price" id="qty" class="form-control" />
                                            </td>
                                            <td>
                                                <input style="background-color: beige;" type="number"
                                                    v-model="sto_pro.private_price" id="qty" class="form-control" />
                                            </td>

                                            <tr>

                                                <td colspan="8">

                                                </td>
                                                <td>
                                                    <a href="javascript:void" @click="Add()" class="btn btn-primary"><span>تاكيد
                                                        العمليه</span></a>
                                                </td>
                                            </tr>
                                      






                                            <!-- <td>
<input v-model="check_state[index]" @change="add_one_sale(product, index)" type="checkbox"
class="btn btn-info waves-effect">
</td> -->

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
                                    <tbody v-else>
                                        <tr>
                                            <td align="center" colspan="8">
                                                <h3>
                                                    لايوجد بيانات
                                                </h3>
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                                <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                            
                            </div>
                            <div class="card-footer text-muted">
                                2 days ago
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
            </div>
        </section>
    </div>
</template>
<script>
import operation from '../../../operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
    mixins: [
        operation,
        tree
    ],
    data() {
        return {
            index: 0,
            // price_all: [],
            // supply_price: [],
            // small_price: [],
            // big_price: [],
            // private_price: [],


        };
    },

    mounted() {
        this.type_of_tree = 1;
        this.list();
        this.type = 'Price';
        this.showtree('product', 'tree_product');
        this.showtree('store', 'tree_store');


    },

    methods: {




        calculate_price(price, index) {
            // console.log(this.unit[index][2]);


            this.total[index] = price * this.unit[index][1];



        },
        list(page = 1) {

            this.axios.post(`/Warehouse/pricing?page=${page}`).then((responce) => {


                console.log(responce.data);
                this.all_products = responce.data.products.data;

            });


        },





        Add(

        ) {

            this.axios
                .post(`/store_price`, {

                    // count: this.counts,
                    data: this.store_products
                    // unit: this.unit,
                    // cost: this.cost,
                    // supply_price: this.supply_price,
                    // small_price: this.small_price,
                    // big_price: this.big_price,
                    // private_price: this.private_price,







                })
                .then((response) => {

                    // console.log(response);




                    // if (response.data.status == "success") {

                    //     toastMessage('success', "تم البيع!", 'success');

                    // }
                    // this.$router.go(0);
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
