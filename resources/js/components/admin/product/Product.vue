<template>
    <!-- row opened -->

    <div class="container-fluid">
        <div class="card">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                    <span class="h2">المنتجات</span>
                </div>
            </div>

            <div class="card-body">
                <div class="row row-sm">

                    <div class="col-xl-12">
                        <div class="card">


                            <div class="card-body">

                                <div class="row justify-content-left">
                                    <div class="col-md-12">
                                        <div class="card">




                                            <div class="card-body">


                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <div class="col-md-8">

                                                            <input style="background-color:azure;" class="form-control"
                                                                type="text" id="ricerca-enti" placeholder="بحث"
                                                                aria-describedby="search-addon">



                                                        </div>







                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xs-12" id="treeview_json_products">

                                                            <div id="test">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">

                                                <div class="row">

                                                    <div class="col-md-12">

                                                        <div class="card">


                                                            <div class="card-body">






                                                                <div class="row">

                                                                    <div class="table-responsive">
                                                                        <table class="table text-md-nowrap"
                                                                            id="example1">
                                                                            <thead>

                                                                                <tr>
                                                                                    <th>الرقم التسلسلي</th>
                                                                                    <th>المنتج</th>
                                                                                    <th>الطراز</th>
                                                                                    <th>الحاله</th>




                                                                                </tr>
                                                                            </thead>
                                                                            <tbody
                                                                                v-if="showCatProduct && showCatProduct.length > 0">

                                                                                <tr v-for="(productss, index) in showCatProduct"
                                                                                    :key="index">


                                                                                    <td> {{ index + 1 }}</td>
                                                                                    <td>
                                                                                        <div>
                                                                                            <input type="hidden"
                                                                                                v-model="productss.text"
                                                                                                id="desc"
                                                                                                class="form-control" />

                                                                                            <span>{{
                                                                                                productss.text
                                                                                            }}</span>
                                                                                            <span style="color: blue;"
                                                                                                v-if="productss.kk"
                                                                                                v-for="ss in productss.kk">


                                                                                                -{{ ss.value }}





                                                                                            </span>
                                                                                        </div>
                                                                                    </td>

                                                                                    <td>{{ productss.desc }}</td>

                                                                                    <td>{{ productss.status }}</td>
                                                                                    <!-- <td>
                                                                                        <img class="card-img"
                                                                                            :src="`/Ecommerce/assets/upload/${product_family.image}`"
                                                                                            alt="Product Image"
                                                                                            height='200px' />
                                                                                    </td> -->


                                                                                </tr>

                                                                            </tbody>
                                                                            <tbody v-else>
                                                                                <tr>
                                                                                    <td style="text-align: center;"
                                                                                        colspan="7">
                                                                                        لايوجد اي بيانات
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


                            </div>
                        </div>
                    </div>









                </div>



            </div>




        </div>
    </div>
</template>

<script>


import operation from '../../../operation1.js';
import tree from '../../../tree/tree.js';

export default {
    mixins: [tree, operation],

    data() {
        return {
            products: '',

            showCatProduct: '',

            product: '',
            qty: [],
            price: [],
            desc: '',
            description: [],
            attr_array: [],
            discount: [],
            word_search: '',
            New: '',
            featured: '',
            status: '',
            image: '',
            categoryselected: '',
            parentselected: 0,
            jsonTreeData: '',
            attribute_families: '',
            family_attribute: '',
            attributes: '',
            attr_array: [],
            att_family: '',
            // att_all_family: [],
            product_id: '',
            errors: '',
            success: '',
            // filename: '',
            counts: [],
            count: 1,
            count_attributes: 1,
            file: [],

        }
    },
    mounted() {


        this.type = 'Product';
        this.att_family = Array.from(Array(this.count), () => new Array(this.count_attributes))

        this.axios.post('/show_product').then(response => {

            // console.log(response.data.product);
            this.showCatProduct = response.data.product;
            // this.$root.logo = 'Product'

        })
    },
    created() {


        this.showtree('products', 'tree_product');
    },

    methods: {


        get_attribute() {


            var gf = this;
            this.axios.post('/product/get_attributes',
                {
                    id: this.family_attribute
                }).then(function (response) {


                    console.log(response.data.attributes);
                    gf.count_attributes = response.data.count_attributes
                    gf.attributes = response.data.attributes;

                })
                .catch(function (error) {
                    // currentObj.output = error;
                });

            return

        },








    },
};







</script>
<style>
legend {

    font-weight: lighter;
    color: cadetblue;
}
</style>
