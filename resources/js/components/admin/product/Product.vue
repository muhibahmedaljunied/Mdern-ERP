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


<<<<<<< HEAD
=======
                <span style="font-size: x-large"> شجره المنتجات</span>

              </div> -->
              <!-- <span> *كيف يتم التعامل مع تعدد الوحدات في حاله المنتجات المتباينه وضبط سعر الشراء وسعر البيع وكذلك ضبط
                الاجزاء للوحدات مقارنه مع الانظمه الاخري مثل mazerp
              </span>

              <span> *هل يمكن تفعيل المخازن من الاعدادات في نظام mazerp تأكد لانه في الفيديو هذا موجود
              </span>
              <span>
                *كيف يتم التعامل مع الفروع هل تحدد لاول مره فقط ثم تعين اعتمادا علي ذلك في الواجهات والعمليات وكيف يتم
                ربط الفروع بباقي جداول النظام تتبع smacc @ MazErp 
              </span> -->

>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5
              <div class="card-body">

                <div class="row justify-content-left">
                  <div class="col-md-12">
                    <div class="card">




                      <div class="card-body">


                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-md-8">

                              <input style="background-color:azure;" class="form-control" type="text" id="ricerca-enti"
                                placeholder="بحث" aria-describedby="search-addon">



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




<<<<<<< HEAD
=======
                  <div class="col-md-2">
                    <label for="Product">رقم المنتج</label>
                    <input style="background-color: beige;" type="text" id='product_number' class="form-control"
                      required readonly />
>>>>>>> a4f4730e457ae0c8f9eb984b1a9809da003af1b5


                                <div class="row">

                                  <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                      <thead>

                                        <tr>




                                        </tr>
                                      </thead>
                                      <tbody v-if="showCatProduct && showCatProduct.length > 0">

                                        <tr v-for="(productss, index) in showCatProduct" :key="index">



                                          <template>
                                            <div class="row">

                                              <div class="col-md-2">

                                                {{ index + 1 }}

                                              </div>
                                              <div class="col-md-2">
                                                {{ productss.text }}

                                                <div class="col-md-12"
                                                  v-for="produc_option in productss['product_family_attribute']">


                                                  <span v-for="option in produc_option.family_attribute_option">
                                                    {{ option.value }}
                                                  </span>

                                                </div>

                                              </div>

                                              <div class="col-md-8">

                                                <template
                                                  v-for="product_family in productss['product_family_attribute']">

                                                  <div class="row">

                                                    <div class="row">

                                                      <div class="col-md-4">

                                                        <div class="col-md-12">
                                                          الكميه: {{ product_family.qty }}

                                                        </div>

                                                        <div class="col-md-12">
                                                          السعر:{{ product_family.price }}

                                                        </div>

                                                        <!-- <div class="col-md-12"
                                v-for="option in product_family.family_attribute_option">
                                <p>{{ option.name }}:{{ option.value
                                }}</p>
                              </div> -->
                                                      </div>

                                                      <div class="col-md-2">

                                                        <img class="card-img"
                                                          :src="`/Ecommerce/assets/upload/${product_family.image}`"
                                                          alt="Product Image" height='200px' />



                                                      </div>

                                                      <div class="col-md-6">



                                                        <button type='button' class="btn btn-danger btn-sm"><i
                                                            class="fa fa-trash"></i></button>
                                                        <router-link
                                                          :to="{ name: 'edit_product', params: { data: productss } }"
                                                          class="btn btn-success btn-sm"><i
                                                            class="fa fa-edit"></i></router-link>





                                                      </div>


                                                    </div>


                                                  </div>


                                                </template>

                                              </div>




                                            </div>
                                            <hr>
                                          </template>

                                        </tr>

                                      </tbody>
                                      <tbody v-else>
                                        <tr>
                                          <td style="text-align: center;" colspan="7">
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
      desc:'',
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


    this.att_family = Array.from(Array(this.count), () => new Array(this.count_attributes))

    this.axios.post('/show_product').then(response => {

      console.log(response.data.product);
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
